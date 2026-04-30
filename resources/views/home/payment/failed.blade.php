@extends('home.layouts.master')

@section('content')
    <div class="container py-5">
        <div class="text-center">
            <div class="error-icon mb-4">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke="red"/>
                    <line x1="12" y1="8" x2="12" y2="12" stroke="red"/>
                    <line x1="12" y1="16" x2="12.01" y2="16" stroke="red"/>
                </svg>
            </div>

            <h2 class="mb-3">پرداخت ناموفق بود</h2>
            <p class="text-danger mb-4">{{ $error }}</p>

            <div class="card mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="card-body">
                    <p><strong>شماره سفارش:</strong> {{ $payment->order->order_number ?? '-' }}</p>
                    <p><strong>مبلغ:</strong> {{ number_format($payment->amount) }} تومان</p>
                    <p><strong>وضعیت:</strong> <span class="text-danger">ناموفق</span></p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('checkout') }}" class="btn btn-primary">تلاش مجدد برای پرداخت</a>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary">بازگشت به سبد خرید</a>
            </div>
        </div>
    </div>
@endsection
