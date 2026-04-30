<?php

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZibalGateway
{
    protected $merchant;
    protected $callbackUrl;
    protected $sandbox;

    public function __construct($config)
    {
        // مرچنت کد زیبال
        $this->merchant = $config['merchant'] ?? 'zibal';
        $this->callbackUrl = $config['callback_url'] ?? route('payment.verify');
        $this->sandbox = $config['sandbox'] ?? false;
    }

    /**
     * درخواست پرداخت به درگاه زیبال
     */
    public function requestPayment(Payment $payment): array
    {
        $baseUrl = $this->sandbox
            ? 'https://gateway.zibal.ir/v1/request'
            : 'https://gateway.zibal.ir/v1/request';

        $payload = [
            'merchant' => $this->merchant,
            'amount' => $payment->amount,
            'callbackUrl' => $this->callbackUrl,
            'description' => $payment->description,
            'orderId' => $payment->id,
        ];

        Log::info('Zibal payment request', [
            'url' => $baseUrl,
            'payload' => $payload
        ]);

        $response = Http::post($baseUrl, $payload);
        $result = $response->json();

        Log::info('Zibal payment response', ['result' => $result]);

        if (isset($result['result']) && $result['result'] == 100) {
            return [
                'success' => true,
                'trackId' => $result['trackId'],
                'redirect_url' => "https://gateway.zibal.ir/start/{$result['trackId']}",
                'message' => $result['message'] ?? 'success'
            ];
        }

        $errorMessages = [
            102 => 'merchant یافت نشد',
            103 => 'merchant غیرفعال',
            104 => 'merchant نامعتبر',
            105 => 'amount بایستی بین 1,000 تا 500,000,000 ریال باشد',
            106 => 'callbackUrl نامعتبر',
            201 => 'قبلا تایید شده',
            202 => 'سفارش پرداخت نشده است',
            203 => 'trackId نامعتبر',
        ];

        $errorCode = $result['result'] ?? 0;
        $errorMessage = $errorMessages[$errorCode] ?? ($result['message'] ?? 'خطا در اتصال به درگاه زیبال');

        throw new \Exception($errorMessage);
    }

    /**
     * تایید پرداخت در درگاه زیبال
     */
    public function verifyPayment(Payment $payment, array $requestData): array
    {
        $trackId = $requestData['trackId'] ?? null;

        if (!$trackId) {
            return [
                'success' => false,
                'message' => 'شناسه تراکنش یافت نشد'
            ];
        }

        $baseUrl = $this->sandbox
            ? 'https://gateway.zibal.ir/v1/verify'
            : 'https://gateway.zibal.ir/v1/verify';

        $payload = [
            'merchant' => $this->merchant,
            'trackId' => $trackId
        ];

        Log::info('Zibal verify request', [
            'url' => $baseUrl,
            'payload' => $payload
        ]);

        $response = Http::post($baseUrl, $payload);
        $result = $response->json();

        Log::info('Zibal verify response', ['result' => $result]);

        if (isset($result['result']) && $result['result'] == 100) {
            return [
                'success' => true,
                'reference_id' => $result['refNumber'] ?? null,
                'tracking_code' => $result['refNumber'] ?? null,
                'card_number' => $result['cardNumber'] ?? null,
                'amount' => $result['amount'] ?? $payment->amount,
                'message' => 'پرداخت با موفقیت انجام شد'
            ];
        }

        $errorMessages = [
            102 => 'merchant یافت نشد',
            103 => 'merchant غیرفعال',
            104 => 'merchant نامعتبر',
            105 => 'قبلا تایید شده',
            106 => 'تراکنش ناموفق',
            201 => 'قبلا تایید شده',
            202 => 'سفارش پرداخت نشده است',
            203 => 'trackId نامعتبر',
        ];

        $errorCode = $result['result'] ?? 0;
        $errorMessage = $errorMessages[$errorCode] ?? ($result['message'] ?? 'خطا در تایید پرداخت');

        return [
            'success' => false,
            'message' => $errorMessage
        ];
    }
}
