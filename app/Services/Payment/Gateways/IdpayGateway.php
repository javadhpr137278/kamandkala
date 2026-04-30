<?php

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class IdpayGateway
{
    protected $apiKey;
    protected $callbackUrl;
    protected $sandbox;

    public function __construct($config)
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->callbackUrl = $config['callback_url'] ?? '';
        $this->sandbox = $config['sandbox'] ?? false;
    }

    public function pay(Payment $payment): array
    {
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.idpay.ir/v1.1/payment', [
            'order_id' => $payment->id,
            'amount' => $payment->amount,
            'name' => $payment->user->name,
            'phone' => $payment->user->mobile,
            'mail' => $payment->user->email,
            'desc' => $payment->description,
            'callback' => $this->callbackUrl,
            'sandbox' => $this->sandbox ? 1 : 0,
        ]);

        $result = $response->json();

        if (isset($result['id']) && isset($result['link'])) {
            return [
                'success' => true,
                'redirect_url' => $result['link'],
                'id' => $result['id']
            ];
        }

        $errorMessage = $result['error_message'] ?? 'خطا در اتصال به درگاه آیدی پی';
        throw new \Exception($errorMessage);
    }

    public function verify(Payment $payment, array $requestData): array
    {
        $id = $requestData['id'] ?? null;
        $orderId = $requestData['order_id'] ?? null;

        if (!$id || $orderId != $payment->id) {
            return [
                'success' => false,
                'message' => 'اطلاعات تراکنش نامعتبر است'
            ];
        }

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.idpay.ir/v1.1/payment/verify', [
            'id' => $id,
            'order_id' => $payment->id
        ]);

        $result = $response->json();

        if (isset($result['status']) && $result['status'] == 100) {
            return [
                'success' => true,
                'reference_id' => $result['track_id'],
                'tracking_code' => $result['track_id'],
                'card_number' => $result['payment']['card_no'] ?? null
            ];
        }

        $errorMessage = $result['error_message'] ?? 'تراکنش ناموفق بود';
        return [
            'success' => false,
            'message' => $errorMessage
        ];
    }
}
