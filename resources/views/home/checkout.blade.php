{{-- resources/views/home/checkout.blade.php --}}
@extends('home.layouts.master')
@section('content')
    <form name="checkout" method="post" class="checkout woocommerce-checkout container py-20"
          action="{{ route('checkout.store') }}"
          enctype="multipart/form-data"
          id="checkout-form">
        @csrf
        <section class="section-woocommerce-checkout-customer-details">
            <section class="header-categories-main">
                <div class="title-header-categories-main"><span>PLACE ORDER</span>
                    <div class="text-header-categories-main"><span><strong>ثبت سفارش</strong></span>
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_34_2948)">
                                <circle cx="32" cy="32" r="32" transform="matrix(-1 0 0 1 64 0)"
                                        fill="#FFD701"></circle>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M42 10.2917C40.9644 10.2917 40.125 11.1311 40.125 12.1667V12.3787C40.4729 12.375 40.8485 12.375 41.2543 12.375H42.7456C43.1515 12.375 43.5271 12.375 43.875 12.3787V12.1667C43.875 11.1311 43.0355 10.2917 42 10.2917ZM45.125 12.4224V12.1667C45.125 10.4408 43.7259 9.04166 42 9.04166C40.2741 9.04166 38.875 10.4408 38.875 12.1667V12.4224C38.7625 12.4306 38.6539 12.4403 38.5491 12.4516C37.8172 12.5305 37.205 12.6957 36.6615 13.0683C36.4745 13.1964 36.2989 13.3404 36.1366 13.4986C35.6646 13.9586 35.3825 14.5264 35.1616 15.2286C34.9471 15.9105 34.7738 16.7772 34.556 17.8663L34.5401 17.9458C34.2262 19.5151 33.9789 20.7517 33.9079 21.7366C33.8353 22.743 33.9367 23.5896 34.4134 24.3233C34.5725 24.5681 34.7581 24.7945 34.9669 24.9985C35.5929 25.6098 36.4032 25.8753 37.4042 26.0015C38.384 26.125 39.6451 26.125 41.2454 26.125H42.7545C44.3549 26.125 45.616 26.125 46.5957 26.0015C47.5968 25.8753 48.4071 25.6098 49.033 24.9985C49.2418 24.7945 49.4275 24.5681 49.5865 24.3233C50.0632 23.5896 50.1647 22.743 50.0921 21.7366C50.021 20.7517 49.7737 19.5151 49.4599 17.9459L49.444 17.8663C49.2261 16.7772 49.0528 15.9105 48.8383 15.2286C48.6174 14.5264 48.3353 13.9586 47.8634 13.4986C47.701 13.3404 47.5254 13.1964 47.3385 13.0683C46.7949 12.6957 46.1828 12.5305 45.4508 12.4516C45.346 12.4403 45.2375 12.4306 45.125 12.4224ZM38.6831 13.6944C38.0608 13.7614 37.6764 13.8881 37.3682 14.0994C37.2402 14.187 37.1201 14.2855 37.009 14.3938C36.7414 14.6546 36.5418 15.0067 36.354 15.6037C36.1621 16.2138 36.0011 17.0144 35.7746 18.1468C35.45 19.7699 35.2193 20.9294 35.1546 21.8265C35.0908 22.7115 35.1986 23.2374 35.4616 23.6422C35.5704 23.8097 35.6974 23.9647 35.8403 24.1042C36.1857 24.4415 36.6803 24.6504 37.5606 24.7613C38.453 24.8738 39.6352 24.875 41.2904 24.875H42.7095C44.3648 24.875 45.547 24.8738 46.4394 24.7613C47.3196 24.6504 47.8142 24.4415 48.1596 24.1042C48.3025 23.9647 48.4295 23.8097 48.5384 23.6422C48.8014 23.2374 48.9091 22.7115 48.8453 21.8265C48.7806 20.9294 48.5499 19.7699 48.2253 18.1468C47.9988 17.0144 47.8378 16.2138 47.6459 15.6037C47.4581 15.0067 47.2585 14.6546 46.9909 14.3938C46.8799 14.2855 46.7597 14.187 46.6318 14.0994C46.3236 13.8881 45.9391 13.7614 45.3169 13.6944C44.681 13.6258 43.8644 13.625 42.7095 13.625L41.2904 13.625C40.1355 13.625 39.319 13.6258 38.6831 13.6944ZM39.4341 19.9107C39.7596 19.7957 40.1166 19.9663 40.2317 20.2917C40.4894 21.0208 41.1847 21.5417 42.0001 21.5417C42.8155 21.5417 43.5109 21.0208 43.7686 20.2917C43.8836 19.9663 44.2407 19.7957 44.5662 19.9107C44.8916 20.0257 45.0622 20.3828 44.9472 20.7083C44.5185 21.9212 43.3618 22.7917 42.0001 22.7917C40.6385 22.7917 39.4818 21.9212 39.0531 20.7083C38.9381 20.3828 39.1087 20.0257 39.4341 19.9107Z"
                                      fill="#1D2977"></path>
                                <circle cx="22" cy="60" r="17" fill="#F7F8FD" fill-opacity="0.64"></circle>
                            </g>
                            <defs>
                                <clipPath id="clip0_34_2948">
                                    <rect width="64" height="64" rx="32" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="shape-header-categories-main"></div>
                </div>
            </section>

            {{-- نمایش خطاهای اعتبارسنجی --}}
            @if($errors->any())
                <div class="alert alert-danger"
                     style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <ul style="margin: 0; padding-right: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="kamand-basic-info">
                <p class="form-input-info">
                    <label for="billing_first_name">نام <span style="color: red;">*</span></label>
                    <input type="text" name="billing_first_name" id="billing_first_name"
                           value="{{ old('billing_first_name', $userData['billing_first_name'] ?? '') }}" required>
                </p>
                <p class="form-input-info">
                    <label for="billing_last_name">نام خانوادگی <span style="color: red;">*</span></label>
                    <input type="text" name="billing_last_name" id="billing_last_name"
                           value="{{ old('billing_last_name', $userData['billing_last_name'] ?? '') }}" required>
                </p>
                <p class="form-input-info">
                    <label for="billing_phone">شماره موبایل <span style="color: red;">*</span></label>
                    <input type="tel" name="billing_phone" id="billing_phone"
                           value="{{ old('billing_phone', $userData['billing_phone'] ?? '') }}" required>
                </p>
                <p class="form-input-info">
                    <label for="billing_email">آدرس ایمیل <span>(اختیاری)</span></label>
                    <input type="email" name="billing_email" id="billing_email"
                           value="{{ old('billing_email', $userData['billing_email'] ?? '') }}">
                </p>
            </div>

            <div class="kamand-address-options">
                <h3>آدرس</h3>

                {{-- آدرس صورتحساب --}}
                <div class="kamand-address-choice">
                    <h4>آدرس صورتحساب</h4>
                    <div class="kamand-address-choice-wrapper">
                        <div class="radio-title">
                            <label>
                                <input type="radio" name="address_choice"
                                       value="billing" {{ old('address_choice', 'billing') == 'billing' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                            </label>
                        </div>
                        <div class="address-fields billing-fields">
                            <p class="form-row form-row-wide">
                                <label for="billing_address_1">آدرس (خیابان، پلاک) <span
                                        style="color: red;">*</span></label>
                                <input type="text" name="billing_address_1" id="billing_address_1"
                                       value="{{ old('billing_address_1') }}"
                                       placeholder="مثال: خیابان آزادی، پلاک ۱۲۳">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="billing_address_2">واحد، پلاک، بلوک (اختیاری)</label>
                                <input type="text" name="billing_address_2" id="billing_address_2"
                                       value="{{ old('billing_address_2') }}" placeholder="مثال: واحد ۳، طبقه ۲">
                            </p>
                            <p class="form-row form-row-first">
                                <label for="billing_city">شهر <span style="color: red;">*</span></label>
                                <input type="text" name="billing_city" id="billing_city"
                                       value="{{ old('billing_city') }}">
                            </p>
                            <p class="form-row form-row-last">
                                <label for="billing_state">استان <span style="color: red;">*</span></label>
                                <input type="text" name="billing_state" id="billing_state"
                                       value="{{ old('billing_state') }}">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="billing_postcode">کد پستی <span style="color: red;">*</span></label>
                                <input type="text" name="billing_postcode" id="billing_postcode"
                                       value="{{ old('billing_postcode') }}">
                            </p>
                        </div>
                    </div>
                </div>

                {{-- آدرس حمل و نقل --}}
                <div class="kamand-address-choice">
                    <h4>آدرس حمل و نقل</h4>
                    <div class="kamand-address-choice-wrapper">
                        <div class="radio-title">
                            <label>
                                <input type="radio" name="address_choice"
                                       value="shipping" {{ old('address_choice') == 'shipping' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                            </label>
                        </div>
                        <div class="address-fields shipping-fields">
                            <p class="form-row form-row-first">
                                <label for="shipping_first_name">نام</label>
                                <input type="text" name="shipping_first_name" id="shipping_first_name"
                                       value="{{ old('shipping_first_name') }}">
                            </p>
                            <p class="form-row form-row-last">
                                <label for="shipping_last_name">نام خانوادگی</label>
                                <input type="text" name="shipping_last_name" id="shipping_last_name"
                                       value="{{ old('shipping_last_name') }}">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="shipping_phone">شماره موبایل</label>
                                <input type="tel" name="shipping_phone" id="shipping_phone"
                                       value="{{ old('shipping_phone') }}">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="shipping_address_1">آدرس (خیابان، پلاک) <span
                                        style="color: red;">*</span></label>
                                <input type="text" name="shipping_address_1" id="shipping_address_1"
                                       value="{{ old('shipping_address_1') }}">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="shipping_address_2">واحد، پلاک، بلوک (اختیاری)</label>
                                <input type="text" name="shipping_address_2" id="shipping_address_2"
                                       value="{{ old('shipping_address_2') }}">
                            </p>
                            <p class="form-row form-row-first">
                                <label for="shipping_city">شهر <span style="color: red;">*</span></label>
                                <input type="text" name="shipping_city" id="shipping_city"
                                       value="{{ old('shipping_city') }}">
                            </p>
                            <p class="form-row form-row-last">
                                <label for="shipping_state">استان <span style="color: red;">*</span></label>
                                <input type="text" name="shipping_state" id="shipping_state"
                                       value="{{ old('shipping_state') }}">
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="shipping_postcode">کد پستی <span style="color: red;">*</span></label>
                                <input type="text" name="shipping_postcode" id="shipping_postcode"
                                       value="{{ old('shipping_postcode') }}">
                            </p>
                        </div>
                    </div>
                </div>

                {{-- آدرس جدید یا دلخواه --}}
                <div class="kamand-address-choice">
                    <h4>ارسال به آدرس دیگر یا جدید</h4>
                    <div class="kamand-address-choice-wrapper">
                        <div class="radio-title">
                            <label>
                                <input type="radio" name="address_choice"
                                       value="custom" {{ old('address_choice') == 'custom' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                            </label>
                        </div>
                        <div class="address-fields custom-fields">
                            <div class="kamand-new-address-form">
                                <p class="form-row form-row-wide">
                                    <label for="new_address">آدرس <span style="color: red;">*</span></label>
                                    <input type="text" name="new_address" id="new_address"
                                           value="{{ old('new_address') }}" placeholder="مثلاً تهران، خیابان آزادی...">
                                </p>
                                <p class="form-row form-row-first">
                                    <label for="new_city">شهر <span style="color: red;">*</span></label>
                                    <input type="text" name="new_city" id="new_city" value="{{ old('new_city') }}">
                                </p>
                                <p class="form-row form-row-last">
                                    <label for="new_postcode">کد پستی <span style="color: red;">*</span></label>
                                    <input type="text" name="new_postcode" id="new_postcode"
                                           value="{{ old('new_postcode') }}">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="recive-date-shipping">
                <h4>تاریخ ارسال <span style="color: red;">*</span></h4>
                <div class="recive-date-shipping-wrapper">
                    @foreach($shippingDates as $index => $date)
                        <div class="recive-date-shipping-item">
                            <label class="recive-date-shipping-item-radio">
                                <input type="radio" name="recive_date_shipping"
                                       value="{{ $date['value'] }}" {{ old('recive_date_shipping', $index === 0 ? $date['value'] : '') == $date['value'] ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                            </label>
                            <div class="recive-date-shipping-item-content">
                                <span>{{ $date['label'] }}</span>
                                <span>{{ $date['year'] ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-woocommerce-checkout-order-review">
            <section class="header-categories-main">
                <div class="title-header-categories-main"><span>BILL</span>
                    <div class="text-header-categories-main"><span><strong>صورتحســاب</strong></span>
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_34_3022)">
                                <circle cx="32" cy="32" r="32" transform="matrix(-1 0 0 1 64 0)"
                                        fill="#FFD701"></circle>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M37.9157 9.04163C37.9557 9.04165 37.9963 9.04166 38.0376 9.04166H45.9625C46.0038 9.04166 46.0444 9.04165 46.0845 9.04163C46.9318 9.04126 47.5149 9.041 48.006 9.21188C48.9334 9.5346 49.6535 10.281 49.9622 11.2213L49.3684 11.4162L49.9622 11.2213C50.1256 11.7189 50.1254 12.3104 50.1251 13.1887C50.1251 13.228 50.1251 13.2679 50.1251 13.3084V24.9785C50.1251 26.1995 48.6859 26.9265 47.738 26.0591C47.6718 25.9985 47.5783 25.9985 47.5121 26.0591L47.1095 26.4275C46.336 27.1353 45.1641 27.1353 44.3906 26.4275C44.0948 26.1568 43.6553 26.1568 43.3595 26.4275C42.586 27.1353 41.4141 27.1353 40.6406 26.4275C40.3448 26.1568 39.9053 26.1568 39.6095 26.4275C38.836 27.1353 37.6641 27.1353 36.8906 26.4275L36.488 26.0591C36.4218 25.9985 36.3283 25.9985 36.2621 26.0591C35.3142 26.9265 33.8751 26.1995 33.8751 24.9785V13.3084C33.8751 13.2679 33.875 13.228 33.875 13.1887C33.8747 12.3104 33.8745 11.7189 34.0379 11.2213C34.3466 10.281 35.0667 9.5346 35.9942 9.21188C36.4853 9.041 37.0684 9.04126 37.9157 9.04163ZM38.0376 10.2917C37.02 10.2917 36.6695 10.3004 36.4049 10.3925C35.8555 10.5837 35.416 11.031 35.2255 11.6112C35.1329 11.8931 35.1251 12.2649 35.1251 13.3084V24.9785C35.1251 25.0777 35.175 25.1384 35.2376 25.1673C35.2703 25.1824 35.3022 25.1863 35.3288 25.1828C35.3522 25.1796 35.3826 25.1695 35.4182 25.1369C35.9621 24.6392 36.788 24.6392 37.3319 25.1369L37.7345 25.5053C38.0303 25.776 38.4698 25.776 38.7656 25.5053C39.5391 24.7975 40.711 24.7975 41.4845 25.5053C41.7803 25.776 42.2198 25.776 42.5156 25.5053C43.2891 24.7975 44.461 24.7975 45.2345 25.5053C45.5303 25.776 45.9698 25.776 46.2656 25.5053L46.6682 25.1369C47.2121 24.6392 48.038 24.6392 48.5819 25.1369C48.6175 25.1695 48.6479 25.1796 48.6713 25.1828C48.6979 25.1863 48.7298 25.1824 48.7625 25.1673C48.8251 25.1384 48.8751 25.0777 48.8751 24.9785V13.3084C48.8751 12.2649 48.8672 11.8931 48.7746 11.6112C48.5841 11.031 48.1447 10.5837 47.5952 10.3925C47.3306 10.3004 46.9801 10.2917 45.9625 10.2917H38.0376ZM37.2084 14.25C37.2084 13.9048 37.4882 13.625 37.8334 13.625H38.2501C38.5952 13.625 38.8751 13.9048 38.8751 14.25C38.8751 14.5952 38.5952 14.875 38.2501 14.875H37.8334C37.4882 14.875 37.2084 14.5952 37.2084 14.25ZM40.1251 14.25C40.1251 13.9048 40.4049 13.625 40.7501 13.625H46.1667C46.5119 13.625 46.7917 13.9048 46.7917 14.25C46.7917 14.5952 46.5119 14.875 46.1667 14.875H40.7501C40.4049 14.875 40.1251 14.5952 40.1251 14.25ZM37.2084 17.1667C37.2084 16.8215 37.4882 16.5417 37.8334 16.5417H38.2501C38.5952 16.5417 38.8751 16.8215 38.8751 17.1667C38.8751 17.5118 38.5952 17.7917 38.2501 17.7917H37.8334C37.4882 17.7917 37.2084 17.5118 37.2084 17.1667ZM40.1251 17.1667C40.1251 16.8215 40.4049 16.5417 40.7501 16.5417H46.1667C46.5119 16.5417 46.7917 16.8215 46.7917 17.1667C46.7917 17.5118 46.5119 17.7917 46.1667 17.7917H40.7501C40.4049 17.7917 40.1251 17.5118 40.1251 17.1667ZM37.2084 20.0833C37.2084 19.7382 37.4882 19.4583 37.8334 19.4583H38.2501C38.5952 19.4583 38.8751 19.7382 38.8751 20.0833C38.8751 20.4285 38.5952 20.7083 38.2501 20.7083H37.8334C37.4882 20.7083 37.2084 20.4285 37.2084 20.0833ZM40.1251 20.0833C40.1251 19.7382 40.4049 19.4583 40.7501 19.4583H46.1667C46.5119 19.4583 46.7917 19.7382 46.7917 20.0833C46.7917 20.4285 46.5119 20.7083 46.1667 20.7083H40.7501C40.4049 20.7083 40.1251 20.4285 40.1251 20.0833Z"
                                      fill="#1D2977"></path>
                                <circle cx="22" cy="60" r="17" fill="#F7F8FD" fill-opacity="0.64"></circle>
                            </g>
                            <defs>
                                <clipPath id="clip0_34_3022">
                                    <rect width="64" height="64" rx="32" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="shape-header-categories-main"></div>
                </div>
            </section>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <table class="shop_table woocommerce-checkout-review-order-table">
                    <thead>
                    <tr>
                        <th class="product-name">محصول</th>
                        <th class="product-total">جمع جزء</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr class="cart_item">
                            <td class="product-name">
                                {{ $item->product->title ?? 'محصول نامشخص' }}
                                @if($item->color)
                                    <br><small>رنگ: {{ $item->color->name ?? '' }}</small>
                                @endif
                                &nbsp;
                                <strong class="product-quantity">×&nbsp;{{ $item->quantity }}</strong>
                            </td>
                            <td class="product-total">
                                <span class="woocommerce-Price-amount amount">
                                    {{ number_format($item->price * $item->quantity) }}&nbsp;تومان
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="cart-subtotal">
                        <th>جمع جزء</th>
                        <td>{{ number_format($subtotal) }}&nbsp;تومان</td>
                    </tr>
                    <tr class="woocommerce-shipping-totals shipping">
                        <th>حمل و نقل</th>
                        <td>
                            {{ number_format($shippingCost) }}&nbsp;تومان
                            <input type="hidden" name="shipping_cost" value="{{ $shippingCost }}">
                        </td>
                    </tr>
                    <tr class="order-total">
                        <th>مجموع</th>
                        <td><strong>{{ number_format($total) }}&nbsp;تومان</strong></td>
                    </tr>
                    </tfoot>
                </table>

                <div id="payment" class="woocommerce-checkout-payment">
                    <h4 style="margin-bottom: 15px;">روش پرداخت <span style="color: red;">*</span></h4>

                    <ul class="wc_payment_methods payment_methods methods d-grid justify-content-center align-items-start">
                        @foreach($payment_gateways as $gateway)
                            <li class="wc_payment_method payment_method_{{ $gateway->name }}"
                                style="margin-bottom: 10px;">
                                <input
                                    id="payment_method_{{ $gateway->name }}"
                                    type="radio"
                                    class="input-radio"
                                    name="payment_method"
                                    value="{{ $gateway->name }}"
                                    {{ old('payment_method') == $gateway->name ? 'checked' : ($loop->first ? 'checked' : '') }}
                                >
                                <label for="payment_method_{{ $gateway->name }}"
                                       style="margin-right: 8px; font-weight: 500;">
                                    {{ $gateway->title }}
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    {{-- نمایش خطای payment_method --}}
                    @error('payment_method')
                    <div style="color: #721c24; background: #f8d7da; padding: 8px; border-radius: 4px; margin: 10px 0;">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-row place-order" style="margin-top: 30px;">
                        <button type="submit" class="woocommerce-order-button-html" id="place_order">
                            <span>ادامه و پرداخت</span>
                            <svg width="40" height="40" viewBox="0 0 40 40">
                                <path
                                    d="M23.4214 13.4056C23.2646 13.5623 23.0502 13.6613 22.8027 13.6613H13.6621V22.8019C13.6621 23.2803 13.2662 23.6763 12.7877 23.6763C12.3092 23.6763 11.9132 23.2803 11.9132 22.8019V12.7869C11.9132 12.3084 12.3092 11.9124 12.7877 11.9124H22.8027C23.2811 11.9124 23.6771 12.3084 23.6771 12.7869C23.6854 13.0261 23.5781 13.2489 23.4214 13.4056Z"
                                    fill="white"/>
                                <path
                                    d="M27.4297 27.4298C27.0914 27.7681 26.5304 27.7681 26.1922 27.4298L12.3082 13.5458C11.9699 13.2075 11.9699 12.6466 12.3082 12.3083C12.6464 11.9701 13.2074 11.9701 13.5456 12.3083L27.4297 26.1924C27.7679 26.5306 27.7679 27.0916 27.4297 27.4298Z"
                                    fill="white"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // دریافت تمام رادیو باتن‌های انتخاب آدرس
            const addressRadios = document.querySelectorAll('input[name="address_choice"]');
            const checkoutForm = document.getElementById('checkout-form');

            // تابع برای فعال/غیرفعال کردن فیلدهای هر بخش
            function setFieldsEnabled(container, isEnabled) {
                if (!container) return;
                const inputs = container.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    if (isEnabled) {
                        input.removeAttribute('disabled');
                        input.style.backgroundColor = '#fff';
                        input.style.opacity = '1';
                    } else {
                        input.setAttribute('disabled', 'disabled');
                        input.style.backgroundColor = '#f5f5f5';
                        input.style.opacity = '0.6';
                    }
                });
            }

            // تابع برای تغییر وضعیت فیلدها بر اساس انتخاب
            function updateFieldsStatus(selectedValue) {
                const billingFields = document.querySelector('.billing-fields');
                const shippingFields = document.querySelector('.shipping-fields');
                const customFields = document.querySelector('.custom-fields');

                // غیرفعال کردن همه فیلدها ابتدا
                setFieldsEnabled(billingFields, false);
                setFieldsEnabled(shippingFields, false);
                setFieldsEnabled(customFields, false);

                // فعال کردن فقط فیلدهای بخش انتخاب شده
                if (selectedValue === 'billing') {
                    setFieldsEnabled(billingFields, true);
                } else if (selectedValue === 'shipping') {
                    setFieldsEnabled(shippingFields, true);
                    copyBillingToShipping();
                } else if (selectedValue === 'custom') {
                    setFieldsEnabled(customFields, true);
                }
            }

            // تابع برای کپی اطلاعات از billing به shipping
            function copyBillingToShipping() {
                const billingAddress1 = document.querySelector('#billing_address_1');

                if (billingAddress1 && billingAddress1.value) {
                    if (document.querySelector('#shipping_address_1'))
                        document.querySelector('#shipping_address_1').value = billingAddress1.value;
                    if (document.querySelector('#shipping_city'))
                        document.querySelector('#shipping_city').value = document.querySelector('#billing_city')?.value || '';
                    if (document.querySelector('#shipping_state'))
                        document.querySelector('#shipping_state').value = document.querySelector('#billing_state')?.value || '';
                    if (document.querySelector('#shipping_postcode'))
                        document.querySelector('#shipping_postcode').value = document.querySelector('#billing_postcode')?.value || '';
                    if (document.querySelector('#shipping_first_name'))
                        document.querySelector('#shipping_first_name').value = document.querySelector('#billing_first_name')?.value || '';
                    if (document.querySelector('#shipping_last_name'))
                        document.querySelector('#shipping_last_name').value = document.querySelector('#billing_last_name')?.value || '';
                    if (document.querySelector('#shipping_phone'))
                        document.querySelector('#shipping_phone').value = document.querySelector('#billing_phone')?.value || '';
                }
            }

            // اضافه کردن event listener به رادیو باتن‌ها
            addressRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    updateFieldsStatus(this.value);
                });
            });

            // اجرای اولیه برای تنظیم وضعیت اولیه
            const checkedRadio = document.querySelector('input[name="address_choice"]:checked');
            if (checkedRadio) {
                updateFieldsStatus(checkedRadio.value);
            } else {
                const firstRadio = document.querySelector('input[name="address_choice"]');
                if (firstRadio) {
                    firstRadio.checked = true;
                    updateFieldsStatus('billing');
                }
            }

            // اعتبارسنجی سمت کلاینت قبل از submit
            checkoutForm.addEventListener('submit', function (e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

                if (!paymentMethod) {
                    e.preventDefault();
                    alert('لطفاً روش پرداخت را انتخاب کنید');
                    return false;
                }

                // بررسی انتخاب آدرس
                const addressChoice = document.querySelector('input[name="address_choice"]:checked');
                if (!addressChoice) {
                    e.preventDefault();
                    alert('لطفاً نوع آدرس را انتخاب کنید');
                    return false;
                }

                // نمایش لودینگ
                const submitBtn = document.getElementById('place_order');
                submitBtn.innerHTML = '<span>لطفاً صبر کنید...</span>';
                submitBtn.disabled = true;
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .address-fields input:disabled,
        .address-fields textarea:disabled,
        .address-fields select:disabled {
            background-color: #f5f5f5 !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            border-color: #ddd !important;
        }

        .address-fields input:not(:disabled),
        .address-fields textarea:not(:disabled),
        .address-fields select:not(:disabled) {
            background-color: #fff !important;
            opacity: 1 !important;
            border-color: #1D2977 !important;
        }

        .wc_payment_method {
            list-style: none;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .wc_payment_method:hover {
            border-color: #1D2977;
            background: #f9f9f9;
        }

        .wc_payment_method input[type="radio"] {
            margin-left: 10px;
        }

        .woocommerce-order-button-html {
            background: #1D2977;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .woocommerce-order-button-html:hover {
            background: #FFD701;
            color: #1D2977;
        }

        .woocommerce-order-button-html:hover svg path {
            fill: #1D2977;
        }

        .woocommerce-order-button-html:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }

        .recive-date-shipping-item {
            display: inline-block;
            margin: 10px;
        }

        .recive-date-shipping-item-radio {
            margin-left: 5px;
        }

        .form-input-info {
            margin-bottom: 15px;
        }

        .form-input-info label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-input-info input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        .form-row label {
            display: block;
            margin-bottom: 5px;
        }

        .form-row input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
@endpush
