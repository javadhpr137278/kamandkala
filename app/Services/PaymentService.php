<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    protected $gateway;
    protected $gatewayConfig;

    public function __construct($gatewayName = null)
    {
        if ($gatewayName) {
            $this->setGateway($gatewayName);
        }
    }

    public function setGateway($gatewayName)
    {
        $gateway = PaymentGateway::where('name', $gatewayName)
            ->where('is_active', true)
            ->first();

        if (!$gateway) {
            throw new \Exception("درگاه پرداخت {$gatewayName} فعال نیست");
        }

        $this->gateway = $gateway;
        $this->gatewayConfig = $gateway->config ?? [];

        return $this;
    }

    /**
     * ایجاد درخواست پرداخت جدید
     */
    public function initiatePayment(Order $order, string $gatewayName): Payment
    {
        $this->setGateway($gatewayName);

        // ایجاد رکورد پرداخت
        $payment = Payment::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'transaction_id' => $this->generateTransactionId(),
            'amount' => $order->total,
            'gateway' => $gatewayName,
            'status' => Payment::STATUS_PENDING,
            'description' => "پرداخت سفارش شماره {$order->order_number}",
            'metadata' => [
                'order_number' => $order->order_number,
                'gateway_config' => $this->gatewayConfig
            ]
        ]);

        return $payment;
    }

    /**
     * هدایت به درگاه پرداخت
     */
    public function redirectToGateway(Payment $payment): array
    {
        try {
            $payment->markAsProcessing();

            $gatewayClass = $this->getGatewayClass($payment->gateway);
            $gatewayInstance = new $gatewayClass($this->gatewayConfig);

            $result = $gatewayInstance->pay($payment);

            // ذخیره اطلاعات درگاه در متادیتا
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'gateway_request' => $result
                ])
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            $payment->markAsFailed(['error' => $e->getMessage()]);

            throw $e;
        }
    }

    /**
     * تایید پرداخت
     */
    public function verifyPayment(Payment $payment, array $requestData): array
    {
        try {
            $gatewayClass = $this->getGatewayClass($payment->gateway);
            $gatewayInstance = new $gatewayClass($payment->metadata['gateway_config'] ?? []);

            $verificationResult = $gatewayInstance->verify($payment, $requestData);

            if ($verificationResult['success']) {
                // پرداخت موفق
                $payment->markAsCompleted(
                    $verificationResult['reference_id'],
                    [
                        'tracking_code' => $verificationResult['tracking_code'] ?? null,
                        'card_number' => $verificationResult['card_number'] ?? null,
                        'gateway_response' => $verificationResult
                    ]
                );

                // بروزرسانی وضعیت سفارش
                if ($payment->order) {
                    $payment->order->update(['status' => 'processing']);
                }

                Log::info('Payment verified successfully', [
                    'payment_id' => $payment->id,
                    'reference_id' => $verificationResult['reference_id']
                ]);

                return [
                    'success' => true,
                    'message' => 'پرداخت با موفقیت انجام شد',
                    'payment' => $payment
                ];
            } else {
                // پرداخت ناموفق
                $payment->markAsFailed([
                    'error' => $verificationResult['message'] ?? 'خطا در تایید پرداخت',
                    'gateway_response' => $verificationResult
                ]);

                return [
                    'success' => false,
                    'message' => $verificationResult['message'] ?? 'پرداخت ناموفق بود',
                    'payment' => $payment
                ];
            }

        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            $payment->markAsFailed(['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'خطا در تایید پرداخت: ' . $e->getMessage(),
                'payment' => $payment
            ];
        }
    }

    /**
     * دریافت کلاس درگاه
     */
    protected function getGatewayClass($gatewayName): string
    {
        $gateways = [
            'zarinpal' => \App\Services\Payment\Gateways\ZarinpalGateway::class,
            'idpay' => \App\Services\Payment\Gateways\IdpayGateway::class,
            'zibal' => \App\Services\Payment\Gateways\ZibalGateway::class,
            'payir' => \App\Services\Payment\Gateways\PayirGateway::class,
            'nextpay' => \App\Services\Payment\Gateways\NextpayGateway::class,
        ];

        if (!isset($gateways[$gatewayName])) {
            throw new \Exception("درگاه {$gatewayName} پشتیبانی نمی‌شود");
        }

        return $gateways[$gatewayName];
    }

    /**
     * تولید شناسه یکتا
     */
    protected function generateTransactionId(): string
    {
        return 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(12));
    }
}
