<?php
// app/Http/Requests/CheckoutRequest.php

namespace App\Http\Requests;

use App\Models\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {

        // دریافت نام درگاه‌های فعال از دیتابیس
        $validGateways = PaymentGateway::where('is_active', 1)
            ->pluck('name')
            ->toArray();
        return [
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_email' => 'nullable|email|max:255',

            'address_choice' => 'required|in:billing,shipping,custom',

            'billing_address_1' => 'required_if:address_choice,billing|nullable|string|max:500',
            'billing_city' => 'required_if:address_choice,billing|nullable|string|max:255',
            'billing_state' => 'required_if:address_choice,billing|nullable|string|max:255',
            'billing_postcode' => 'required_if:address_choice,billing|nullable|string|max:20',

            'shipping_address_1' => 'required_if:address_choice,shipping|nullable|string|max:500',
            'shipping_city' => 'required_if:address_choice,shipping|nullable|string|max:255',
            'shipping_state' => 'required_if:address_choice,shipping|nullable|string|max:255',
            'shipping_postcode' => 'required_if:address_choice,shipping|nullable|string|max:20',

            'new_address' => 'required_if:address_choice,custom|nullable|string|max:500',
            'new_city' => 'required_if:address_choice,custom|nullable|string|max:255',
            'new_postcode' => 'required_if:address_choice,custom|nullable|string|max:20',

            'recive_date_shipping' => 'required|string',
            'payment_method' => 'required|in:' . implode(',', $validGateways),

        ];
    }

    public function messages()
    {
        return [
            'billing_first_name.required' => 'وارد کردن نام الزامی است',
            'billing_last_name.required' => 'وارد کردن نام خانوادگی الزامی است',
            'billing_phone.required' => 'وارد کردن شماره موبایل الزامی است',
            'address_choice.required' => 'انتخاب آدرس الزامی است',
            'recive_date_shipping.required' => 'انتخاب تاریخ ارسال الزامی است',
            'payment_method.required' => 'انتخاب روش پرداخت الزامی است',
        ];
    }
}
