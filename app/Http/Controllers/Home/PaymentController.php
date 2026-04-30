<?php
// app/Http/Controllers/Home/PaymentController.php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * هدایت به درگاه پرداخت زیبال
     */
    public function pay(Order $order)
    {
//        dd(PaymentGateway::all());

        // بررسی دسترسی
        if ($order->user_id !== auth()->id()) {
            abort(403, 'شما دسترسی به این سفارش ندارید');
        }

        // بررسی وضعیت سفارش
        if ($order->status !== 'pending') {
            return redirect()->route('order.confirmation', $order->order_number)
                ->with('error', 'این سفارش قبلاً پرداخت شده است.');
        }

        // دریافت اطلاعات درگاه زیبال
        $gateway = PaymentGateway::where('name', 'zibal')
            ->where('is_active', true)
            ->first();

        if (!$gateway) {
            return redirect()->route('order.confirmation', $order->order_number)
                ->with('error', 'درگاه پرداخت زیبال فعال نیست. لطفاً با پشتیبانی تماس بگیرید.');
        }

        // بررسی وجود پرداخت قبلی
        $payment = Payment::where('order_id', $order->id)->first();

        if (!$payment) {
            // ایجاد رکورد پرداخت جدید
            $payment = Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'transaction_id' => 'ZBL-' . date('YmdHis') . '-' . Str::random(6),
                'amount' => $order->total,
                'gateway' => 'zibal',
                'status' => 'pending',
                'description' => 'پرداخت سفارش شماره ' . $order->order_number,
                'metadata' => [
                    'order_number' => $order->order_number,
                    'user_name' => $order->billing_first_name . ' ' . $order->billing_last_name,
                    'user_mobile' => $order->billing_phone,
                    'user_email' => $order->billing_email,
                ]
            ]);
        }

        try {
            $config = $gateway->config;
            $merchant = $config['merchant'] ?? 'zibal';
            $callbackUrl = route('payment.verify');

            Log::info('Zibal Payment Request', [
                'order_id' => $order->id,
                'amount' => $payment->amount,
                'merchant' => $merchant,
                'callback' => $callbackUrl
            ]);
            $amount_in_rial = $payment->amount * 10;

            // ارسال درخواست به زیبال
            $response = Http::timeout(30)->post('https://gateway.zibal.ir/v1/request', [
                'merchant' => $merchant,
                'amount' => $amount_in_rial,
                'callbackUrl' => $callbackUrl,
                'description' => $payment->description,
                'orderId' => $payment->id,
            ]);

            $result = $response->json();

            Log::info('Zibal Payment Response', ['result' => $result]);

            if (isset($result['result']) && $result['result'] == 100 && isset($result['trackId'])) {
                $trackId = $result['trackId'];

                // ذخیره trackId در متادیتا
                $payment->update([
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'trackId' => $trackId,
                        'request_time' => now()->toDateTimeString()
                    ])
                ]);

                // هدایت به درگاه زیبال
                $redirectUrl = "https://gateway.zibal.ir/start/{$trackId}";
                return redirect()->away($redirectUrl);
            }

            // پردازش خطاهای زیبال
            $errorMessage = $this->getZibalErrorMessage($result['result'] ?? 0);
            throw new \Exception($errorMessage);

        } catch (\Exception $e) {
            Log::error('Zibal Payment Error: ' . $e->getMessage());

            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], [
                    'error' => $e->getMessage(),
                    'error_time' => now()->toDateTimeString()
                ])
            ]);

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('error', 'خطا در اتصال به درگاه پرداخت: ' . $e->getMessage());
        }
    }

    /**
     * تایید پرداخت از درگاه زیبال (کال‌بک)
     */
    public function verify(Request $request)
    {
        // دریافت پارامترها
        $success = $request->get('success');
        $trackId = $request->get('trackId');
        $orderId = $request->get('orderId');

        Log::info('Zibal Callback Received', [
            'success' => $success,
            'trackId' => $trackId,
            'orderId' => $orderId,
            'all_params' => $request->all(),
            'ip' => $request->ip()
        ]);

        // پیدا کردن پرداخت
        $payment = null;

        if ($trackId) {
            $payment = Payment::where('metadata->trackId', $trackId)->first();
        }

        if (!$payment && $orderId) {
            $payment = Payment::find($orderId);
        }

        if (!$payment) {
            Log::error('Payment not found in callback', ['trackId' => $trackId, 'orderId' => $orderId]);
            return redirect()->route('home')->with('error', 'پرداخت مورد نظر یافت نشد');
        }

        $order = $payment->order;

        // اگر پرداخت قبلاً تایید شده
        if ($payment->status === 'completed') {
            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'پرداخت قبلاً با موفقیت انجام شده است.');
        }

        // اگر کاربر پرداخت را لغو کرده است
        if ($success != 1) {
            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], [
                    'canceled_at' => now()->toDateTimeString(),
                    'cancel_reason' => 'کاربر پرداخت را لغو کرد'
                ])
            ]);

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('error', 'پرداخت توسط کاربر لغو شد.');
        }

        try {
            DB::beginTransaction();

            // دریافت اطلاعات درگاه
            $gateway = PaymentGateway::where('name', 'zibal')
                ->where('is_active', true)
                ->first();

            if (!$gateway) {
                throw new \Exception('درگاه پرداخت زیبال فعال نیست');
            }

            $config = $gateway->config;
            $merchant = $config['merchant'] ?? 'zibal';

            // تایید پرداخت با زیبال
            $verifyResponse = Http::timeout(30)->post('https://gateway.zibal.ir/v1/verify', [
                'merchant' => $merchant,
                'trackId' => $trackId
            ]);

            $verifyResult = $verifyResponse->json();

            Log::info('Zibal Verify Response', ['result' => $verifyResult]);

            if (isset($verifyResult['result']) && $verifyResult['result'] == 100) {
                $refNumber = $verifyResult['refNumber'] ?? null;
                $cardNumber = $verifyResult['cardNumber'] ?? null;

                // بروزرسانی پرداخت
                $payment->update([
                    'status' => 'completed',
                    'reference_id' => $refNumber,
                    'tracking_code' => $refNumber,
                    'card_number' => $cardNumber,
                    'paid_at' => now(),
                    'verified_at' => now(),
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'verify_time' => now()->toDateTimeString(),
                        'verify_response' => $verifyResult
                    ])
                ]);

                // بروزرسانی وضعیت سفارش
                $order->update([
                    'status' => 'processing'
                ]);

                DB::commit();

                return redirect()->route('order.confirmation', $order->order_number)
                    ->with('success', 'پرداخت با موفقیت انجام شد. کد پیگیری: ' . $refNumber);
            }

            // خطای تایید
            $errorMessage = $this->getZibalErrorMessage($verifyResult['result'] ?? 0);
            throw new \Exception($errorMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Zibal Verify Error: ' . $e->getMessage());

            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], [
                    'verify_error' => $e->getMessage(),
                    'verify_error_time' => now()->toDateTimeString()
                ])
            ]);

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('error', 'خطا در تایید پرداخت: ' . $e->getMessage());
        }
    }

    /**
     * دریافت پیام خطای زیبال
     */
    private function getZibalErrorMessage($code)
    {
        $errors = [
            100 => 'با موفقیت انجام شد',
            102 => 'merchant یافت نشد',
            103 => 'merchant غیرفعال',
            104 => 'merchant نامعتبر',
            105 => 'مبلغ باید بین 1,000 تا 500,000,000 ریال باشد',
            106 => 'callbackUrl نامعتبر',
            113 => 'مبلغ تراکنش برای سرویس مورد نظر کمتر از حد مجاز است',
            114 => 'مبلغ تراکنش برای سرویس مورد نظر بیشتر از حد مجاز است',
            201 => 'قبلاً تایید شده',
            202 => 'سفارش پرداخت نشده است',
            203 => 'trackId نامعتبر',
            204 => 'درخواست تکراری',
            301 => 'در انتظار پرداخت',
            302 => 'خطای احراز هویت',
            401 => 'خطای داخلی',
            402 => 'خطای اتصال به بانک',
            403 => 'خطای اتصال به درگاه',
            404 => 'خطای داخلی سرویس',
        ];

        return $errors[$code] ?? 'خطای ناشناخته در ارتباط با درگاه زیبال';
    }
}
