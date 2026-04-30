@extends('home.layouts.master')
@section('content')
    <section class="header-view-order container py-20">
        <div class="header-view-order-wrapper">
            <!-- شماره سفارش -->
            <div class="header-view-order-item">
                <div class="header-view-order-icon">
                    <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.28809 0.5V6.85156H12.7119V0.5H16.4414V6.85156H20.5V10.3779H16.4414V15.8027H20.5V19.3281H16.4414V25.5H12.7119V19.3281H8.28809V25.5H4.55859V19.3281H0.5V15.8027H4.55859V10.3779H0.5V6.85156H4.55859V0.5H8.28809ZM8.28809 15.8027H12.7119V10.3779H8.28809V15.8027Z" stroke="white"></path>
                        <path d="M7.93066 0.5V6.85156H12.0693V0.5H15.6553V6.85156H19.5V10.3779H15.6553V15.8027H19.5V19.3281H15.6553V25.5H12.0693V19.3281H7.93066V25.5H4.34473V19.3281H0.5V15.8027H4.34473V10.3779H0.5V6.85156H4.34473V0.5H7.93066ZM7.93066 15.8027H12.0693V10.3779H7.93066V15.8027Z" stroke="#1D2977"></path>
                    </svg>
                </div>
                <div class="header-view-order-content">
                    <div class="header-view-order-content-text">{{ $order->order_number }}</div>
                    <span>شماره سفارش</span>
                </div>
            </div>

            <!-- تاریخ سفارش -->
            <div class="header-view-order-item">
                <div class="header-view-order-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 9H21.5" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z" stroke="#1D2977" stroke-width="1.5"></path>
                        <path d="M7 4V2.5" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M17 4V2.5" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M17 16.5C17.2761 16.5 17.5 16.7239 17.5 17C17.5 17.2761 17.2761 17.5 17 17.5C16.7239 17.5 16.5 17.2761 16.5 17C16.5 16.7239 16.7239 16.5 17 16.5ZM17 12.5C17.2761 12.5 17.5 12.7239 17.5 13C17.5 13.2761 17.2761 13.5 17 13.5C16.7239 13.5 16.5 13.2761 16.5 13C16.5 12.7239 16.7239 12.5 17 12.5Z" fill="#1C274C" stroke="#1D2977"></path>
                        <path d="M12 16.5C12.2761 16.5 12.5 16.7239 12.5 17C12.5 17.2761 12.2761 17.5 12 17.5C11.7239 17.5 11.5 17.2761 11.5 17C11.5 16.7239 11.7239 16.5 12 16.5ZM12 12.5C12.2761 12.5 12.5 12.7239 12.5 13C12.5 13.2761 12.2761 13.5 12 13.5C11.7239 13.5 11.5 13.2761 11.5 13C11.5 12.7239 11.7239 12.5 12 12.5Z" fill="#1C274C" stroke="#1D2977"></path>
                        <path d="M7 16.5C7.27614 16.5 7.5 16.7239 7.5 17C7.5 17.2761 7.27614 17.5 7 17.5C6.72386 17.5 6.5 17.2761 6.5 17C6.5 16.7239 6.72386 16.5 7 16.5ZM7 12.5C7.27614 12.5 7.5 12.7239 7.5 13C7.5 13.2761 7.27614 13.5 7 13.5C6.72386 13.5 6.5 13.2761 6.5 13C6.5 12.7239 6.72386 12.5 7 12.5Z" fill="#1C274C" stroke="#1D2977"></path>
                    </svg>
                </div>
                <div class="header-view-order-content">
                    <div class="header-view-order-content-text">{{ $persianDate }}</div>
                    <span>تاریخ ثبت سفارش</span>
                </div>
            </div>

            <!-- وضعیت پرداخت -->
            <div class="header-view-order-item">
                <div class="header-view-order-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 16H6" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M14 16H12.5" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M2 10L22 10" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z" stroke="#1D2977" stroke-width="1.5"></path>
                    </svg>
                </div>
                <div class="header-view-order-content">
                    <div class="header-view-order-content-text">{{ $paymentStatus }}</div>
                    <span>وضعیت پرداخت</span>
                </div>
            </div>

            <!-- مبلغ سفارش -->
            <div class="header-view-order-item">
                <div class="header-view-order-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 19C6.19108 19 4.78661 19 3.77772 18.3259C3.34096 18.034 2.96596 17.659 2.67412 17.2223C2 16.2134 2 14.8089 2 12C2 9.19108 2 7.78661 2.67412 6.77772C2.96596 6.34096 3.34096 5.96596 3.77772 5.67412C4.78661 5 6.19108 5 9 5L15 5C17.8089 5 19.2134 5 20.2223 5.67412C20.659 5.96596 21.034 6.34096 21.3259 6.77772C22 7.78661 22 9.19108 22 12C22 14.8089 22 16.2134 21.3259 17.2223C21.034 17.659 20.659 18.034 20.2223 18.3259C19.2134 19 17.8089 19 15 19H9Z" stroke="#1D2977" stroke-width="1.5"></path>
                        <path d="M9 9C7.34315 9 6 10.3431 6 12C6 13.6569 7.34315 15 9 15" stroke="white" stroke-width="1.5"></path>
                        <path d="M15 9C16.6569 9 18 10.3431 18 12C18 13.6569 16.6569 15 15 15" stroke="white" stroke-width="1.5"></path>
                        <path d="M9 5V18.5" stroke="#1D2977" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M15 5V18.5" stroke="#1D2977" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="header-view-order-content">
                    <div class="header-view-order-content-text">
                        <div class="header-view-order-content-text-price">
                            <div></div>
                            <span>{{ number_format($order->total) }}</span>
                            <span>تومان</span>
                        </div>
                    </div>
                    <span>مبلغ سفارش</span>
                </div>
            </div>
        </div>
        <div class="header-view-order-shape-one"></div>
        <div class="header-view-order-shape-two"></div>
        <div class="header-view-order-shape-three"></div>
        <div class="header-view-order-shape-four"></div>
    </section>

    <!-- بخش جزئیات محصولات سفارش -->
    <section class="order-details-section container">
        <div class="order-details-wrapper">
            <h3>جزئیات سفارش</h3>
            <table class="table-view-order container">
                <tbody>
                <tr>
                    <th>محصول</th>
                    <th>رنگ</th>
                    <th>تعداد</th>
                    <th>قیمت واحد</th>
                    <th>جمع</th>
                </tr>
                @foreach($orderItems as $item)
                    <tr>
                        <td>
                            <a href="{{ route('single.product', $item['product_slug'] ?? '#') }}">
                                @php
                                    // اگر product_name خالی است، از دیتابیس دریافت کن
                                    $productName = $item['product_name'];
                                    if (empty($productName) && isset($item['product_id'])) {
                                        $product = \App\Models\Product::find($item['product_id']);
                                        $productName = $product->title ?? $product->name ?? $product->product_name ?? 'محصول';
                                    }
                                @endphp
                                {{ $productName }}
                            </a>
                        </td>
                        <td>
                            @if(isset($item['color_name']) && $item['color_name'])
                                <small>{{ $item['color_name'] }}</small>
                            @endif
                        </td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>
                            <div class="header-view-order-content-text">
                                <div class="header-view-order-content-text-price">
                                    <div></div>
                                    <span>{{ number_format($item['unit_price']) }}</span><span>تومان</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="header-view-order-content-text">
                                <div class="header-view-order-content-text-price">
                                    <div></div>
                                    <span>{{ number_format($item['total_price']) }}</span><span>تومان</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
        </table>
        </div>
    </section>

    <!-- بخش اطلاعات ارسال -->
    <section class="data-view-order container">
        <h4>اطلاعات ارسال</h4>
        <div class="data-view-order-content">
            <div class="data-view-order-content-right">
                <span>وضعیت سفارش</span>
                <span>تاریخ ارسال</span>
                <span>نحوه ی ارسال</span>
                <span>نحوه ی پرداخت</span>
                <span>شناسه پرداخت</span>
            </div>
            @php
                $payment = \App\Models\Payment::where('order_id', $order->id)->first();
            @endphp
            <div class="data-view-order-content-left">
                <span>{{ $orderStatus }}</span>
                <span>{{ verta($order->shipping_date_persian ?? $order->shipping_date)->format('Y/m/d') }}</span>
                <span>نرخ ثابت - {{ number_format($order->shipping_cost) }} تومان</span>
                <span>{{ $paymentStatus }}</span>
                <span>{{ $payment->metadata['trackId'] ?? '' }}</span>
            </div>
        </div>
    </section>

    <section class="data-view-order container">
        <h4>آدرس ارسال</h4>
        <div class="data-view-order-content">
            <div class="data-view-order-content-right">
                <span>نام و نام خانوادگی</span>
                <span>شماره همراه</span>
                <span>کد پستی</span>
                <span>ایمیل</span>
                <span>شهر</span>
                <span>استان</span>
                <span>آدرس پستی</span>
            </div>
            <div class="data-view-order-content-left">
                <span>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</span>
                <span>{{ $order->billing_phone }}</span>
                <span>
                    @if($order->address_choice == 'billing')
                        {{ $order->billing_postcode }}
                    @elseif($order->address_choice == 'shipping')
                        {{ $order->shipping_postcode }}
                    @else
                        {{ $order->custom_postcode }}
                    @endif
                </span>
                <span>{{ $order->billing_email ?? 'ثبت نشده' }}</span>
                <span>
                    @if($order->address_choice == 'billing')
                        {{ $order->billing_city }}
                    @elseif($order->address_choice == 'shipping')
                        {{ $order->shipping_city }}
                    @else
                        {{ $order->custom_city }}
                    @endif
                </span>
                <span>
                    @if($order->address_choice == 'billing')
                        {{ $order->billing_state }}
                    @elseif($order->address_choice == 'shipping')
                        {{ $order->shipping_state }}
                    @else
                        -
                    @endif
                </span>
                <span>
                    @if($order->address_choice == 'billing')
                        {{ $order->billing_address_1 }}
                        @if($order->billing_address_2) ، {{ $order->billing_address_2 }} @endif
                    @elseif($order->address_choice == 'shipping')
                        {{ $order->shipping_address_1 }}
                        @if($order->shipping_address_2) ، {{ $order->shipping_address_2 }} @endif
                    @else
                        {{ $order->custom_address }}
                    @endif
                </span>
            </div>
        </div>
    </section>

    <!-- دکمه بازگشت -->
    <a class="btn-back-home-thankyou container" href="{{route('home')}}"><span>بازگشت به صفحه اصلی</span>
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23.4214 13.4056C23.2646 13.5623 23.0502 13.6613 22.8027 13.6613L13.6621 13.6613L13.6621 22.8018C13.6621 23.2803 13.2662 23.6763 12.7877 23.6763C12.3092 23.6763 11.9132 23.2803 11.9132 22.8018L11.9132 12.7869C11.9132 12.3084 12.3092 11.9124 12.7877 11.9124L22.8027 11.9124C23.2811 11.9124 23.6771 12.3084 23.6771 12.7869C23.6854 13.0261 23.5781 13.2488 23.4214 13.4056Z" fill="white"></path>
            <path d="M27.4296 27.4298C27.0914 27.768 26.5304 27.768 26.1922 27.4298L12.3082 13.5458C11.9699 13.2075 11.9699 12.6466 12.3082 12.3083C12.6464 11.9701 13.2074 11.9701 13.5456 12.3083L27.4296 26.1924C27.7679 26.5306 27.7679 27.0916 27.4296 27.4298Z" fill="white"></path>
        </svg>
    </a>
@endsection


