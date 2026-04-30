<?php
// app/Http/Controllers/Admin/PaymentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * نمایش لیست پرداخت‌ها
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'order']);

        // فیلتر بر اساس وضعیت
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فیلتر بر اساس درگاه
        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        // فیلتر بر اساس شماره سفارش
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // جستجو
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('reference_id', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('order', function($q2) use ($search) {
                        $q2->where('order_number', 'like', "%{$search}%");
                    });
            });
        }

        // فیلتر تاریخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // فیلتر مبلغ
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $payments = $query->orderBy('id', 'desc')->paginate(20);

        // آمار داشبورد
        $stats = [
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::where('status', Payment::STATUS_COMPLETED)->count(),
            'failed_payments' => Payment::where('status', Payment::STATUS_FAILED)->count(),
            'pending_payments' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'refunded_payments' => Payment::where('status', Payment::STATUS_REFUNDED)->count(),
            'total_amount' => Payment::where('status', Payment::STATUS_COMPLETED)->sum('amount'),
            'today_payments' => Payment::whereDate('created_at', today())->count(),
            'today_amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                ->whereDate('created_at', today())
                ->sum('amount'),
            'weekly_payments' => Payment::whereBetween('created_at', [now()->subDays(7), now()])->count(),
            'weekly_amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                ->whereBetween('created_at', [now()->subDays(7), now()])
                ->sum('amount'),
            'monthly_payments' => Payment::whereMonth('created_at', now()->month)->count(),
            'monthly_amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        // لیست درگاه‌ها برای فیلتر
        $gateways = PaymentGateway::where('is_active', true)->get();

        return view('admin.payments.list', compact('payments', 'stats', 'gateways'));
    }

    /**
     * نمایش جزئیات یک پرداخت
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'order']);

        // دیکد کردن آیتم‌های سفارش از فیلد JSON
        $orderItems = [];
        if ($payment->order) {
            $orderItems = json_decode($payment->order->order_items, true) ?? [];
        }

        $gatewayTitle = PaymentGateway::where('name', $payment->gateway)->value('title') ?? $payment->gateway;

        // تعریف متغیرهای مورد نیاز در ویو
        $can_refund = $payment->status === Payment::STATUS_COMPLETED;
        $can_delete = in_array($payment->status, [Payment::STATUS_PENDING, Payment::STATUS_FAILED]);

        return view('admin.payments.show', compact(
            'payment',
            'orderItems',
            'gatewayTitle',
            'can_refund',
            'can_delete'
        ));
    }

    /**
     * حذف پرداخت (فقط برای پرداخت‌های در انتظار و ناموفق)
     */
    public function destroy(Payment $payment)
    {
        // بررسی امکان حذف
        if (!in_array($payment->status, [Payment::STATUS_PENDING, Payment::STATUS_FAILED])) {
            return response()->json([
                'success' => false,
                'message' => 'پرداخت‌های موفق و استرداد شده قابل حذف نیستند'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // اگر پرداخت مربوط به سفارشی است، وضعیت سفارش را به pending برگردان
            if ($payment->order && $payment->order->status === 'processing') {
                $payment->order->update(['status' => 'pending']);
            }

            $payment->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تراکنش با موفقیت حذف شد'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف تراکنش: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * استرداد وجه پرداخت
     */
    public function refund(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $payment->amount,
            'reason' => 'nullable|string|max:500'
        ]);

        // بررسی وضعیت پرداخت
        if ($payment->status !== Payment::STATUS_COMPLETED) {
            return response()->json([
                'success' => false,
                'message' => 'فقط پرداخت‌های موفق قابل استرداد هستند'
            ], 400);
        }

        // بررسی استرداد قبلی
        if ($payment->status === Payment::STATUS_REFUNDED) {
            return response()->json([
                'success' => false,
                'message' => 'این پرداخت قبلاً استرداد شده است'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // استرداد وجه از طریق سرویس پرداخت
            $result = $this->paymentService->refundPayment($payment, $request->amount);

            // ثبت دلیل استرداد
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'refund_reason' => $request->reason,
                    'refunded_by' => auth()->id(),
                    'refunded_at' => now(),
                    'refund_amount' => $request->amount
                ])
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'استرداد وجه با موفقیت انجام شد',
                'refund_amount' => $request->amount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment refund failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در استرداد وجه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * خروجی اکسل/CSV از پرداخت‌ها
     */
    public function export(Request $request)
    {
        $query = Payment::with(['user', 'order']);

        // اعمال فیلترها
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('reference_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $payments = $query->orderBy('id', 'desc')->get();

        // ایجاد فایل CSV
        $filename = 'payments_export_' . verta()->format('Y_m_d_H_i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $handle = fopen('php://output', 'w');

            // اضافه کردن BOM برای UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // هدرهای ستون‌ها
            fputcsv($handle, [
                'شناسه',
                'شماره تراکنش',
                'نام کاربر',
                'شماره موبایل',
                'ایمیل',
                'شماره سفارش',
                'مبلغ (تومان)',
                'درگاه پرداخت',
                'کد رهگیری',
                'شماره کارت',
                'وضعیت',
                'تاریخ ایجاد',
                'تاریخ تایید',
                'توضیحات'
            ]);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->id,
                    $payment->transaction_id,
                    $payment->user?->name ?? 'کاربر حذف شده',
                    $payment->user?->mobile ?? '-',
                    $payment->user?->email ?? '-',
                    $payment->order?->order_number ?? '-',
                    number_format($payment->amount),
                    strtoupper($payment->gateway),
                    $payment->tracking_code ?? $payment->reference_id ?? '-',
                    $payment->card_number ?? '-',
                    $this->getStatusText($payment->status),
                    verta($payment->created_at)->format('Y/m/d H:i:s'),
                    $payment->verified_at ? verta($payment->verified_at)->format('Y/m/d H:i:s') : '-',
                    $payment->description ?? '-'
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * تایید مجدد پرداخت (برای پرداخت‌های در انتظار)
     */
    public function retryVerify(Request $request, Payment $payment)
    {
        if ($payment->status !== Payment::STATUS_PENDING) {
            return redirect()->back()->with('error', 'فقط پرداخت‌های در انتظار قابل تایید مجدد هستند');
        }

        try {
            // دریافت اطلاعات از درگاه
            $result = $this->paymentService->verifyPayment($payment, $request->all());

            if ($result['success']) {
                return redirect()->route('admin.payments.show', $payment)
                    ->with('success', 'پرداخت با موفقیت تایید شد');
            } else {
                return redirect()->route('admin.payments.show', $payment)
                    ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            Log::error('Payment retry verify failed: ' . $e->getMessage());

            return redirect()->route('admin.payments.show', $payment)
                ->with('error', 'خطا در تایید پرداخت: ' . $e->getMessage());
        }
    }

    /**
     * دریافت متن وضعیت به فارسی
     */
    private function getStatusText($status)
    {
        $statuses = [
            Payment::STATUS_PENDING => 'در انتظار',
            Payment::STATUS_PROCESSING => 'در حال پردازش',
            Payment::STATUS_COMPLETED => 'موفق',
            Payment::STATUS_FAILED => 'ناموفق',
            Payment::STATUS_REFUNDED => 'استرداد شده'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * آمار پیشرفته پرداخت‌ها (برای نمودارها)
     */
    public function statistics(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, year

        $stats = [];

        switch ($period) {
            case 'week':
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $stats[$date->format('Y-m-d')] = [
                        'date' => verta($date)->format('d F'),
                        'amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                            ->whereDate('created_at', $date)
                            ->sum('amount'),
                        'count' => Payment::whereDate('created_at', $date)->count()
                    ];
                }
                break;

            case 'month':
                $daysInMonth = verta()->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $date = verta()->startOfMonth()->addDays($i - 1);
                    $stats[$date->format('Y-m-d')] = [
                        'date' => $date->format('d F'),
                        'amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                            ->whereDate('created_at', $date->datetime())
                            ->sum('amount'),
                        'count' => Payment::whereDate('created_at', $date->datetime())->count()
                    ];
                }
                break;

            case 'year':
                for ($i = 1; $i <= 12; $i++) {
                    $stats[$i] = [
                        'month' => verta()->month($i)->format('F'),
                        'amount' => Payment::where('status', Payment::STATUS_COMPLETED)
                            ->whereYear('created_at', now()->year)
                            ->whereMonth('created_at', $i)
                            ->sum('amount'),
                        'count' => Payment::whereYear('created_at', now()->year)
                            ->whereMonth('created_at', $i)
                            ->count()
                    ];
                }
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $stats,
            'period' => $period
        ]);
    }

    /**
     * دریافت جزئیات JSON برای AJAX
     */
    public function getPaymentDetails(Payment $payment)
    {
        return response()->json([
            'id' => $payment->id,
            'transaction_id' => $payment->transaction_id,
            'amount' => number_format($payment->amount),
            'gateway' => $payment->gateway,
            'status' => $payment->status,
            'status_text' => $this->getStatusText($payment->status),
            'reference_id' => $payment->reference_id,
            'tracking_code' => $payment->tracking_code,
            'card_number' => $payment->card_number,
            'created_at' => verta($payment->created_at)->format('Y/m-d H:i:s'),
            'verified_at' => $payment->verified_at ? verta($payment->verified_at)->format('Y/m-d H:i:s') : null,
            'user' => [
                'name' => $payment->user?->name,
                'mobile' => $payment->user?->mobile,
                'email' => $payment->user?->email
            ],
            'order' => $payment->order ? [
                'id' => $payment->order->id,
                'number' => $payment->order->order_number,
                'total' => number_format($payment->order->total),
                'url' => route('admin.orders.show', $payment->order)
            ] : null
        ]);
    }
}
