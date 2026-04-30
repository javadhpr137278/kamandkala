<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * نمایش لیست سفارشات
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        // فیلتر بر اساس وضعیت
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فیلتر بر اساس روش پرداخت
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // جستجو
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('billing_first_name', 'like', "%{$search}%")
                    ->orWhere('billing_last_name', 'like', "%{$search}%")
                    ->orWhere('billing_phone', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%");
            });
        }

        // فیلتر تاریخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(20);

        // آمار داشبورد
        $stats = [
            'total_orders' => Order::count(),
            'total_sales' => Order::where('status', 'completed')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_sales' => Order::where('status', 'completed')->whereDate('created_at', today())->sum('total'),
        ];

        $statuses = [
            'pending' => 'در انتظار پرداخت',
            'processing' => 'در حال پردازش',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'failed' => 'ناموفق',
        ];

        $paymentMethods = [
            'bacs' => 'انتقال بانکی',
            'cod' => 'پرداخت در محل',
        ];

        return view('admin.orders.list', compact('orders', 'stats', 'statuses', 'paymentMethods'));
    }

    /**
     * نمایش جزئیات سفارش
     */
    public function show(Order $order)
    {
        $order->load('user');

        $statuses = [
            'pending' => 'در انتظار پرداخت',
            'processing' => 'در حال پردازش',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'failed' => 'ناموفق',
        ];

        $paymentMethods = [
            'bacs' => 'انتقال بانکی',
            'cod' => 'پرداخت در محل',
        ];

        // محاسبه آدرس بر اساس نوع انتخاب شده
        $address = $this->getAddress($order);

        return view('admin.orders.show', compact('order', 'statuses', 'paymentMethods', 'address'));
    }

    /**
     * تغییر وضعیت سفارش (AJAX)
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            // اعتبارسنجی
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled,failed'
            ]);

            // ذخیره وضعیت قبلی
            $oldStatus = $order->status;

            // تغییر وضعیت
            $order->status = $request->status;
            $order->save();

            // پاسخ JSON برای AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'وضعیت سفارش با موفقیت از "' . $oldStatus . '" به "' . $order->status . '" تغییر کرد',
                    'new_status' => $order->status,
                    'old_status' => $oldStatus,
                    'badge' => $this->getStatusBadge($order->status)
                ]);
            }

            // پاسخ برای درخواست معمولی
            return redirect()->back()->with('success', 'وضعیت سفارش با موفقیت تغییر کرد');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'خطا در تغییر وضعیت سفارش');
        }
    }

// متد کمکی برای تولید نشانگر وضعیت
    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'failed' => 'dark',
        ];

        $texts = [
            'pending' => 'در انتظار پرداخت',
            'processing' => 'در حال پردازش',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'failed' => 'ناموفق',
        ];

        $color = $badges[$status] ?? 'secondary';
        $text = $texts[$status] ?? $status;

        return "<span class='badge badge-{$color}'>{$text}</span>";
    }
    /**
     * به‌روزرسانی سفارش
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_email' => 'nullable|email|max:255',
            'billing_address_1' => 'nullable|string',
            'billing_address_2' => 'nullable|string',
            'billing_city' => 'nullable|string|max:255',
            'billing_postcode' => 'nullable|string|max:20',
            'shipping_date' => 'nullable|date',
            'payment_method' => 'required|in:bacs,cod',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // محاسبه مجدد total
        $orderItems = $order->order_items ?? [];
        $subtotal = 0;
        foreach ($orderItems as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        $validated['subtotal'] = $subtotal;
        $validated['total'] = $subtotal + ($validated['shipping_cost'] ?? 0);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'سفارش با موفقیت به‌روزرسانی شد');
    }

    /**
     * حذف سفارش
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'سفارش با موفقیت حذف شد');
    }

    /**
     * پرینت فاکتور
     */
    public function print(Order $order)
    {
        $address = $this->getAddress($order);
        return view('admin.orders.print', compact('order', 'address'));
    }

    /**
     * دریافت آدرس بر اساس نوع انتخاب شده
     */
    private function getAddress(Order $order)
    {
        if ($order->address_choice === 'custom') {
            return [
                'address' => $order->custom_address,
                'city' => $order->custom_city,
                'postcode' => $order->custom_postcode,
                'full' => $order->custom_address . ' - ' . $order->custom_city . ($order->custom_postcode ? ' - کدپستی: ' . $order->custom_postcode : '')
            ];
        } elseif ($order->address_choice === 'shipping') {
            return [
                'first_name' => $order->shipping_first_name,
                'last_name' => $order->shipping_last_name,
                'phone' => $order->shipping_phone,
                'address' => $order->shipping_address_1,
                'address2' => $order->shipping_address_2,
                'city' => $order->shipping_city,
                'state' => $order->shipping_state,
                'postcode' => $order->shipping_postcode,
                'full' => $order->shipping_address_1 . ' - ' . $order->shipping_city
            ];
        } else {
            return [
                'first_name' => $order->billing_first_name,
                'last_name' => $order->billing_last_name,
                'phone' => $order->billing_phone,
                'address' => $order->billing_address_1,
                'address2' => $order->billing_address_2,
                'city' => $order->billing_city,
                'state' => $order->billing_state,
                'postcode' => $order->billing_postcode,
                'full' => $order->billing_address_1 . ' - ' . $order->billing_city
            ];
        }
    }

    /**
     * اکسل خروجی از سفارشات
     */
    public function export(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('id', 'desc')->get();

        // خروجی CSV
        $filename = 'orders_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');

        // هدرهای CSV
        fputcsv($handle, [
            'شماره سفارش', 'نام مشتری', 'تلفن', 'ایمیل',
            'مبلغ کل', 'وضعیت', 'روش پرداخت', 'تاریخ ثبت'
        ]);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->order_number,
                $order->full_name,
                $order->billing_phone,
                $order->billing_email,
                number_format($order->total) . ' تومان',
                $order->status,
                $order->payment_method === 'cod' ? 'پرداخت در محل' : 'انتقال بانکی',
                verta($order->created_at)->format('Y/m/d H:i')
            ]);
        }

        fclose($handle);

        return response()->stream(
            function() use ($handle) {
                // Already output
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
