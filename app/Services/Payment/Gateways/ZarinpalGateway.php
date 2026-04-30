<?php

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class ZarinpalGateway
{
    protected $merchantId;
    protected $callbackUrl;
    protected $sandbox;

    public function __construct($config)
    {
        $this->merchantId = $config['merchant_id'] ?? '';
        $this->callbackUrl = $config['callback_url'] ?? '';
        $this->sandbox = $config['sandbox'] ?? false;
    }

    public function pay(Payment $payment): array
    {
        $baseUrl = $this->sandbox
            ? 'https://sandbox.zarinpal.com/pg/rest/WebPG/service/PaymentRequest'
            : 'https://api.zarinpal.com/pg/v4/payment/request.json';

        $response = Http::post($baseUrl, [
            'merchant_id' => $this->merchantId,
            'amount' => $payment->amount,
            'callback_url' => $this->callbackUrl,
            'description' => $payment->description,
            'metadata' => [
                'mobile' => $payment->user->mobile ?? '',
                'email' => $payment->user->email ?? '',
                'payment_id' => $payment->id
            ]
        ]);

        $result = $response->json();

        if (($this->sandbox && isset($result['Status']) && $result['Status'] == 100) ||
            (!$this->sandbox && isset($result['data']['code']) && $result['data']['code'] == 100)) {

            $authority = $this->sandbox ? $result['Authority'] : $result['data']['authority'];

            $redirectUrl = $this->sandbox
                ? "https://sandbox.zarinpal.com/pg/StartPay/{$authority}"
                : "https://www.zarinpal.com/pg/StartPay/{$authority}";

            return [
                'success' => true,
                'redirect_url' => $redirectUrl,
                'authority' => $authority
            ];
        }

        $errorMessage = $result['errors']['message'] ?? 'خطا در اتصال به درگاه زرین‌پال';
        throw new \Exception($errorMessage);
    }

    public function verify(Payment $payment, array $requestData): array
    {
        $authority = $requestData['Authority'] ?? null;
        $status = $requestData['Status'] ?? null;

        if ($status != 'OK') {
            return [
                'success' => false,
                'message' => 'پرداخت توسط کاربر لغو شد'
            ];
        }

        $baseUrl = $this->sandbox
            ? 'https://sandbox.zarinpal.com/pg/rest/WebPG/service/VerificationRequest'
            : 'https://api.zarinpal.com/pg/v4/payment/verify.json';

        $response = Http::post($baseUrl, [
            'merchant_id' => $this->merchantId,
            'amount' => $payment->amount,
            'authority' => $authority
        ]);

        $result = $response->json();

        if (($this->sandbox && isset($result['Status']) && $result['Status'] == 100) ||
            (!$this->sandbox && isset($result['data']['code']) && $result['data']['code'] == 100)) {

            $refId = $this->sandbox ? $result['RefID'] : $result['data']['ref_id'];

            return [
                'success' => true,
                'reference_id' => $refId,
                'tracking_code' => $refId,
                'card_number' => $result['data']['card_pan'] ?? null
            ];
        }

        return [
            'success' => false,
            'message' => 'تراکنش ناموفق بود'
        ];
    }
}
