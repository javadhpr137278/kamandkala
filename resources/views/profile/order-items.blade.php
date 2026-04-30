@extends('layouts.app')
@section('content')
    <div class="panel-latest-order">

        <div class="slider-title mt-4">
            <div class="slider-title-desc">
                <div class="slider-title-title pb-4">
                    <h2 class="h1"><span class="title-font main-color-one-color">جزییات</span> سفارش #{{ $order->order_number }}</h2>
                </div>
            </div>
        </div>

        <div class="shoping-proccess slider-parent">
            <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                <div class="step {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered', 'completed']) ? 'completed' : '' }}">
                    <div class="step-icon-wrap">
                        <div class="step-icon"><i class="bi bi-cart-check fs-2"></i></div>
                    </div>
                    <h4 class="step-title">سفارش تایید شده</h4>
                </div>
                <div class="step {{ in_array($order->status, ['processing', 'shipped', 'delivered', 'completed']) ? 'completed' : '' }}">
                    <div class="step-icon-wrap">
                        <div class="step-icon"><i class="bi bi-gear fs-2"></i></div>
                    </div>
                    <h4 class="step-title">پردازش سفارش</h4>
                </div>
                <div class="step {{ in_array($order->status, ['shipped', 'delivered', 'completed']) ? 'completed' : '' }}">
                    <div class="step-icon-wrap">
                        <div class="step-icon"><i class="bi bi-bus-front fs-2"></i></div>
                    </div>
                    <h4 class="step-title">تحویل به پست</h4>
                </div>
                <div class="step {{ in_array($order->status, ['delivered', 'completed']) ? 'completed' : '' }}">
                    <div class="step-icon-wrap">
                        <div class="step-icon"><i class="fs-2 bi bi-house-check"></i></div>
                    </div>
                    <h4 class="step-title">تحویل داده شده</h4>
                </div>
            </div>
        </div>

        <div class="orders-item">
            <div class="ui-boxs">
                <div class="ui-box">
                    <div class="ui-box-item slider-parent ui-box-white">
                        <div class="ui-box-item-desc p-0">
                            <div class="orders">
                                <div class="order-item">
                                    <div class="order-item-detail">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <span class="text-mute">کد پیگیری سفارش</span>
                                                <strong>{{ $order->order_number }}</strong>
                                            </li>
                                            <li class="nav-item">
                                                <span class="text-mute">تاریخ ثبت سفارش</span>
                                                <strong>{{ verta($order->created_at)->format('j F Y') }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="order-item-detail" style="padding-top: 20px;">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <span class="text-mute">تحویل گیرنده</span>
                                                <strong>{{ $order->shipping_first_name ?? $order->billing_first_name }} {{ $order->shipping_last_name ?? $order->billing_last_name }}</strong>
                                            </li>
                                            <li class="nav-item">
                                                <span class="text-mute">شماره موبایل</span>
                                                <strong>{{ $order->shipping_phone ?? $order->billing_phone }}</strong>
                                            </li>
                                            <li class="nav-item w-100"></li>
                                            <li class="nav-item">
                                                <span class="text-mute">آدرس</span>
                                                <strong>{{ $order->shipping_address_1 ?? $order->billing_address_1 }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="order-item-detail" style="padding-top: 20px;">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <span class="text-mute">مبلغ</span>
                                                <strong>{{ number_format($order->total) }} تومان</strong>
                                            </li>
                                            <li class="nav-item">
                                                <strong>{{ $order->payment_method ?? 'پرداخت اینترنتی' }}</strong>
                                            </li>
                                            <li class="nav-item w-100"></li>
                                            <li class="nav-item">
                                                <span class="text-mute">کد تخفیف</span>
                                                <strong>{{ number_format($order->discount_amount ?? 0) }} تومان</strong>
                                            </li>
                                            <li class="nav-item">
                                                <span class="text-mute">هزینه ارسال براساس وزن و حجم</span>
                                                <strong>{{ number_format($order->shipping_cost ?? 0) }} تومان</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="order-item-detail" style="padding-top: 20px;">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <strong>مرسوله 1 از {{ count($orderItems) }}</strong>
                                            </li>
                                            <li class="nav-item">
                                                <strong class="text-danger">ارسال عادی</strong>
                                            </li>
                                            <li class="nav-item w-100"></li>
                                            <li class="nav-item">
                                                <span class="text-mute">زمان تحویل</span>
                                                <strong>{{ $order->delivery_date ?? verta($order->created_at)->addDays(3)->format('l j F بازه ۹ - ۲۲') }}</strong>
                                            </li>
                                            <li class="nav-item">
                                                <span class="text-mute">هزینه ارسال</span>
                                                <strong>{{ number_format($order->shipping_cost ?? 0) }} تومان</strong>
                                            </li>
                                            <li class="nav-item">
                                                <span class="text-mute">مبلغ مرسوله</span>
                                                <strong>{{ number_format($order->total) }} تومان</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- دکمه بازگشت -->
        <div class="my-5 text-center">
            <a href="{{ route('dashboard.orders') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right"></i> بازگشت به لیست سفارشات
            </a>
        </div>

    </div>
@endsection
