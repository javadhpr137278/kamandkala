@extends('home.layouts.master')
@section('content')
    @if($cartItems->isEmpty())
        <div class="content">
            <div class="container-fluid">
                <div class="cart-empty">
                    <div class="content-box">
                        <div class="container-fluid">
                            <div class="cart-empty-image text-center">
                                <img src="{{url('home/assets/img/mini_cart-empty.png')}}" width="300" alt="">
                            </div>
                            <div class="cart-empty-title">
                                <h2 class="text-center title-font">
                                    سبد خرید شما خالی میباشد
                                </h2>
                                <div class="text-center mt-3">
                                    <a href="{{route('home')}}" class="btn main-color-one-outline rounded-pill px-4">رفتن
                                        به صفحه اصلی</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <section class="container">
            <div class="title-breadcrumb-special dt-sl mb-3">
                <div class="breadcrumb dt-sl">
                    <nav><a href="{{route('home')}}">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.3763 15C9.3763 15.3452 9.65612 15.625 10.0013 15.625C10.3465 15.625 10.6263 15.3452 10.6263 15V12.5C10.6263 12.1548 10.3465 11.875 10.0013 11.875C9.65612 11.875 9.3763 12.1548 9.3763 12.5V15Z"
                                    fill="#020308" fill-opacity="0.64"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.0013 1.04167C9.39709 1.04167 8.84581 1.2076 8.24237 1.48926C7.65823 1.76191 6.98274 2.1643 6.13616 2.66861L4.92315 3.3912C3.99056 3.94673 3.24743 4.3894 2.68476 4.81271C2.10392 5.24969 1.66796 5.69967 1.38386 6.29227C1.09962 6.88516 1.02259 7.50567 1.0473 8.22987C1.07122 8.93086 1.19384 9.78305 1.34761 10.8516L1.59123 12.5447C1.78906 13.9197 1.94604 15.0107 2.18057 15.8601C2.42233 16.7358 2.76535 17.4308 3.38434 17.9638C4.00283 18.4963 4.74284 18.7345 5.64826 18.8481C6.52759 18.9584 7.63697 18.9583 9.03655 18.9583H10.966C12.3656 18.9583 13.475 18.9584 14.3544 18.8481C15.2598 18.7345 15.9998 18.4963 16.6183 17.9638C17.2373 17.4308 17.5803 16.7358 17.822 15.8601C18.0566 15.0107 18.2135 13.9197 18.4114 12.5448L18.655 10.8515C18.8088 9.78304 18.9314 8.93085 18.9553 8.22987C18.98 7.50567 18.903 6.88516 18.6187 6.29227C18.3346 5.69967 17.8987 5.24969 17.3178 4.81271C16.7552 4.3894 16.012 3.94673 15.0795 3.3912L13.8664 2.66861C13.0199 2.1643 12.3444 1.76191 11.7602 1.48926C11.1568 1.2076 10.6055 1.04167 10.0013 1.04167ZM6.74762 3.75935C7.62887 3.23439 8.25066 2.86485 8.77106 2.62195C9.27864 2.38503 9.64359 2.29167 10.0013 2.29167C10.359 2.29167 10.724 2.38503 11.2315 2.62195C11.7519 2.86485 12.3737 3.23439 13.255 3.75935L14.409 4.4468C15.3793 5.02478 16.064 5.43362 16.5664 5.81159C17.0567 6.18052 17.3253 6.48579 17.4916 6.83265C17.6577 7.17921 17.7268 7.57781 17.706 8.18725C17.6847 8.81212 17.5727 9.59693 17.4126 10.7092L17.1803 12.3237C16.9749 13.7513 16.828 14.7635 16.6171 15.5275C16.411 16.2741 16.1629 16.7064 15.8026 17.0165C15.4419 17.3272 14.9743 17.5105 14.1988 17.6078C13.4063 17.7072 12.3753 17.7083 10.923 17.7083H9.07958C7.62734 17.7083 6.59635 17.7072 5.8038 17.6078C5.02835 17.5105 4.56071 17.3272 4.19998 17.0165C3.83975 16.7064 3.59162 16.2741 3.38548 15.5275C3.17456 14.7635 3.02772 13.7513 2.8223 12.3237L2.58999 10.7092C2.42995 9.59692 2.31789 8.81211 2.29657 8.18724C2.27577 7.57781 2.34488 7.17921 2.51102 6.83265C2.67731 6.48579 2.94586 6.18052 3.43625 5.81159C3.93865 5.43362 4.62333 5.02478 5.59359 4.4468L6.74762 3.75935Z"
                                      fill="#020308" fill-opacity="0.64"></path>
                            </svg>
                            خانه</a><i class="fa-solid fa-angle-left"></i>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M9.99997 2.29167C8.96444 2.29167 8.12497 3.13114 8.12497 4.16667V4.37873C8.47289 4.375 8.84847 4.375 9.25434 4.37501H10.7456C11.1515 4.375 11.5271 4.375 11.875 4.37873V4.16667C11.875 3.13114 11.0355 2.29167 9.99997 2.29167ZM13.125 4.42245V4.16667C13.125 2.44078 11.7259 1.04167 9.99997 1.04167C8.27408 1.04167 6.87497 2.44078 6.87497 4.16667V4.42245C6.76247 4.43066 6.65391 4.44029 6.54912 4.45158C5.81715 4.53048 5.20504 4.69574 4.66146 5.06831C4.4745 5.19646 4.2989 5.34042 4.13658 5.49861C3.66464 5.95857 3.38253 6.52639 3.16163 7.22866C2.94715 7.91049 2.77381 8.77723 2.556 9.86633L2.5401 9.94582C2.22623 11.5151 1.9789 12.7517 1.90787 13.7366C1.83529 14.743 1.93671 15.5896 2.41341 16.3233C2.57246 16.5681 2.7581 16.7945 2.96695 16.9985C3.59289 17.6098 4.40319 17.8753 5.40423 18.0015C6.38397 18.125 7.64506 18.125 9.24542 18.125H10.7545C12.3549 18.125 13.616 18.125 14.5957 18.0015C15.5968 17.8753 16.4071 17.6098 17.033 16.9985C17.2418 16.7945 17.4275 16.5681 17.5865 16.3233C18.0632 15.5896 18.1647 14.743 18.0921 13.7366C18.021 12.7517 17.7737 11.5151 17.4599 9.94589L17.444 9.86636C17.2261 8.77724 17.0528 7.9105 16.8383 7.22866C16.6174 6.52639 16.3353 5.95857 15.8634 5.49861C15.701 5.34042 15.5254 5.19646 15.3385 5.06831C14.7949 4.69574 14.1828 4.53048 13.4508 4.45158C13.346 4.44029 13.2375 4.43066 13.125 4.42245ZM6.68307 5.69439C6.06081 5.76145 5.67639 5.88811 5.36815 6.09937C5.24023 6.18705 5.12008 6.28555 5.00902 6.39379C4.74141 6.65461 4.54182 7.00673 4.35402 7.60375C4.16211 8.21385 4.00114 9.01438 3.77465 10.1469C3.45003 11.7699 3.21933 12.9294 3.15463 13.8266C3.0908 14.7115 3.19857 15.2374 3.46159 15.6423C3.57042 15.8097 3.69743 15.9647 3.84033 16.1042C4.1857 16.4415 4.6803 16.6504 5.56057 16.7613C6.45298 16.8738 7.63517 16.875 9.29041 16.875H10.7095C12.3648 16.875 13.547 16.8738 14.4394 16.7613C15.3196 16.6504 15.8142 16.4415 16.1596 16.1042C16.3025 15.9647 16.4295 15.8097 16.5384 15.6423C16.8014 15.2374 16.9091 14.7115 16.8453 13.8266C16.7806 12.9294 16.5499 11.7699 16.2253 10.1469C15.9988 9.01438 15.8378 8.21385 15.6459 7.60375C15.4581 7.00673 15.2585 6.65461 14.9909 6.39379C14.8799 6.28555 14.7597 6.18705 14.6318 6.09937C14.3236 5.88811 13.9391 5.76145 13.3169 5.69439C12.681 5.62585 11.8644 5.62501 10.7095 5.62501L9.29041 5.62501C8.13551 5.62501 7.31896 5.62585 6.68307 5.69439ZM7.43411 11.9107C7.75956 11.7957 8.11663 11.9663 8.23166 12.2917C8.48936 13.0208 9.18472 13.5417 10.0001 13.5417C10.8155 13.5417 11.5109 13.0208 11.7686 12.2917C11.8836 11.9663 12.2407 11.7957 12.5662 11.9107C12.8916 12.0258 13.0622 12.3828 12.9472 12.7083C12.5185 13.9212 11.3618 14.7917 10.0001 14.7917C8.63851 14.7917 7.48181 13.9212 7.05311 12.7083C6.93808 12.3828 7.10866 12.0258 7.43411 11.9107Z"
                                  fill="#1D2977"></path>
                        </svg>
                        <span>سبد خرید</span></nav>
                </div>
            </div>
            <div class="woocommerce-notices-wrapper"></div>
            <section class="cart-page-woocommerce-kamand">
                <form class="cart-page-items" action="" method="post">
                    <div class="cart-page-products">
                        <section class="header-categories-main">
                            <div class="title-header-categories-main"><span>SHOPPING CART</span>
                                <div class="text-header-categories-main"><span>سبد <strong>خریــــــد</strong></span>
                                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_26_3865)">
                                            <circle cx="32" cy="32" r="32" transform="matrix(-1 0 0 1 64 0)"
                                                    fill="#FFD701"></circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M42 10.2917C40.9644 10.2917 40.125 11.1311 40.125 12.1667V12.3787C40.4729 12.375 40.8485 12.375 41.2543 12.375H42.7456C43.1515 12.375 43.5271 12.375 43.875 12.3787V12.1667C43.875 11.1311 43.0355 10.2917 42 10.2917ZM45.125 12.4224V12.1667C45.125 10.4408 43.7259 9.04166 42 9.04166C40.2741 9.04166 38.875 10.4408 38.875 12.1667V12.4224C38.7625 12.4306 38.6539 12.4403 38.5491 12.4516C37.8172 12.5305 37.205 12.6957 36.6615 13.0683C36.4745 13.1964 36.2989 13.3404 36.1366 13.4986C35.6646 13.9586 35.3825 14.5264 35.1616 15.2286C34.9471 15.9105 34.7738 16.7772 34.556 17.8663L34.5401 17.9458C34.2262 19.5151 33.9789 20.7517 33.9079 21.7366C33.8353 22.743 33.9367 23.5896 34.4134 24.3233C34.5725 24.5681 34.7581 24.7945 34.9669 24.9985C35.5929 25.6098 36.4032 25.8753 37.4042 26.0015C38.384 26.125 39.6451 26.125 41.2454 26.125H42.7545C44.3549 26.125 45.616 26.125 46.5957 26.0015C47.5968 25.8753 48.4071 25.6098 49.033 24.9985C49.2418 24.7945 49.4275 24.5681 49.5865 24.3233C50.0632 23.5896 50.1647 22.743 50.0921 21.7366C50.021 20.7517 49.7737 19.5151 49.4599 17.9459L49.444 17.8663C49.2261 16.7772 49.0528 15.9105 48.8383 15.2286C48.6174 14.5264 48.3353 13.9586 47.8634 13.4986C47.701 13.3404 47.5254 13.1964 47.3385 13.0683C46.7949 12.6957 46.1828 12.5305 45.4508 12.4516C45.346 12.4403 45.2375 12.4306 45.125 12.4224ZM38.6831 13.6944C38.0608 13.7614 37.6764 13.8881 37.3682 14.0994C37.2402 14.187 37.1201 14.2855 37.009 14.3938C36.7414 14.6546 36.5418 15.0067 36.354 15.6037C36.1621 16.2138 36.0011 17.0144 35.7746 18.1468C35.45 19.7699 35.2193 20.9294 35.1546 21.8265C35.0908 22.7115 35.1986 23.2374 35.4616 23.6422C35.5704 23.8097 35.6974 23.9647 35.8403 24.1042C36.1857 24.4415 36.6803 24.6504 37.5606 24.7613C38.453 24.8738 39.6352 24.875 41.2904 24.875H42.7095C44.3648 24.875 45.547 24.8738 46.4394 24.7613C47.3196 24.6504 47.8142 24.4415 48.1596 24.1042C48.3025 23.9647 48.4295 23.8097 48.5384 23.6422C48.8014 23.2374 48.9091 22.7115 48.8453 21.8265C48.7806 20.9294 48.5499 19.7699 48.2253 18.1468C47.9988 17.0144 47.8378 16.2138 47.6459 15.6037C47.4581 15.0067 47.2585 14.6546 46.9909 14.3938C46.8799 14.2855 46.7597 14.187 46.6318 14.0994C46.3236 13.8881 45.9391 13.7614 45.3169 13.6944C44.681 13.6258 43.8644 13.625 42.7095 13.625L41.2904 13.625C40.1355 13.625 39.319 13.6258 38.6831 13.6944ZM39.4341 19.9107C39.7596 19.7957 40.1166 19.9663 40.2317 20.2917C40.4894 21.0208 41.1847 21.5417 42.0001 21.5417C42.8155 21.5417 43.5109 21.0208 43.7686 20.2917C43.8836 19.9663 44.2407 19.7957 44.5662 19.9107C44.8916 20.0257 45.0622 20.3828 44.9472 20.7083C44.5185 21.9212 43.3618 22.7917 42.0001 22.7917C40.6385 22.7917 39.4818 21.9212 39.0531 20.7083C38.9381 20.3828 39.1087 20.0257 39.4341 19.9107Z"
                                                  fill="#1D2977"></path>
                                            <circle cx="22" cy="60" r="17" fill="#F7F8FD" fill-opacity="0.64"></circle>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_26_3865">
                                                <rect width="64" height="64" rx="32" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="shape-header-categories-main"></div>
                            </div>
                        </section>
                        <section class="cart-page-items-products">
                            @foreach($cartItems as $item)
                                <div class="cart-page-item-product">
                                    <a href="{{ route('single.product', $item->product->slug) }}"
                                       class="cart-page-item-product-images">
                                        <img fetchpriority="high" width="300" height="300"
                                             src="{{ asset('storage/products/' . $item->product->image) }}"
                                             class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                             alt="{{ $item->product->title }}" decoding="async">
                                        <div class="cart-page-item-product-images-circle-one"></div>
                                        <div class="cart-page-item-product-images-circle-two"></div>
                                        <div class="cart-page-item-product-images-circle-three"></div>
                                    </a>
                                    <div class="cart-page-item-product-content">
                                        <div class="cart-page-item-product-content-item">
                                            <span class="name-product">نام محصول</span>
                                            <div class="product-info">
                                                <a href="{{ route('single.product', $item->product->slug) }}"
                                                   target="_blank" class="name-product-content">
                                                    {{ $item->product->title ?? $item->product->name ?? 'محصول نامشخص' }}
                                                </a>
                                                @if($item->variant_title)
                                                    <div class="product-variant-info mt-1">
                                                        <span class="variant-label">مدل:</span>
                                                        <span
                                                            class="variant-name">{{ $item->productVariant->title ?? $item->variant_title ?? '' }}</span>
                                                    </div>
                                                @endif
                                                @if($item->color)
                                                    <div class="product-color-info mt-1">
                                                        <span class="color-label">رنگ:</span>
                                                        <span class="color-dot"
                                                              style="background-color:#{{ $item->color->code }}; display: inline-block; width: 16px; height: 16px; border-radius: 50%; margin: 0 5px; vertical-align: middle; border: 1px solid #ddd;"></span>
                                                        <span class="color-name">{{ $item->color->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="cart-page-item-product-content-item">
                                            <span class="name-product">قیمت جزء</span>
                                            <div class="cart-price-amount-fee">
                                                <div class="cart-price-amount-fee-shape"></div>
                                                <span
                                                    class="price-amount-fee">{{ number_format($item->price) }}&nbsp;</span>
                                                <span class="price-amount-fee-symbol">تومان</span>
                                            </div>
                                        </div>
                                        <div class="cart-page-item-product-content-item">
                                            <span class="name-product">تعداد</span>
                                            <div class="cart-counter-product" data-cart-id="{{ $item->id }}">
                                                <button type="button" class="cart-counter-plus"
                                                        data-id="{{ $item->id }}">+
                                                </button>
                                                <input class="number-input-cart cart-quantity-input"
                                                       data-id="{{ $item->id }}"
                                                       name="cart[{{ $item->id }}][qty]"
                                                       value="{{ $item->quantity }}"
                                                       data-product_name="{{ $item->product->title ?? $item->product->name }}"
                                                       min="1"
                                                       max="{{ $item->productVariant->stock ?? 10 }}"
                                                       type="text"
                                                       inputmode="numeric">
                                                <button type="button" class="cart-counter-mines"
                                                        data-id="{{ $item->id }}">-
                                                </button>
                                            </div>
                                        </div>
                                        <div class="cart-page-item-product-content-item">
                                            <span class="name-product">قیمت کل</span>
                                            <div class="cart-price-amount-fee">
                                                <div class="cart-price-amount-fee-shape"></div>
                                                <span class="price-amount-fee cart-item-total-{{ $item->id }}">{{ number_format($item->price * $item->quantity) }}&nbsp;</span>
                                                <span class="price-amount-fee-symbol">تومان</span>
                                            </div>
                                        </div>
                                        <div class="cart-page-item-product-content-item">
                                            <a role="button" href="#" class="remove-from-cart" data-id="{{ $item->id }}"
                                               aria-label="حذف {{ $item->product->title ?? $item->product->name }} از سبد خرید">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.6575 17.657L12.0006 12.0001M12.0006 12.0001L6.34375 6.34326M12.0006 12.0001L17.6575 6.34326M12.0006 12.0001L6.34375 17.657"
                                                        stroke="#1D2977" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <button type="button" class="button-update-cart" id="update-all-cart" name="update_cart"
                                    value="بروزرسانی سبد">
                                بروزرسانی سبد خرید
                            </button>
                        </section>
                    </div>
                    <div class="cart-page-discount-code">
                        <section class="header-categories-main">
                            <div class="title-header-categories-main">
                                <span>OFF</span>
                                <div class="text-header-categories-main">
                                    <span>کـــد <strong>تخفیف</strong></span>
                                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <!-- SVG content شما -->
                                    </svg>
                                </div>
                                <div class="shape-header-categories-main"></div>
                            </div>
                        </section>

                        <div class="coupon">
                            <span>کد تخفیف خود را وارد کنید:</span>
                            <label for="coupon_code" class="screen-reader-text">کوپن:</label>
                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                                   placeholder="کد تخفیف">
                            <button type="button" class="button" id="apply-coupon" name="apply_coupon"
                                    value="اعمال تخفیف">
                                اعمال تخفیف
                            </button>
                        </div>

                        {{-- نمایش کد تخفیف اعمال شده --}}
                        <div id="discount-section">
                            @if(session('discount'))
                                <div class="applied-discount-box" id="applied-discount-box">
                                    <div class="applied-code">
                                        <span class="code-label">کد تخفیف اعمال شده:</span>
                                        <strong class="code-value">{{ session('discount.code') }}</strong>
                                        <span class="discount-value">(-{{ number_format(session('discount.amount')) }} تومان)</span>
                                        <button type="button" class="remove-discount-btn"
                                                onclick="removeDiscountCode()">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                                      stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if(session('gift_card'))
                            <div class="applied-giftcard-box" id="applied-giftcard-box">
                                <div class="applied-code">
                                    <span class="code-label">کارت هدیه اعمال شده:</span>
                                    <strong class="code-value">{{ session('gift_card.code') }}</strong>
                                    <span class="balance-value">(موجودی: {{ number_format(session('gift_card.balance')) }} تومان)</span>
                                    <button type="button" class="remove-giftcard-btn" onclick="removeGiftCardCode()">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                                  stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
                <div class="cart-page-peyments">
                    <div class="cart_totals ">
                        <div class="title-header-categories-main"><span>BILL</span>
                            <div class="text-header-categories-main"><span><strong>صورتحســاب</strong></span>
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_32_2555)">
                                        <circle cx="32" cy="32" r="32" transform="matrix(-1 0 0 1 64 0)"
                                                fill="#FFD701"></circle>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M37.9157 9.04163C37.9557 9.04165 37.9963 9.04166 38.0376 9.04166H45.9625C46.0038 9.04166 46.0444 9.04165 46.0845 9.04163C46.9318 9.04126 47.5149 9.041 48.006 9.21188C48.9334 9.5346 49.6535 10.281 49.9622 11.2213L49.3684 11.4162L49.9622 11.2213C50.1256 11.7189 50.1254 12.3104 50.1251 13.1887C50.1251 13.228 50.1251 13.2679 50.1251 13.3084V24.9785C50.1251 26.1995 48.6859 26.9265 47.738 26.0591C47.6718 25.9985 47.5783 25.9985 47.5121 26.0591L47.1095 26.4275C46.336 27.1353 45.1641 27.1353 44.3906 26.4275C44.0948 26.1568 43.6553 26.1568 43.3595 26.4275C42.586 27.1353 41.4141 27.1353 40.6406 26.4275C40.3448 26.1568 39.9053 26.1568 39.6095 26.4275C38.836 27.1353 37.6641 27.1353 36.8906 26.4275L36.488 26.0591C36.4218 25.9985 36.3283 25.9985 36.2621 26.0591C35.3142 26.9265 33.8751 26.1995 33.8751 24.9785V13.3084C33.8751 13.2679 33.875 13.228 33.875 13.1887C33.8747 12.3104 33.8745 11.7189 34.0379 11.2213C34.3466 10.281 35.0667 9.5346 35.9942 9.21188C36.4853 9.041 37.0684 9.04126 37.9157 9.04163ZM38.0376 10.2917C37.02 10.2917 36.6695 10.3004 36.4049 10.3925C35.8555 10.5837 35.416 11.031 35.2255 11.6112C35.1329 11.8931 35.1251 12.2649 35.1251 13.3084V24.9785C35.1251 25.0777 35.175 25.1384 35.2376 25.1673C35.2703 25.1824 35.3022 25.1863 35.3288 25.1828C35.3522 25.1796 35.3826 25.1695 35.4182 25.1369C35.9621 24.6392 36.788 24.6392 37.3319 25.1369L37.7345 25.5053C38.0303 25.776 38.4698 25.776 38.7656 25.5053C39.5391 24.7975 40.711 24.7975 41.4845 25.5053C41.7803 25.776 42.2198 25.776 42.5156 25.5053C43.2891 24.7975 44.461 24.7975 45.2345 25.5053C45.5303 25.776 45.9698 25.776 46.2656 25.5053L46.6682 25.1369C47.2121 24.6392 48.038 24.6392 48.5819 25.1369C48.6175 25.1695 48.6479 25.1796 48.6713 25.1828C48.6979 25.1863 48.7298 25.1824 48.7625 25.1673C48.8251 25.1384 48.8751 25.0777 48.8751 24.9785V13.3084C48.8751 12.2649 48.8672 11.8931 48.7746 11.6112C48.5841 11.031 48.1447 10.5837 47.5952 10.3925C47.3306 10.3004 46.9801 10.2917 45.9625 10.2917H38.0376ZM37.2084 14.25C37.2084 13.9048 37.4882 13.625 37.8334 13.625H38.2501C38.5952 13.625 38.8751 13.9048 38.8751 14.25C38.8751 14.5952 38.5952 14.875 38.2501 14.875H37.8334C37.4882 14.875 37.2084 14.5952 37.2084 14.25ZM40.1251 14.25C40.1251 13.9048 40.4049 13.625 40.7501 13.625H46.1667C46.5119 13.625 46.7917 13.9048 46.7917 14.25C46.7917 14.5952 46.5119 14.875 46.1667 14.875H40.7501C40.4049 14.875 40.1251 14.5952 40.1251 14.25ZM37.2084 17.1667C37.2084 16.8215 37.4882 16.5417 37.8334 16.5417H38.2501C38.5952 16.5417 38.8751 16.8215 38.8751 17.1667C38.8751 17.5118 38.5952 17.7917 38.2501 17.7917H37.8334C37.4882 17.7917 37.2084 17.5118 37.2084 17.1667ZM40.1251 17.1667C40.1251 16.8215 40.4049 16.5417 40.7501 16.5417H46.1667C46.5119 16.5417 46.7917 16.8215 46.7917 17.1667C46.7917 17.5118 46.5119 17.7917 46.1667 17.7917H40.7501C40.4049 17.7917 40.1251 17.5118 40.1251 17.1667ZM37.2084 20.0833C37.2084 19.7382 37.4882 19.4583 37.8334 19.4583H38.2501C38.5952 19.4583 38.8751 19.7382 38.8751 20.0833C38.8751 20.4285 38.5952 20.7083 38.2501 20.7083H37.8334C37.4882 20.7083 37.2084 20.4285 37.2084 20.0833ZM40.1251 20.0833C40.1251 19.7382 40.4049 19.4583 40.7501 19.4583H46.1667C46.5119 19.4583 46.7917 19.7382 46.7917 20.0833C46.7917 20.4285 46.5119 20.7083 46.1667 20.7083H40.7501C40.4049 20.7083 40.1251 20.4285 40.1251 20.0833Z"
                                              fill="#1D2977"></path>
                                        <circle cx="22" cy="60" r="17" fill="#F7F8FD" fill-opacity="0.64"></circle>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_32_2555">
                                            <rect width="64" height="64" rx="32" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="shape-header-categories-main"></div>
                        </div>
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                            <tbody>
                            <tr class="cart-subtotal">
                                <th>مبلغ سفارش</th>
                                <td data-title="مبلغ سفارش">
                        <span class="woocommerce-Price-amount amount">
                            <bdi>
                                <span id="cart-subtotal">{{ number_format($subtotal ?? 0) }}</span>&nbsp;
                                <span class="woocommerce-Price-currencySymbol">تومان</span>
                            </bdi>
                        </span>
                                </td>
                            </tr>

                            @if(session('discount'))
                                <tr class="discount-row">
                                    <th>تخفیف ({{ session('discount.code') }})</th>
                                    <td data-title="تخفیف">
                        <span class="woocommerce-Price-amount amount discount-amount">
                            <bdi>-{{ number_format(session('discount.amount', 0)) }}&nbsp;تومان</bdi>
                        </span>
                                    </td>
                                </tr>
                            @endif

                            @if(session('gift_card'))
                                <tr class="giftcard-row">
                                    <th>کارت هدیه ({{ session('gift_card.code') }})</th>
                                    <td data-title="کارت هدیه">
                        <span class="woocommerce-Price-amount amount giftcard-amount">
                            <bdi>-{{ number_format(session('gift_card.balance', 0)) }}&nbsp;تومان</bdi>
                        </span>
                                    </td>
                                </tr>
                            @endif

                            <tr class="order-total">
                                <th>مبلغ نهایی سفارش</th>
                                <td data-title="مجموع">
                                    <strong>
                            <span class="woocommerce-Price-amount amount">
                                <bdi>
                                    <span id="cart-total">{{ number_format($finalTotal ?? $subtotal ?? 0) }}</span>&nbsp;
                                    <span class="woocommerce-Price-currencySymbol">تومان</span>
                                </bdi>
                            </span>
                                    </strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="wc-proceed-to-checkout">
                            <a href="{{route('checkout')}}" class="proceed-to-checkout" id="checkout-btn">
                                <div>ثبت سفارش</div>
                                <div>
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M23.4214 13.4056C23.2646 13.5623 23.0502 13.6613 22.8027 13.6613L13.6621 13.6613L13.6621 22.8019C13.6621 23.2803 13.2662 23.6763 12.7877 23.6763C12.3092 23.6763 11.9132 23.2803 11.9132 22.8019L11.9132 12.7869C11.9132 12.3084 12.3092 11.9124 12.7877 11.9124L22.8027 11.9124C23.2811 11.9124 23.6771 12.3084 23.6771 12.7869C23.6854 13.0261 23.5781 13.2489 23.4214 13.4056Z"
                                            fill="white"></path>
                                        <path
                                            d="M27.4296 27.4299C27.0914 27.7681 26.5304 27.7681 26.1922 27.4299L12.3082 13.5458C11.9699 13.2076 11.9699 12.6466 12.3082 12.3084C12.6464 11.9702 13.2074 11.9702 13.5456 12.3084L27.4296 26.1924C27.7679 26.5307 27.7679 27.0917 27.4296 27.4299Z"
                                            fill="white"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    @endif
@endsection

@push('scripts')
    <script>

    <style>
        .applied-discount-box {
            background: #e8f5e9;
            padding: 10px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #c8e6c9;
        }
        .applied-code {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .code-label {
            font-size: 14px;
            color: #2e7d32;
        }
        .code-value {
            font-weight: bold;
            color: #1b5e20;
            font-size: 16px;
        }
        .discount-value {
            color: #d32f2f;
            font-weight: bold;
        }
        .remove-discount-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #d32f2f;
            font-size: 18px;
            padding: 0 5px;
            display: inline-flex;
            align-items: center;
        }
        .remove-discount-btn:hover {
            opacity: 0.7;
        }
        .cart-discount {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .discount-row td,
        .discount-row th {
            color: #d32f2f;
        }
        #discount-section {
            margin-top: 15px;
        }
        #apply-coupon {
            background: #4caf50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        #apply-coupon:hover {
            background: #45a049;
        }
        #apply-coupon:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush
