@extends('home.layouts.master')
@section('content')
    <div class="bread-crumb py-4">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="my-lg-0 my-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="font-14 text-muted-two">خانه</a></li>
                    <li class="breadcrumb-item"><a href="#" class="font-14 text-muted-two">فروشگاه</a></li>
                    <li class="breadcrumb-item"><a href="#" class="font-14 text-muted-two">گوشی هوشمند</a></li>
                    <li class="breadcrumb-item active main-color-one-color font-14 fw-bold" aria-current="page">گوشی
                        شیائومی
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="product-meta py-20">
        <div class="container-fluid position-relative">
            <div class="content-box">
                <div class="container-fluid">
                    <div class="row gy-3">
                        <div class="col-lg-4">
                            <div class="pro_gallery">
                                <div class="icon-product-box">
                                    <div class="icon-product-box-item" data-bs-toggle="modal"
                                         data-bs-target="#shareModal" data-bs-placement="right"
                                         aria-label="اشتراک گذاری" data-bs-original-title="اشتراک گذاری">
                                        <i class="bi bi-share"></i>
                                    </div>
                                    <div class="icon-product-box-item" data-bs-toggle="tooltip"
                                         data-bs-placement="right" data-bs-title="افزودن به علاقه مندی">
                                        <i class="bi bi-heart"></i>
                                    </div>
                                    <div class="icon-product-box-item" data-bs-toggle="tooltip"
                                         data-bs-placement="right" data-bs-title="مقایسه محصول">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </div>
                                    <div class="icon-product-box-item" data-bs-toggle="modal"
                                         data-bs-target="#chartModal" data-bs-placement="right"
                                         aria-label="نمودار تغییر قیمت" data-bs-original-title="نمودار تغییر قیمت">
                                        <i class="bi bi-bar-chart"></i>
                                    </div>
                                </div>
                                <div class="pro-gallery-parent">
                                    <div
                                            class="swiper product-gallery swiper-initialized swiper-horizontal swiper-rtl swiper-backface-hidden">
                                        <div class="swiper-wrapper" title="برای بزرگنمایی تصویر دابل کلیک کنید"
                                             id="swiper-wrapper-f202ed7b5a75a78a" aria-live="polite">
                                            @foreach($product->galleries as $gallery)
                                                <div class="swiper-slide swiper-slide-active" role="group"
                                                     aria-label="1 / 6" style="width: 428px; margin-left: 10px;">
                                                    <div class="swiper-zoom-container">
                                                        <img class="img-fluid"
                                                             src="{{ asset('/storage/'.$gallery->image) }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next d-none d-lg-flex" tabindex="0" role="button"
                                             aria-label="Next slide" aria-controls="swiper-wrapper-f202ed7b5a75a78a"
                                             aria-disabled="false"></div>
                                        <div class="swiper-button-prev d-none d-lg-flex swiper-button-disabled"
                                             tabindex="-1" role="button" aria-label="Previous slide"
                                             aria-controls="swiper-wrapper-f202ed7b5a75a78a" aria-disabled="true"></div>
                                        <div
                                                class="swiper-pagination d-none d-lg-block swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
                                            <span class="swiper-pagination-bullet swiper-pagination-bullet-active"
                                                  tabindex="0" role="button" aria-label="Go to slide 1"
                                                  aria-current="true"></span><span class="swiper-pagination-bullet"
                                                                                   tabindex="0" role="button"
                                                                                   aria-label="Go to slide 2"></span><span
                                                    class="swiper-pagination-bullet" tabindex="0" role="button"
                                                    aria-label="Go to slide 3"></span><span
                                                    class="swiper-pagination-bullet"
                                                    tabindex="0" role="button"
                                                    aria-label="Go to slide 4"></span><span
                                                    class="swiper-pagination-bullet" tabindex="0" role="button"
                                                    aria-label="Go to slide 5"></span><span
                                                    class="swiper-pagination-bullet"
                                                    tabindex="0" role="button"
                                                    aria-label="Go to slide 6"></span>
                                        </div>
                                        <span class="swiper-notification" aria-live="assertive"
                                              aria-atomic="true"></span><span class="swiper-notification"
                                                                              aria-live="assertive"
                                                                              aria-atomic="true"></span><span
                                                class="swiper-notification" aria-live="assertive"
                                                aria-atomic="true"></span>
                                    </div>
                                </div>
                                <div thumbsslider=""
                                     class="swiper product-gallery-thumb swiper-initialized swiper-horizontal swiper-free-mode swiper-rtl swiper-watch-progress swiper-backface-hidden swiper-thumbs">
                                    <div class="swiper-wrapper" id="swiper-wrapper-fcc75b53fc10d4125" aria-live="polite"
                                         style="transform: translate3d(0px, 0px, 0px);">
                                        @foreach($product->galleries as $gallery)
                                            <div
                                                    class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-thumb-active swiper-slide-fully-visible"
                                                    role="group" aria-label="1 / 6"
                                                    style="width: 146px; margin-left: 10px;">
                                                <img class="img-fluid" src="{{ asset('/storage/'.$gallery->image) }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="swiper-notification" aria-live="assertive"
                                          aria-atomic="true"></span><span class="swiper-notification"
                                                                          aria-live="assertive"
                                                                          aria-atomic="true"></span><span
                                            class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-8">
                            @if($product->productVariant->first()?->discount_percent)
                                <div class="discount">{{$product->productVariant->first()?->discount_percent}}%</div>
                            @endif
                            <div class="product-mete-title bottom-border">
                                <h3 class="title-font h4">{{$product->title}}</h3>
                                <p class="mb-0 mt-3">{{$product->etitle}}</p>
                            </div>
                            <div class="product-meta-overal my-3 bottom-border">
                                <div class="row gy-3 align-items-center">
                                    <div class="col-md-4">
                                        @if(($product->productVariant->sum('stock')) > 0)
                                            <div class="label-site rounded-pill label-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                موجود در انبار
                                            </div>
                                        @else
                                            <div class="label-site rounded-pill label-danger">
                                                <i class="bi bi-check-circle me-1"></i>
                                                ناموجود در انبار
                                            </div>
                                        @endif

                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted-two me-2">دسته بندی</span>
                                            <div class="label-site rounded-pill">
                                                {{$product->category->title}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted-two me-2">کد محصول</span>
                                        <span>{{$product->variants->first()->sku}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-meta-feature bottom-border">
                                <div class="row gy-3">
                                    <div class="col-lg-8">
                                        <div class="product-meta-feature-items">
                                            <div class="excerpt_single_product">
                                                {!! \Illuminate\Support\Str::words(strip_tags($product->description), 50, '...') !!}
                                            </div>

                                            @if($product->properties->count())
                                                <h5 class="title font-16 mb-2">ویژگی های کالا</h5>
                                                <div class="custom-feature-boxes">
                                                    @foreach($product->properties as $property)
                                                        <div class="feature-box">
                                                            <strong>{{ $property->propertyGroup->title }}:</strong>
                                                            {{ $property->title }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="product-meta-rating text-start">
                                            <div class="label-site label-waring rounded-pill w-100">
                                                <span class="product-meta-rating-comment-count me-1">0</span>
                                                <span class="product-meta-rating-comment-count-text me-3">نظر</span>
                                                <span class="product-meta-rating-rating-count me-1">0</span>
                                                <span class="product-meta-rating-rating-count-text"><i
                                                            class="bi bi-star-fill"></i></span>
                                            </div>
                                        </div>
                                        <div class="product-meta-rating mt-2 text-start">
                                            <div class="label-site label-success rounded-pill w-100">
                                                آماده ارسال
                                                <i class="bi bi-truck ms-2"></i>
                                            </div>
                                        </div>
                                        <div class="product-meta-rating mt-2 text-start ">
                                            <div id="product-message-content"
                                                 class="label-site label-danger rounded-pill w-100">
                                                👀 +1446 بازدید در ۲۴ ساعت اخیر
                                            </div>
                                            <script>
                                                window.productMessages = [
                                                    "🔥 تنها {{ $product->variants->sum('stock') }} عدد در انبار باقی مانده",
                                                    "👀 {{ $product->viewed }} بازدید در ۲۴ ساعت اخیر",
                                                ];
                                            </script>

                                        </div>
                                        @if($product->variants->whereNotNull('special_expiration')->count())
                                            <div class="sale-products-timer-counter mt-2 d-none" id="discount-timer"
                                                 data-expire="{{ $product->variants->first()?->special_expiration }}">
                                                <div class="sale-products-wrapper">

                                                    <div class="sale-products-time">
                                                        <span class="days">00</span>
                                                        <span>روز</span>
                                                    </div>

                                                    <div class="sale-products-line"></div>

                                                    <div class="sale-products-time">
                                                        <span class="hours">00</span>
                                                        <span>ساعت</span>
                                                    </div>

                                                    <div class="sale-products-line"></div>

                                                    <div class="sale-products-time">
                                                        <span class="minutes">00</span>
                                                        <span>دقیقه</span>
                                                    </div>

                                                    <div class="sale-products-line"></div>

                                                    <div class="sale-products-time">
                                                        <span class="seconds">00</span>
                                                        <span>ثانیه</span>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="product-meta-color">
                                <div class="product-meta-color">
                                    <div class="d-flex align-items-center col-sm-12 justify-content-between">
                                        <div class="">
                                            <h5 class="font-16">
                                                انتخاب رنگ کالا
                                            </h5>
                                            <div class="product-meta-color-items">
                                                @foreach($product->variants as $variant)
                                                    <input
                                                        type="radio"
                                                        class="btn-check variant-radio"
                                                        name="variant"
                                                        id="variant{{ $variant->id }}"
                                                        value="{{ $variant->id }}"
                                                        data-main-price="{{ $variant->main_price }}"
                                                        data-final-price="{{ $variant->final_price }}"
                                                        data-discount="{{ $variant->discount_percent }}"
                                                        data-expiration="{{ $variant->special_expiration }}"
                                                        data-stock="{{ $variant->stock }}"
                                                        {{ $loop->first ? 'checked' : '' }}
                                                    >

                                                    <label class="btn" for="variant{{ $variant->id }}">
                                                        <span style="background-color:#{{ $variant->color->code }}"></span>
                                                        {{ $variant->color->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-meta-action mt-4 gap-sm-3 justify-content-sm-center">
                                        <div class="fee d-flex align-items-center col-sm-12 justify-content-start flex-xs-column">
                                            <div class="quantity me-4">
                                                <button class="plus" type="button">+</button>
                                                <input type="number" id="quantity" class="input-text qty text"
                                                       name="quantity" value="1" aria-label="تعداد محصول" size="4" min="1"
                                                       step="1" placeholder="" inputmode="numeric" autocomplete="off">
                                                <button class="minus" type="button">-</button>
                                            </div>

                                            <div class="d-flex align-items-center flex-sm-colum flex-sm-wrap align-content-sm-center justify-content-sm-center py-4">
                                                <p id="old-price" class="mb-0 old-price text-decoration-line-through me-3 {{ !$product->variants->first()?->discount_percent ? 'd-none' : '' }}">
                                                    {{ number_format($product->variants->first()?->main_price) }}
                                                </p>

                                                <h6 id="new-price" class="font-24 main-color-one-color me-3">
                                                    {{ number_format($product->variants->first()?->final_price ?? $product->variants->first()?->main_price) }}
                                                </h6>

                                                {{-- دکمه افزودن به سبد خرید با جاوااسکریپت --}}
                                                <button type="button" id="addToCartBtn" class="btn product-meta-add-to-cart-btn main-color-one-bg rounded-pill">
                                                    افزودن به سبد خرید
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    // متغیر برای ذخیره واریانت انتخاب شده
                                    let selectedVariant = document.querySelector('input[name="variant"]:checked').value;
                                    let maxStock = parseInt(document.querySelector('input[name="variant"]:checked').getAttribute('data-stock') || 0);

                                    // بروزرسانی قیمت و موجودی هنگام تغییر رنگ
                                    document.querySelectorAll('input[name="variant"]').forEach(radio => {
                                        radio.addEventListener('change', function() {
                                            selectedVariant = this.value;
                                            let mainPrice = this.getAttribute('data-main-price');
                                            let finalPrice = this.getAttribute('data-final-price');
                                            let discount = this.getAttribute('data-discount');
                                            let stock = parseInt(this.getAttribute('data-stock') || 0);

                                            // بروزرسانی قیمت
                                            let oldPriceElement = document.getElementById('old-price');
                                            let newPriceElement = document.getElementById('new-price');

                                            if (discount && discount > 0) {
                                                oldPriceElement.classList.remove('d-none');
                                                oldPriceElement.innerText = new Intl.NumberFormat('fa-IR').format(mainPrice);
                                                newPriceElement.innerText = new Intl.NumberFormat('fa-IR').format(finalPrice);
                                            } else {
                                                oldPriceElement.classList.add('d-none');
                                                newPriceElement.innerText = new Intl.NumberFormat('fa-IR').format(mainPrice);
                                            }

                                            // بروزرسانی max مقدار quantity
                                            let quantityInput = document.getElementById('quantity');
                                            quantityInput.max = stock;
                                            maxStock = stock;

                                            // اگر مقدار فعلی بیشتر از موجودی بود، تنظیم شود
                                            if (parseInt(quantityInput.value) > stock) {
                                                quantityInput.value = stock;
                                            }
                                        });
                                    });

                                    // مدیریت دکمه های + و -
                                    document.querySelector('.plus').addEventListener('click', function() {
                                        let quantityInput = document.getElementById('quantity');
                                        let newValue = parseInt(quantityInput.value) + 1;
                                        if (newValue <= maxStock) {
                                            quantityInput.value = newValue;
                                        }
                                    });

                                    document.querySelector('.minus').addEventListener('click', function() {
                                        let quantityInput = document.getElementById('quantity');
                                        let newValue = parseInt(quantityInput.value) - 1;
                                        if (newValue >= 1) {
                                            quantityInput.value = newValue;
                                        }
                                    });

                                    // دکمه افزودن به سبد خرید
                                    document.getElementById('addToCartBtn').addEventListener('click', function() {
                                        let productId = {{ $product->id }};
                                        let variantId = selectedVariant;
                                        let quantity = document.getElementById('quantity').value;

                                        // ریدایرکت به مسیر افزودن به سبد خرید با واریانت انتخاب شده
                                        window.location.href = "{{ route('user.add_to_cart', ['product' => $product->id, 'variant' => '']) }}/" + variantId + "?quantity=" + quantity;
                                    });
                                </script>
                                <!--                        <div class="product-meta-add-to-cart mt-4">-->
                                <!--                           -->
                                <!--                        </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Dottedsquare-product d-lg-flex d-none"></div>
            </div>
        </div>


        <!-- end product meta -->

        <!-- start product desc -->

        <div class="product-desc py-20">
            <div class="container-fluid">
                <div class="product-desc-tab">
                    <ul class="nav" id="productTab" role="tablist">
                        <li class="nav-item">
                            <button class="active waves-effect waves-light" id="productDescLess" data-bs-toggle="tab"
                                    data-bs-target="#productDescLess-pane" role="button" type="button"
                                    aria-selected="true">
                                توضیحات کالا
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class=" waves-effect waves-light" id="productTable" data-bs-toggle="tab"
                                    data-bs-target="#productTable-pane" role="button" type="button"
                                    aria-selected="false">
                                توضیحات تکمیلی
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class=" waves-effect waves-light" id="productComment" data-bs-toggle="tab"
                                    data-bs-target="#productComment-pane" role="button" type="button"
                                    aria-selected="false">
                                نظرات
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="content-box">
                    <div class="container-fluid">
                        <div class="product-descs" id="prodesc">
                            <div class="product-desc">
                                <div class="product-desc-tab-content">
                                    <div class="tab-content" id="productTabContent">
                                        <div class="tab-pane fade show active product-desc-less-contents"
                                             id="productDescLess-pane">
                                            <div class="product-desc-content">
                                                <input type="checkbox" class="read-more-state" id="readMore3">
                                                <!-- والد بیشتر ، کمتر ، تمام متن توضیحات باید داخل این تگ قرار بگیرند -->
                                                <div class="read-more-wrap">
                                                    <h6 class="font-22 mb-2 title-font">معرفی محصول</h6>

                                                    {!! \Illuminate\Support\Str::words(strip_tags($product->description), 50, '...') !!}

                                                    <div class="read-more-target">
                                                        {!! $product->description !!}
                                                    </div>
                                                </div>
                                                <!-- پایان والد بیشتر کمتر -->
                                                <label for="readMore3" class="read-more-trigger"></label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="productTable-pane">
                                            <div class="tab-pane fade active show" role="tabpanel"
                                                 aria-labelledby="#productTable">
                                                <h6 class="font-26 mb-2 title-font">مشخصات فنی</h6>
                                                @if($product->properties->count())
                                                    <div class="box_list mt-4">

                                                        <p class="title">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-caret-left-fill"
                                                                 viewBox="0 0 16 16">
                                                                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
                                                            </svg>
                                                            مشخصات کلی
                                                        </p>

                                                        <div>
                                                            <ul class="param_list list-inline">

                                                                @foreach($product->properties as $property)
                                                                    <li class="list-inline-item col-md-3 pe-md-1 pe-md-3 p-0 m-0">
                                                                        <div class="box_params_list">
                                                                            <p class="block border_right_custom1">
                                                                                {{ $property->propertyGroup->title }}
                                                                            </p>
                                                                        </div>
                                                                    </li>

                                                                    <li class="list-inline-item col-md-8 p-0 m-0">
                                                                        <div class="box_params_list">
                                                                            <p class="block border_right_custom2">
                                                                                {{ $property->title }}
                                                                            </p>
                                                                        </div>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane fade product-comment-content" id="productComment-pane">

                                            <div class="comment-form">
                                                <h6 class="font-26 mb-2 title-font">نظرت در مورد این محصول چیه؟</h6>
                                                <p class="font-14 text-muted mt-2">برای ثبت نظر، از طریق دکمه افزودن
                                                    دیدگاه جدید
                                                    نمایید. اگر این محصول را قبلا خریده باشید، نظر شما به عنوان خریدار
                                                    ثبت خواهد
                                                    شد.</p>
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="comment-item mb-3">
                                                                    <input type="email" class="form-control"
                                                                           id="floatingInputEmail">
                                                                    <label for="floatingInputEmail"
                                                                           class="form-label label-float">ایمیل خود را
                                                                        وارد
                                                                        کنید</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="comment-item mb-3">
                                                                    <input type="text" class="form-control"
                                                                           id="floatingInputName">
                                                                    <label for="floatingInputName"
                                                                           class="form-label label-float">نام خود را
                                                                        وارد
                                                                        کنید</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div
                                                                        class="comment-item d-flex align-items-center mb-3">
                                                                    <input type="checkbox" class="form-check-input"
                                                                           id="rememberComment">
                                                                    <label for="rememberComment"
                                                                           class="form-check-label d-block">
                                                                        ذخیره
                                                                        نام، ایمیل و وبسایت من در مرورگر برای زمانی که
                                                                        دوباره
                                                                        دیدگاهی می‌نویسم.
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group mt-3">
                                                                    <label for="commentRating" class="">امتیاز
                                                                        شما</label>
                                                                    <fieldset id="commentRating" class="rating">
                                                                        <input type="radio" id="star5" name="rating"
                                                                               value="5" required="">
                                                                        <label for="star5">5 stars</label>
                                                                        <input type="radio" id="star4" name="rating"
                                                                               value="4" required="">
                                                                        <label for="star4">4 stars</label>
                                                                        <input type="radio" id="star3" name="rating"
                                                                               value="3" required="">
                                                                        <label for="star3">3 stars</label>
                                                                        <input type="radio" id="star2" name="rating"
                                                                               value="2" required="">
                                                                        <label for="star2">2 stars</label>
                                                                        <input type="radio" id="star1" name="rating"
                                                                               value="1" required="">
                                                                        <label for="star1">1 star</label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="comment-item my-3">
                                                                    <textarea class="form-control"
                                                                              id="floatingTextarea2"
                                                                              style="height: 150px"></textarea>
                                                                    <label for="floatingTextarea2"
                                                                           class="form-label label-float">متن
                                                                        نظر!</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-3">
                                                                    <label for="tags-pos" class="text-success mb-2">نقاط
                                                                        قوت</label>
                                                                    <tags
                                                                            class="tagify commentTags tag-pos form-control tagify--noTags tagify--empty"
                                                                            tabindex="-1">
                                                                        <span contenteditable="" tabindex="0"
                                                                              data-placeholder="با کلید اینتر اضافه کنید"
                                                                              aria-placeholder="با کلید اینتر اضافه کنید"
                                                                              class="tagify__input" role="textbox"
                                                                              aria-autocomplete="both"
                                                                              aria-multiline="false"></span>
                                                                        ​
                                                                    </tags>
                                                                    <input name="tags-pos" id="tags-pos"
                                                                           class="commentTags tag-pos form-control"
                                                                           placeholder="با کلید اینتر اضافه کنید"
                                                                           tabindex="-1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-3">
                                                                    <label for="tags-neg" class="text-danger mb-2">نقاط
                                                                        ضعف</label>
                                                                    <tags
                                                                            class="tagify commentTags tag-neg form-control tagify--noTags tagify--empty"
                                                                            tabindex="-1">
                                                                        <span contenteditable="" tabindex="0"
                                                                              data-placeholder="با کلید اینتر اضافه کنید"
                                                                              aria-placeholder="با کلید اینتر اضافه کنید"
                                                                              class="tagify__input" role="textbox"
                                                                              aria-autocomplete="both"
                                                                              aria-multiline="false"></span>
                                                                        ​
                                                                    </tags>
                                                                    <input name="tags-neg" id="tags-neg"
                                                                           class="commentTags tag-neg form-control"
                                                                           placeholder="با کلید اینتر اضافه کنید"
                                                                           tabindex="-1">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <a href=""
                                                                   class="btn btn-comment border-0 main-color-one-bg my-3 mx-auto btn-lg waves-effect waves-light">ثبت
                                                                    نظر</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <tbody>
                                            @foreach($comments as $comment)
                                                {{-- اینجا قالب کامنت تکی شما قرار می‌گیرد --}}
                                                <div class="comment mb-4">
                                                    <div class="title">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-10">
                                                                <div class="d-flex align-items-center">
                                                                    {{-- فرض می‌کنیم تصویر پیش‌فرض داریم، در غیراینصورت باید برای هر کاربر تصویر خاصی در نظر گرفت --}}
                                                                    <div class="avatar p-2 bg-white shadow-box rounded-circle">
                                                                        <img src="{{ asset('storage/users/'.$comment->user->image) }}" alt="" class="img-fluid rounded-circle">
                                                                    </div>
                                                                    <div class="d-flex flex-wrap align-items-center ms-2">
                                                                        {{-- نمایش نام کاربر --}}
                                                                        <h6 class="text-muted font-14">{{ $comment->user->name ?? 'کاربر ناشناس' }}</h6>
                                                                        {{-- نمایش تاریخ --}}
                                                                        <h6 class="text-muted font-14 ms-2">{{ verta($comment->created_at)->format('j F Y') }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                {{-- ستاره‌ها را بر اساس امتیاز کامنت اگر دارید، اینجا نمایش دهید --}}
                                                                {{-- فعلا چون در دیتابیس نداریم، موقتاً ستاره‌های کامل را نمایش می‌دهیم --}}
                                                                <div class="d-flex star justify-content-end">
                                                                    <i class="bi bi-star"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="desc py-3">
                                                        <p class="font-14 text-muted">
                                                            {{-- نمایش متن اصلی کامنت --}}
                                                            {{ $comment->body }}
                                                        </p>
                                                    </div>
                                                    <div class="foot">
                                                        <div class="row align-items-center">
                                                            {{-- این قسمت نقاط قوت و ضعف را باید از دیتابیس بیاورید --}}
                                                            {{-- اگر در مدل کامنت فیلدی برای این موارد ندارید، باید اضافه کنید --}}
                                                            <div class="col-md-8">
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="comment-reply">
                                                                    {{-- دکمه پاسخ به کامنت --}}
                                                                    <a href="" class="span-primary px-4">پاسخ</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- پایان قالب کامنت تکی --}}
                                            @endforeach
                                            </tbody>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end product desc -->


        <!-- start product boxs -->
        @if($related_products->isNotEmpty())
            <div class="col-sm-12">
                <section class="sale-products container">
                    <div class="sale-products-header">
                        <svg width="72" height="85" viewBox="0 0 72 85" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M23.6364 30.8462C21.0256 30.8462 18.9091 28.8383 18.9091 26.3615C18.9091 23.8848 21.0256 21.8769 23.6364 21.8769C26.2472 21.8769 28.3636 23.8848 28.3636 26.3615C28.3636 28.8383 26.2472 30.8462 23.6364 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 30.8462C58.8437 30.8462 56.7273 28.8383 56.7273 26.3615C56.7273 23.8848 58.8437 21.8769 61.4545 21.8769C64.0653 21.8769 66.1818 23.8848 66.1818 26.3615C66.1818 28.8383 64.0653 30.8462 61.4545 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 30.8462C77.7528 30.8462 75.6364 28.8383 75.6364 26.3615C75.6364 23.8848 77.7528 21.8769 80.3636 21.8769C82.9744 21.8769 85.0909 23.8848 85.0909 26.3615C85.0909 28.8383 82.9744 30.8462 80.3636 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 12.9077C2.11647 12.9077 9.29503e-07 10.8999 8.16735e-07 8.42308C7.03968e-07 5.9463 2.11647 3.93847 4.72727 3.93847C7.33807 3.93847 9.45455 5.94629 9.45455 8.42308C9.45455 10.8999 7.33807 12.9077 4.72727 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M23.6364 12.9077C21.0256 12.9077 18.9091 10.8999 18.9091 8.42308C18.9091 5.94629 21.0256 3.93846 23.6364 3.93846C26.2472 3.93846 28.3636 5.94629 28.3636 8.42308C28.3636 10.8999 26.2472 12.9077 23.6364 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 12.9077C39.9347 12.9077 37.8182 10.8999 37.8182 8.42308C37.8182 5.94629 39.9347 3.93846 42.5455 3.93846C45.1563 3.93846 47.2727 5.94629 47.2727 8.42308C47.2727 10.8999 45.1563 12.9077 42.5455 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 12.9077C77.7528 12.9077 75.6364 10.8999 75.6364 8.42308C75.6364 5.94629 77.7528 3.93846 80.3636 3.93846C82.9744 3.93846 85.0909 5.94629 85.0909 8.42308C85.0909 10.8999 82.9744 12.9077 80.3636 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 12.9077C96.6619 12.9077 94.5454 10.8999 94.5454 8.42308C94.5454 5.94629 96.6619 3.93846 99.2727 3.93846C101.884 3.93846 104 5.94629 104 8.42308C104 10.8999 101.884 12.9077 99.2727 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 -5.03077C2.11647 -5.03077 1.12768e-07 -7.0386 0 -9.51538C-1.12768e-07 -11.9922 2.11647 -14 4.72727 -14C7.33807 -14 9.45455 -11.9922 9.45455 -9.51538C9.45455 -7.0386 7.33807 -5.03077 4.72727 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 -5.03077C39.9347 -5.03077 37.8182 -7.0386 37.8182 -9.51538C37.8182 -11.9922 39.9347 -14 42.5455 -14C45.1563 -14 47.2727 -11.9922 47.2727 -9.51538C47.2727 -7.0386 45.1563 -5.03077 42.5455 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 -5.03077C58.8437 -5.03077 56.7273 -7.0386 56.7273 -9.51538C56.7273 -11.9922 58.8437 -14 61.4545 -14C64.0653 -14 66.1818 -11.9922 66.1818 -9.51538C66.1818 -7.0386 64.0653 -5.03077 61.4545 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 -5.03077C77.7528 -5.03077 75.6364 -7.0386 75.6364 -9.51538C75.6364 -11.9922 77.7528 -14 80.3636 -14C82.9744 -14 85.0909 -11.9922 85.0909 -9.51539C85.0909 -7.0386 82.9744 -5.03077 80.3636 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 -5.03077C96.6619 -5.03077 94.5454 -7.0386 94.5454 -9.51539C94.5454 -11.9922 96.6619 -14 99.2727 -14C101.884 -14 104 -11.9922 104 -9.51539C104 -7.0386 101.884 -5.03077 99.2727 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 12.9077C58.8437 12.9077 56.7273 10.8999 56.7273 8.42308C56.7273 5.94629 58.8437 3.93846 61.4545 3.93846C64.0653 3.93846 66.1818 5.94629 66.1818 8.42308C66.1818 10.8999 64.0653 12.9077 61.4545 12.9077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M23.6364 -5.03077C21.0256 -5.03077 18.9091 -7.0386 18.9091 -9.51538C18.9091 -11.9922 21.0256 -14 23.6364 -14C26.2472 -14 28.3636 -11.9922 28.3636 -9.51538C28.3636 -7.0386 26.2472 -5.03077 23.6364 -5.03077Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 30.8462C39.9347 30.8462 37.8182 28.8383 37.8182 26.3615C37.8182 23.8848 39.9347 21.8769 42.5455 21.8769C45.1563 21.8769 47.2727 23.8848 47.2727 26.3615C47.2727 28.8383 45.1563 30.8462 42.5455 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 30.8462C96.6619 30.8462 94.5454 28.8383 94.5454 26.3615C94.5454 23.8848 96.6619 21.8769 99.2727 21.8769C101.884 21.8769 104 23.8848 104 26.3615C104 28.8383 101.884 30.8462 99.2727 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 30.8462C2.11647 30.8462 1.74624e-06 28.8383 1.63347e-06 26.3615C1.5207e-06 23.8848 2.11647 21.8769 4.72727 21.8769C7.33807 21.8769 9.45455 23.8848 9.45455 26.3615C9.45455 28.8383 7.33808 30.8462 4.72727 30.8462Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M23.6364 85C21.0256 85 18.9091 82.9922 18.9091 80.5154C18.9091 78.0386 21.0256 76.0308 23.6364 76.0308C26.2472 76.0308 28.3636 78.0386 28.3636 80.5154C28.3636 82.9922 26.2472 85 23.6364 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 85C58.8437 85 56.7273 82.9922 56.7273 80.5154C56.7273 78.0386 58.8437 76.0308 61.4545 76.0308C64.0653 76.0308 66.1818 78.0386 66.1818 80.5154C66.1818 82.9922 64.0653 85 61.4545 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 85C77.7528 85 75.6364 82.9922 75.6364 80.5154C75.6364 78.0386 77.7528 76.0308 80.3636 76.0308C82.9744 76.0308 85.0909 78.0386 85.0909 80.5154C85.0909 82.9922 82.9744 85 80.3636 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 67.0615C2.11647 67.0615 9.29503e-07 65.0537 8.16735e-07 62.5769C7.03968e-07 60.1001 2.11647 58.0923 4.72727 58.0923C7.33807 58.0923 9.45455 60.1001 9.45455 62.5769C9.45455 65.0537 7.33807 67.0615 4.72727 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M23.6364 67.0615C21.0256 67.0615 18.9091 65.0537 18.9091 62.5769C18.9091 60.1001 21.0256 58.0923 23.6364 58.0923C26.2472 58.0923 28.3636 60.1001 28.3636 62.5769C28.3636 65.0537 26.2472 67.0615 23.6364 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 67.0615C39.9347 67.0615 37.8182 65.0537 37.8182 62.5769C37.8182 60.1001 39.9347 58.0923 42.5455 58.0923C45.1563 58.0923 47.2727 60.1001 47.2727 62.5769C47.2727 65.0537 45.1563 67.0615 42.5455 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 67.0615C77.7528 67.0615 75.6364 65.0537 75.6364 62.5769C75.6364 60.1001 77.7528 58.0923 80.3636 58.0923C82.9744 58.0923 85.0909 60.1001 85.0909 62.5769C85.0909 65.0537 82.9744 67.0615 80.3636 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 67.0615C96.6619 67.0615 94.5454 65.0537 94.5454 62.5769C94.5454 60.1001 96.6619 58.0923 99.2727 58.0923C101.884 58.0923 104 60.1001 104 62.5769C104 65.0537 101.884 67.0615 99.2727 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 49.1231C2.11647 49.1231 1.12768e-07 47.1153 0 44.6385C-1.12768e-07 42.1617 2.11647 40.1539 4.72727 40.1539C7.33807 40.1539 9.45455 42.1617 9.45455 44.6385C9.45455 47.1153 7.33807 49.1231 4.72727 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 49.1231C39.9347 49.1231 37.8182 47.1153 37.8182 44.6385C37.8182 42.1617 39.9347 40.1539 42.5455 40.1539C45.1563 40.1539 47.2727 42.1617 47.2727 44.6385C47.2727 47.1153 45.1563 49.1231 42.5455 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 49.1231C58.8437 49.1231 56.7273 47.1153 56.7273 44.6385C56.7273 42.1617 58.8437 40.1539 61.4545 40.1539C64.0653 40.1539 66.1818 42.1617 66.1818 44.6385C66.1818 47.1153 64.0653 49.1231 61.4545 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M80.3636 49.1231C77.7528 49.1231 75.6364 47.1153 75.6364 44.6385C75.6364 42.1617 77.7528 40.1539 80.3636 40.1539C82.9744 40.1539 85.0909 42.1617 85.0909 44.6385C85.0909 47.1152 82.9744 49.1231 80.3636 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 49.1231C96.6619 49.1231 94.5454 47.1152 94.5454 44.6385C94.5454 42.1617 96.6619 40.1539 99.2727 40.1539C101.884 40.1539 104 42.1617 104 44.6385C104 47.1152 101.884 49.1231 99.2727 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M61.4545 67.0615C58.8437 67.0615 56.7273 65.0537 56.7273 62.5769C56.7273 60.1001 58.8437 58.0923 61.4545 58.0923C64.0653 58.0923 66.1818 60.1001 66.1818 62.5769C66.1818 65.0537 64.0653 67.0615 61.4545 67.0615Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M23.6364 49.1231C21.0256 49.1231 18.9091 47.1153 18.9091 44.6385C18.9091 42.1617 21.0256 40.1539 23.6364 40.1539C26.2472 40.1539 28.3636 42.1617 28.3636 44.6385C28.3636 47.1153 26.2472 49.1231 23.6364 49.1231Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M42.5455 85C39.9347 85 37.8182 82.9922 37.8182 80.5154C37.8182 78.0386 39.9347 76.0308 42.5455 76.0308C45.1563 76.0308 47.2727 78.0386 47.2727 80.5154C47.2727 82.9922 45.1563 85 42.5455 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M99.2727 85C96.6619 85 94.5454 82.9922 94.5454 80.5154C94.5454 78.0386 96.6619 76.0308 99.2727 76.0308C101.884 76.0308 104 78.0386 104 80.5154C104 82.9922 101.884 85 99.2727 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                            <path
                                    d="M4.72727 85C2.11647 85 1.74624e-06 82.9922 1.63347e-06 80.5154C1.5207e-06 78.0386 2.11647 76.0308 4.72727 76.0308C7.33807 76.0308 9.45455 78.0386 9.45455 80.5154C9.45455 82.9922 7.33808 85 4.72727 85Z"
                                    fill="#1D2977" fill-opacity="0.12"></path>
                        </svg>
                    </div>
                    <div class="sale-products-body">
                        <div class="sale-products-body-top">
                            <div class="sale-products-title"><span>محصولات <strong>مرتبط</strong></span>
                                <div class="sale-products-circle">
                                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_2743)">
                                            <g clip-path="url(#clip1_1_2743)">
                                                <circle cx="32" cy="32" r="32" transform="matrix(-1 0 0 1 64 0)"
                                                        fill="#FFD701"></circle>
                                            </g>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M40.711 13.1256C41.5263 12.736 42.4741 12.736 43.2894 13.1256C43.6436 13.2949 43.9681 13.5718 44.4175 13.9551C44.4408 13.975 44.4645 13.9952 44.4885 14.0156C44.7067 14.2016 44.7755 14.2588 44.845 14.3054C45.0219 14.424 45.2206 14.5062 45.4295 14.5475C45.5116 14.5637 45.6006 14.5719 45.8865 14.5947C45.9179 14.5972 45.9489 14.5997 45.9795 14.6021C46.5683 14.6488 46.9936 14.6825 47.3637 14.8133C48.2158 15.1142 48.886 15.7844 49.1869 16.6365C49.3177 17.0066 49.3514 17.4319 49.3981 18.0207C49.4006 18.0513 49.403 18.0823 49.4055 18.1137C49.4283 18.3996 49.4365 18.4886 49.4527 18.5707C49.494 18.7796 49.5762 18.9783 49.6948 19.1552C49.7414 19.2247 49.7986 19.2935 49.9846 19.5117C50.0051 19.5357 50.0252 19.5594 50.0451 19.5827C50.4285 20.0321 50.7053 20.3567 50.8746 20.7108C51.2642 21.5261 51.2642 22.4739 50.8746 23.2892C50.7053 23.6434 50.4285 23.968 50.0451 24.4174C50.0252 24.4407 50.0051 24.4644 49.9846 24.4884C49.7986 24.7066 49.7414 24.7754 49.6948 24.8449C49.5762 25.0218 49.494 25.2204 49.4527 25.4294C49.4365 25.5115 49.4283 25.6005 49.4055 25.8864C49.403 25.9178 49.4006 25.9488 49.3981 25.9794C49.3514 26.5682 49.3177 26.9934 49.1869 27.3636C48.886 28.2156 48.2158 28.8858 47.3637 29.1868C46.9936 29.3175 46.5683 29.3513 45.9795 29.398C45.9489 29.4004 45.9179 29.4029 45.8865 29.4054C45.6006 29.4282 45.5116 29.4364 45.4295 29.4526C45.2206 29.4938 45.0219 29.5761 44.845 29.6947C44.7755 29.7413 44.7067 29.7985 44.4885 29.9845C44.4645 30.0049 44.4408 30.0251 44.4175 30.045C43.9681 30.4283 43.6436 30.7052 43.2894 30.8744C42.4741 31.2641 41.5263 31.2641 40.711 30.8744C40.3568 30.7052 40.0322 30.4283 39.5828 30.045C39.5595 30.0251 39.5358 30.0049 39.5118 29.9845C39.2936 29.7985 39.2248 29.7413 39.1553 29.6947C38.9784 29.5761 38.7798 29.4938 38.5709 29.4526C38.4887 29.4364 38.3997 29.4282 38.1138 29.4054C38.0824 29.4029 38.0514 29.4004 38.0208 29.398C37.432 29.3513 37.0068 29.3175 36.6366 29.1868C35.7846 28.8858 35.1144 28.2156 34.8134 27.3636C34.6827 26.9934 34.6489 26.5682 34.6022 25.9794C34.5998 25.9488 34.5973 25.9178 34.5948 25.8864C34.572 25.6005 34.5638 25.5115 34.5476 25.4294C34.5064 25.2204 34.4241 25.0218 34.3055 24.8449C34.2589 24.7754 34.2017 24.7066 34.0157 24.4884C33.9953 24.4644 33.9751 24.4407 33.9552 24.4174C33.5719 23.968 33.2951 23.6434 33.1258 23.2892C32.7361 22.4739 32.7361 21.5261 33.1258 20.7108C33.2951 20.3566 33.5719 20.0321 33.9552 19.5827C33.9751 19.5594 33.9953 19.5357 34.0157 19.5117C34.2017 19.2935 34.2589 19.2247 34.3055 19.1552C34.4241 18.9783 34.5064 18.7796 34.5476 18.5707C34.5638 18.4886 34.572 18.3996 34.5948 18.1137C34.5973 18.0823 34.5998 18.0513 34.6022 18.0207C34.6489 17.4319 34.6827 17.0067 34.8134 16.6365C35.1144 15.7844 35.7846 15.1142 36.6366 14.8133C37.0068 14.6825 37.432 14.6488 38.0208 14.6021C38.0514 14.5997 38.0824 14.5972 38.1138 14.5947C38.3997 14.5719 38.4887 14.5637 38.5709 14.5475C38.7798 14.5062 38.9784 14.424 39.1553 14.3054C39.2248 14.2588 39.2936 14.2016 39.5118 14.0156C39.5358 13.9952 39.5595 13.975 39.5828 13.9551C40.0322 13.5718 40.3568 13.2949 40.711 13.1256ZM42.6943 14.3705C42.2553 14.1607 41.745 14.1607 41.306 14.3705C41.1363 14.4517 40.9573 14.5966 40.4068 15.0658C40.3977 15.0735 40.3888 15.0811 40.38 15.0886C40.1993 15.2427 40.0674 15.3551 39.9235 15.4516C39.595 15.6717 39.2261 15.8245 38.8381 15.9011C38.6681 15.9347 38.4954 15.9485 38.2587 15.9673C38.2471 15.9682 38.2355 15.9691 38.2236 15.9701C37.5025 16.0276 37.2735 16.0516 37.0961 16.1143C36.6373 16.2763 36.2765 16.6372 36.1144 17.096C36.0518 17.2734 36.0278 17.5024 35.9702 18.2235C35.9693 18.2353 35.9683 18.247 35.9674 18.2585C35.9486 18.4952 35.9348 18.668 35.9013 18.838C35.8247 19.226 35.6719 19.5949 35.4517 19.9234C35.3552 20.0673 35.2428 20.1992 35.0887 20.3799C35.0812 20.3887 35.0736 20.3976 35.0659 20.4067C34.5967 20.9572 34.4518 21.1361 34.3707 21.3059C34.1608 21.7449 34.1608 22.2552 34.3707 22.6942C34.4518 22.864 34.5967 23.0429 35.0659 23.5934C35.0736 23.6025 35.0812 23.6114 35.0887 23.6202C35.2428 23.8009 35.3552 23.9328 35.4517 24.0767C35.6719 24.4052 35.8247 24.7741 35.9013 25.1621C35.9348 25.3321 35.9486 25.5048 35.9674 25.7415C35.9683 25.7531 35.9693 25.7648 35.9702 25.7766C36.0278 26.4977 36.0518 26.7267 36.1144 26.9041C36.2765 27.3629 36.6373 27.7237 37.0961 27.8858C37.2735 27.9484 37.5025 27.9724 38.2236 28.03L38.2587 28.0328C38.4954 28.0516 38.6681 28.0654 38.8381 28.0989C39.2261 28.1755 39.595 28.3283 39.9235 28.5485C40.0674 28.645 40.1993 28.7574 40.38 28.9115L40.4068 28.9343C40.9573 29.4035 41.1363 29.5484 41.306 29.6296C41.745 29.8394 42.2553 29.8394 42.6943 29.6296C42.8641 29.5484 43.043 29.4035 43.5936 28.9343L43.6203 28.9115C43.801 28.7574 43.9329 28.645 44.0768 28.5485C44.4053 28.3283 44.7742 28.1755 45.1622 28.0989C45.3322 28.0654 45.505 28.0516 45.7417 28.0328L45.7767 28.03C46.4978 27.9724 46.7268 27.9484 46.9042 27.8858C47.363 27.7237 47.7239 27.3629 47.8859 26.9041C47.9486 26.7267 47.9726 26.4977 48.0301 25.7766L48.0329 25.7415C48.0517 25.5048 48.0655 25.3321 48.0991 25.1621C48.1757 24.7741 48.3285 24.4052 48.5486 24.0767C48.6451 23.9328 48.7575 23.8009 48.9116 23.6202L48.9344 23.5934C49.4036 23.0429 49.5486 22.864 49.6297 22.6942C49.8395 22.2552 49.8395 21.7449 49.6297 21.3059C49.5486 21.1361 49.4036 20.9572 48.9344 20.4067L48.9116 20.3799C48.7575 20.1992 48.6451 20.0673 48.5486 19.9234C48.3285 19.5949 48.1757 19.226 48.0991 18.838C48.0655 18.668 48.0517 18.4952 48.0329 18.2585L48.0301 18.2235C47.9726 17.5024 47.9486 17.2734 47.8859 17.096C47.7239 16.6372 47.363 16.2763 46.9042 16.1143C46.7268 16.0516 46.4978 16.0276 45.7767 15.9701C45.7649 15.9691 45.7532 15.9682 45.7417 15.9673C45.505 15.9485 45.3322 15.9347 45.1622 15.9011C44.7742 15.8245 44.4053 15.6717 44.0768 15.4516C43.9329 15.3551 43.801 15.2426 43.6203 15.0886C43.6115 15.0811 43.6026 15.0735 43.5936 15.0658C43.043 14.5966 42.8641 14.4517 42.6943 14.3705Z"
                                                  fill="#1D2977"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M45.2476 18.7527C45.517 19.0221 45.517 19.4589 45.2476 19.7283L39.7284 25.2474C39.459 25.5169 39.0222 25.5169 38.7528 25.2474C38.4834 24.978 38.4834 24.5412 38.7528 24.2718L44.2719 18.7527C44.5413 18.4832 44.9781 18.4832 45.2476 18.7527Z"
                                                  fill="#1D2977"></path>
                                            <path
                                                    d="M45.2197 24.2997C45.2197 24.8077 44.8078 25.2195 44.2998 25.2195C43.7918 25.2195 43.3799 24.8077 43.3799 24.2997C43.3799 23.7917 43.7918 23.3798 44.2998 23.3798C44.8078 23.3798 45.2197 23.7917 45.2197 24.2997Z"
                                                    fill="#1D2977"></path>
                                            <path
                                                    d="M40.6204 19.7004C40.6204 20.2084 40.2085 20.6203 39.7005 20.6203C39.1925 20.6203 38.7807 20.2084 38.7807 19.7004C38.7807 19.1924 39.1925 18.7806 39.7005 18.7806C40.2085 18.7806 40.6204 19.1924 40.6204 19.7004Z"
                                                    fill="#1D2977"></path>
                                            <circle cx="22" cy="60" r="17" fill="#F7F8FD" fill-opacity="0.64"></circle>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2743">
                                                <rect width="64" height="64" rx="32" fill="white"></rect>
                                            </clipPath>
                                            <clipPath id="clip1_1_2743">
                                                <rect width="64" height="64" rx="32" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <span class="sale-products-name-english">RELATED PRODUCTS</span>
                                <div class="sale-products-shape"></div>
                            </div>
                            <div class="sale-products-button-slider">
                                <div id="prev" title="قبلی" class="sale-products-body-bottom-left" tabindex="0"
                                     role="button"
                                     aria-label="Previous slide" aria-controls="swiper-wrapper-036bb68635b5148a">
                                    <svg width="27" height="14" viewBox="0 0 27 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M19.2792 12.8875C19.2792 12.6975 19.3492 12.5075 19.4992 12.3575L25.0392 6.8175L19.4992 1.2775C19.2092 0.9875 19.2092 0.5075 19.4992 0.2175C19.7892 -0.0725003 20.2692 -0.0725003 20.5592 0.2175L26.6292 6.2875C26.9192 6.5775 26.9192 7.0575 26.6292 7.3475L20.5592 13.4175C20.2692 13.7075 19.7892 13.7075 19.4992 13.4175C19.3492 13.2775 19.2792 13.0775 19.2792 12.8875Z"
                                                fill="#F7F8FD"></path>
                                        <path
                                                d="M-0.000410113 6.81738C-0.000410095 6.40738 0.33959 6.06738 0.74959 6.06738L25.5796 6.06738C25.9896 6.06738 26.3296 6.40738 26.3296 6.81738C26.3296 7.22738 25.9896 7.56738 25.5796 7.56738L0.74959 7.56738C0.33959 7.56738 -0.000410131 7.22738 -0.000410113 6.81738Z"
                                                fill="#F7F8FD"></path>
                                    </svg>
                                </div>
                                <div id="next" title="بعدی" class="sale-products-body-bottom-right" tabindex="0"
                                     role="button"
                                     aria-label="Next slide" aria-controls="swiper-wrapper-036bb68635b5148a">
                                    <svg width="27" height="14" viewBox="0 0 27 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M7.72082 12.8875C7.72082 12.6975 7.65082 12.5075 7.50082 12.3575L1.96082 6.8175L7.50082 1.2775C7.79082 0.9875 7.79082 0.5075 7.50082 0.2175C7.21082 -0.0725003 6.73082 -0.0725003 6.44082 0.2175L0.370821 6.2875C0.0808206 6.5775 0.0808206 7.0575 0.370821 7.3475L6.44082 13.4175C6.73082 13.7075 7.21082 13.7075 7.50082 13.4175C7.65082 13.2775 7.72082 13.0775 7.72082 12.8875Z"
                                                fill="#F7F8FD"></path>
                                        <path
                                                d="M27.0004 6.81738C27.0004 6.40738 26.6604 6.06738 26.2504 6.06738L1.42041 6.06738C1.01041 6.06738 0.67041 6.40738 0.67041 6.81738C0.67041 7.22738 1.01041 7.56738 1.42041 7.56738L26.2504 7.56738C26.6604 7.56738 27.0004 7.22738 27.0004 6.81738Z"
                                                fill="#F7F8FD"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div
                                class="sale-products-body-bottom swiper swiper-initialized swiper-horizontal swiper-rtl swiper-backface-hidden">
                            <div class="swiper-wrapper" id="swiper-wrapper-036bb68635b5148a" aria-live="polite">
                                @foreach($related_products as $product)
                                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 5"
                                         data-swiper-slide-index="0" style="width: 474px;">
                                        <div class="sale-products-card">
                                            <div class="sale-products-card-body">
                                                <div class="sale-products-card-img">
                                                    <div class="sale-products-card-rectangle">
                                                        @if($product->colors->count())
                                                            <div class="sale-products-card-circle-color">
                                                                @foreach($product->colors as $color)
                                                                    <span
                                                                            style="background-color: {{ $color->code }}; z-index: {{ 10 - $loop->index }};"></span>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <div class="sale-products-card-circle"></div>
                                                    </div>
                                                    <img decoding="async"
                                                         src="{{ asset('storage/products/'.$product->image) }}"
                                                         alt="{{$product->title}}"
                                                         fetchpriority="high"
                                                    >
                                                    @if($product->productVariant->first()?->discount_percent)
                                                        <div class="sale-products-card-badge-sale">
                                                            <span>%{{ $product->productVariant->first()->discount_percent }}</span>
                                                            <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                        d="M19.0566 3.98438C21.2583 2.2014 24.4077 2.2014 26.6094 3.98438L27.54 4.73828C27.9547 5.07395 28.4863 5.23008 29.0166 5.17188L30.207 5.04102C33.0231 4.73139 35.6723 6.43378 36.5605 9.12402L36.9355 10.2607C37.1029 10.7676 37.4665 11.187 37.9443 11.4248L39.0166 11.958C41.553 13.2201 42.8606 16.0848 42.1533 18.8281L41.8545 19.9873C41.7212 20.5042 41.8007 21.0533 42.0742 21.5117L42.6875 22.54C44.1388 24.973 43.6904 28.0892 41.6123 30.0146L40.7344 30.8291C40.3428 31.1919 40.1125 31.696 40.0947 32.2295L40.0547 33.4258C39.9604 36.2572 37.8985 38.6374 35.1094 39.1338L33.9297 39.3438C33.4044 39.4373 32.938 39.7367 32.6348 40.1758L31.9541 41.1611C30.3439 43.4922 27.3228 44.3795 24.708 43.2891L23.6025 42.8281C23.11 42.6228 22.556 42.6228 22.0635 42.8281L20.958 43.2891C18.3432 44.3795 15.3221 43.4922 13.7119 41.1611L13.0312 40.1758C12.728 39.7367 12.2616 39.4373 11.7363 39.3438L10.5566 39.1338C7.76749 38.6374 5.70563 36.2572 5.61133 33.4258L5.57129 32.2295C5.55352 31.696 5.32318 31.1919 4.93164 30.8291L4.05371 30.0146C1.97564 28.0892 1.52722 24.973 2.97852 22.54L3.5918 21.5117C3.86527 21.0533 3.94477 20.5042 3.81152 19.9873L3.5127 18.8281C2.80546 16.0848 4.11304 13.2201 6.64941 11.958L7.72168 11.4248C8.19957 11.187 8.56312 10.7676 8.73047 10.2607L9.10547 9.12402C9.99368 6.43378 12.6429 4.73139 15.459 5.04102L16.6494 5.17188C17.1797 5.23008 17.7113 5.07395 18.126 4.73828L19.0566 3.98438Z"
                                                                        fill="#E80645" stroke="white"
                                                                        stroke-width="4"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="sale-products-card-content">
                                                    <div class="sale-products-card-header">
                                                        <h3>
                                                            <a href="{{route('single.product',$product->slug)}}">{{$product->title}}</a>
                                                        </h3>
                                                        <div>
                                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                        d="M6.42937 1.25623C6.60898 0.703442 7.39102 0.703444 7.57063 1.25623L8.6614 4.61327C8.74173 4.86049 8.9721 5.02786 9.23204 5.02786H12.7618C13.3431 5.02786 13.5847 5.77163 13.1145 6.11327L10.2588 8.18804C10.0485 8.34083 9.96055 8.61165 10.0409 8.85886L11.1316 12.2159C11.3113 12.7687 10.6786 13.2284 10.2083 12.8867L7.35267 10.812C7.14238 10.6592 6.85762 10.6592 6.64733 10.812L3.79166 12.8867C3.32143 13.2284 2.68874 12.7687 2.86835 12.2159L3.95912 8.85886C4.03945 8.61165 3.95145 8.34083 3.74116 8.18804L0.885485 6.11327C0.415257 5.77163 0.656924 5.02786 1.23816 5.02786H4.76796C5.0279 5.02786 5.25827 4.86049 5.3386 4.61327L6.42937 1.25623Z"
                                                                        fill="#FAA307"></path>
                                                            </svg>
                                                            <span>4.3</span></div>
                                                    </div>
                                                    <div class="underline-kamand">
                                                        <div class="underline-kamand-line"></div>
                                                        <div class="underline-kamand-circle"></div>
                                                    </div>
                                                    <div class="sale-products-card-bottom">
                                                        @if($product->productVariant->first()?->discount_percent)

                                                            <div class="sale-products-card-amount-regular">
                                                                <div class="sale-products-card-amount-regular">
                                                                    <span>{{ number_format($product->productVariant->first()->main_price) }}</span>
                                                                    <div class="sale-products-card-amount-regular-line"></div>
                                                                </div>
                                                            </div>

                                                            <div class="sale-products-card-amount-sale">
                                                                <div class="sale-products-card-amount-sale-shape"></div>
                                                                <span class="sale-products-card-amount-sale-amount">
                                                            {{ number_format($product->productVariant->first()->discount_price) }}
                                                        </span>
                                                                <span>تومان</span>
                                                            </div>

                                                        @else

                                                            <div class="sale-products-card-amount-sale">
                                                        <span class="sale-products-card-amount-sale-amount">
                                                            {{ number_format($product->productVariant->first()?->main_price ?? 0) }}
                                                        </span>
                                                                <span>تومان</span>
                                                            </div>

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-products-card-footer">
                                                <div class="wishlist-product wishlist-btn " data-product-id="1129">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M5.62436 4.4241C3.96537 5.18243 2.75 6.98614 2.75 9.13701C2.75 11.3344 3.64922 13.0281 4.93829 14.4797C6.00072 15.676 7.28684 16.6675 8.54113 17.6345C8.83904 17.8642 9.13515 18.0925 9.42605 18.3218C9.95208 18.7365 10.4213 19.1004 10.8736 19.3647C11.3261 19.6292 11.6904 19.7499 12 19.7499C12.3096 19.7499 12.6739 19.6292 13.1264 19.3647C13.5787 19.1004 14.0479 18.7365 14.574 18.3218C14.8649 18.0925 15.161 17.8642 15.4589 17.6345C16.7132 16.6675 17.9993 15.676 19.0617 14.4797C20.3508 13.0281 21.25 11.3344 21.25 9.13701C21.25 6.98614 20.0346 5.18243 18.3756 4.4241C16.7639 3.68739 14.5983 3.88249 12.5404 6.02065C12.399 6.16754 12.2039 6.25054 12 6.25054C11.7961 6.25054 11.601 6.16754 11.4596 6.02065C9.40166 3.88249 7.23607 3.68739 5.62436 4.4241ZM12 4.45873C9.68795 2.39015 7.09896 2.10078 5.00076 3.05987C2.78471 4.07283 1.25 6.42494 1.25 9.13701C1.25 11.8025 2.3605 13.836 3.81672 15.4757C4.98287 16.7888 6.41022 17.8879 7.67083 18.8585C7.95659 19.0785 8.23378 19.292 8.49742 19.4998C9.00965 19.9036 9.55954 20.3342 10.1168 20.6598C10.6739 20.9853 11.3096 21.2499 12 21.2499C12.6904 21.2499 13.3261 20.9853 13.8832 20.6598C14.4405 20.3342 14.9903 19.9036 15.5026 19.4998C15.7662 19.292 16.0434 19.0785 16.3292 18.8585C17.5898 17.8879 19.0171 16.7888 20.1833 15.4757C21.6395 13.836 22.75 11.8025 22.75 9.13701C22.75 6.42494 21.2153 4.07283 18.9992 3.05987C16.901 2.10078 14.3121 2.39015 12 4.45873Z"
                                                              fill="#1D2977"></path>
                                                    </svg>
                                                </div>
                                                <div class="cart-product" data-product-id="1129"
                                                     data-product-type="variable"
                                                     data-product-url="#">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M12.0001 2.75C10.7574 2.75 9.75006 3.75736 9.75006 5V5.25447C10.1676 5.24999 10.6183 5.25 11.1053 5.25H12.8948C13.3819 5.25 13.8326 5.24999 14.2501 5.25447V5C14.2501 3.75736 13.2427 2.75 12.0001 2.75ZM15.7501 5.30693V5C15.7501 2.92893 14.0711 1.25 12.0001 1.25C9.929 1.25 8.25006 2.92893 8.25006 5V5.30693C8.11506 5.31679 7.98479 5.32834 7.85904 5.34189C6.98068 5.43656 6.24614 5.63489 5.59385 6.08197C5.3695 6.23574 5.15877 6.40849 4.96399 6.59833C4.39766 7.15027 4.05914 7.83166 3.79405 8.67439C3.53667 9.49258 3.32867 10.5327 3.06729 11.8396L3.04822 11.935C2.67158 13.8181 2.37478 15.302 2.28954 16.484C2.20244 17.6916 2.32415 18.7075 2.89619 19.5879C3.08705 19.8817 3.30982 20.1534 3.56044 20.3982C4.31157 21.1318 5.28392 21.4504 6.48518 21.6018C7.66087 21.75 9.17418 21.75 11.0946 21.75H12.9055C14.826 21.75 16.3393 21.75 17.515 21.6018C18.7162 21.4504 19.6886 21.1318 20.4397 20.3982C20.6903 20.1534 20.9131 19.8817 21.1039 19.5879C21.676 18.7075 21.7977 17.6916 21.7106 16.484C21.6254 15.302 21.3286 13.8182 20.9519 11.9351L20.9328 11.8396C20.6715 10.5327 20.4635 9.49259 20.2061 8.67439C19.941 7.83166 19.6025 7.15027 19.0361 6.59833C18.8414 6.40849 18.6306 6.23574 18.4063 6.08197C17.754 5.63489 17.0194 5.43656 16.1411 5.34189C16.0153 5.32834 15.8851 5.31679 15.7501 5.30693ZM8.01978 6.83326C7.27307 6.91374 6.81177 7.06572 6.44188 7.31924C6.28838 7.42445 6.1442 7.54265 6.01093 7.67254C5.68979 7.98552 5.45028 8.40807 5.22493 9.12449C4.99463 9.85661 4.80147 10.8172 4.52967 12.1762C4.14013 14.1239 3.8633 15.5153 3.78565 16.5919C3.70906 17.6538 3.83838 18.2849 4.15401 18.7707C4.2846 18.9717 4.43702 19.1576 4.60849 19.3251C5.02293 19.7298 5.61646 19.9804 6.67278 20.1136C7.74368 20.2486 9.1623 20.25 11.1486 20.25H12.8515C14.8378 20.25 16.2565 20.2486 17.3273 20.1136C18.3837 19.9804 18.9772 19.7298 19.3916 19.3251C19.5631 19.1576 19.7155 18.9717 19.8461 18.7707C20.1617 18.2849 20.2911 17.6538 20.2145 16.5919C20.1368 15.5153 19.86 14.1239 19.4705 12.1762C19.1987 10.8172 19.0055 9.85661 18.7752 9.12449C18.5498 8.40807 18.3103 7.98552 17.9892 7.67254C17.8559 7.54265 17.7118 7.42445 17.5583 7.31924C17.1884 7.06572 16.7271 6.91374 15.9804 6.83326C15.2173 6.75101 14.2374 6.75 12.8515 6.75H11.1486C9.76271 6.75 8.78285 6.75101 8.01978 6.83326ZM8.92103 14.2929C9.31157 14.1548 9.74006 14.3595 9.87809 14.7501C10.1873 15.625 11.0218 16.25 12.0003 16.25C12.9788 16.25 13.8132 15.625 14.1224 14.7501C14.2605 14.3595 14.689 14.1548 15.0795 14.2929C15.47 14.4309 15.6747 14.8594 15.5367 15.2499C15.0222 16.7054 13.6342 17.75 12.0003 17.75C10.3663 17.75 8.97827 16.7054 8.46383 15.2499C8.3258 14.8594 8.53049 14.4309 8.92103 14.2929Z"
                                                              fill="#1D2977"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                                    class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    </div>
                </section>
            </div>
        @endif
        <!-- end product boxs -->
    </div>
@endsection
