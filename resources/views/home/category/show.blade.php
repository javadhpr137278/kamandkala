@extends('home.layouts.master')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 d-lg-block d-none">
                <div class="item-boxs position-sticky top-0">

                    {{-- ====================== فیلتر های اعمال شده ====================== --}}
                    <div class="item-box shadow-box">
                        <div class="title">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="font-14">فیلتر های اعمال شده</h6>
                                <a class="btn border-0" data-bs-toggle="collapse" href="#collapseItemBox" role="button"
                                   aria-expanded="false">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="desc collapse show" id="collapseItemBox">
                            @php
                                $hasActiveFilters = false;
                                $currentParams = request()->all();
                            @endphp

                            {{-- فیلتر برند --}}
                            @if(request('brand'))
                                @php
                                    $brandsParam = request('brand');
                                    $brandsList = is_array($brandsParam) ? $brandsParam : explode(',', $brandsParam);
                                    $hasActiveFilters = true;
                                @endphp
                                @foreach($brandsList as $brandTitle)
                                    @php
                                        $brandModel = \App\Models\Brand::where('title', $brandTitle)->first();
                                        $brandDisplayName = $brandModel ? $brandModel->title : $brandTitle;
                                        $newBrandsList = array_filter($brandsList, function($b) use ($brandTitle) { return $b !== $brandTitle; });
                                        $newBrandsParam = !empty($newBrandsList) ? implode(',', $newBrandsList) : null;
                                    @endphp
                                    <a href="{{ route('home.home.category.show', array_merge(['slug' => $category->slug], $currentParams, ['brand' => $newBrandsParam, 'page' => null])) }}"
                                       class="btn btn-sm rounded-pill border-1 border-muted me-1 font-14 mb-2">
                                        <span>برند: {{ $brandDisplayName }}</span>
                                        <span class="ms-3"><i class="bi bi-x text-danger"></i></span>
                                    </a>
                                @endforeach
                            @endif

                            {{-- فیلتر قیمت --}}
                            @if(request('min_price') || request('max_price'))
                                @php
                                    $hasActiveFilters = true;
                                    $minPriceVal = request('min_price', 0);
                                    $maxPriceVal = request('max_price', 0);
                                @endphp
                                <a href="{{ route('home.home.category.show', array_merge(['slug' => $category->slug], $currentParams, ['min_price' => null, 'max_price' => null, 'page' => null])) }}"
                                   class="btn btn-sm rounded-pill border-1 border-muted me-1 font-14 mb-2">
                                    <span>قیمت: {{ number_format($minPriceVal) }} - {{ number_format($maxPriceVal) }} تومان</span>
                                    <span class="ms-3"><i class="bi bi-x text-danger"></i></span>
                                </a>
                            @endif

                            {{-- فیلتر مرتب‌سازی --}}
                            @if(request('sort'))
                                @php
                                    $hasActiveFilters = true;
                                    $sortValue = request('sort');
                                    $sortLabels = [
                                        'latest' => 'جدیدترین',
                                        'oldest' => 'قدیمی‌ترین',
                                        'price_asc' => 'گران‌ترین',
                                        'price_desc' => 'ارزان‌ترین',
                                        'most_sold' => 'پرفروش‌ترین'
                                    ];
                                    $sortLabel = $sortLabels[$sortValue] ?? $sortValue;
                                @endphp
                                <a href="{{ route('home.home.category.show', array_merge(['slug' => $category->slug], $currentParams, ['sort' => null, 'page' => null])) }}"
                                   class="btn btn-sm rounded-pill border-1 border-muted me-1 font-14 mb-2">
                                    <span>مرتب‌سازی: {{ $sortLabel }}</span>
                                    <span class="ms-3"><i class="bi bi-x text-danger"></i></span>
                                </a>
                            @endif

                            {{-- اگر هیچ فیلتری فعال نیست --}}
                            @if(!$hasActiveFilters)
                                <div class="text-center py-3">
                                    <span class="text-muted">هیچ فیلتری انتخاب نشده است</span>
                                </div>
                            @endif

                            {{-- دکمه حذف همه فیلترها --}}
                            @if($hasActiveFilters)
                                <div class="text-center mt-3 pt-2 border-top">
                                    <a href="{{ route('home.home.category.show', $category->slug) }}" class="btn btn-danger btn-sm rounded-pill px-4">
                                        <i class="bi bi-trash3"></i> حذف همه فیلترها
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ====================== فیلتر محدوده قیمت ====================== --}}
                    <div class="item-box shadow-box">
                        <div class="title">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="font-14">محدوده قیمت</h6>
                                <a class="btn border-0" data-bs-toggle="collapse" href="#collapsePrice" role="button"
                                   aria-expanded="false">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="desc collapse show" id="collapsePrice">
                            <div class="filter-item-content">
                                <form action="{{ route('home.category.show', $category->slug) }}" method="get" id="priceFilterForm">
                                    @foreach(request()->except(['min_price', 'max_price', 'page', 'slug']) as $key => $value)
                                        @if(is_array($value))
                                            @foreach($value as $item)
                                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endif
                                    @endforeach

                                    <div class="row">
                                        <div class="col-6">
                                            <input type="number" name="min_price" min="0" max="100000000"
                                                   class="form-control input-range-filter" id="minPriceInput"
                                                   placeholder="از 0"
                                                   value="{{ request('min_price', 0) }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="max_price" min="0" max="100000000"
                                                   class="form-control input-range-filter" id="maxPriceInput"
                                                   placeholder="تا 100,000,000"
                                                   value="{{ request('max_price', 100000000) }}">
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center my-3">
                                                <button type="submit"
                                                        class="btn main-color-green text-white rounded-pill px-5 py-2">
                                                    اعمال فیلتر
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ====================== فیلتر برند (چک‌باکسی) ====================== --}}
                    <div class="item-box shadow-box">
                        <div class="title">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="font-14">فیلتر بر اساس برند</h6>
                                <a class="btn border-0" data-bs-toggle="collapse" href="#collapseBrandFilter" role="button"
                                   aria-expanded="false">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="desc collapse show" id="collapseBrandFilter">
                            <div class="filter-item-content">
                                <form action="{{ route('home.category.show', $category->slug) }}" method="get" id="brandFilterForm">
                                    @foreach(request()->except(['brand', 'page', 'slug']) as $key => $value)
                                        @if(is_array($value))
                                            @foreach($value as $item)
                                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                            @endforeach
                                        @elseif($key !== 'brand')
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endif
                                    @endforeach

                                    @php
                                        $selectedBrandsParam = request('brand');
                                        $selectedBrands = [];
                                        if($selectedBrandsParam) {
                                            $selectedBrands = is_array($selectedBrandsParam) ? $selectedBrandsParam : explode(',', $selectedBrandsParam);
                                        }
                                        // دریافت برندهای موجود در این دسته‌بندی
                                        $brandsInCategory = \App\Models\Brand::whereHas('products', function($q) use ($category) {
                                            $q->where('category_id', $category->id);
                                        })->withCount(['products' => function($q) use ($category) {
                                            $q->where('category_id', $category->id);
                                        }])->get();
                                    @endphp

                                    @foreach($brandsInCategory as $brand)
                                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                            <div class="form-check">
                                                <label for="brand_{{ $brand->id }}" class="form-check-label">
                                                    @if($brand->image)
                                                        <img src="{{ asset('storage/' . $brand->image) }}"
                                                             alt="{{ $brand->title }}" width="20" class="me-1">
                                                    @endif
                                                    {{ $brand->title }}
                                                </label>
                                                <input type="checkbox" name="brand[]" id="brand_{{ $brand->id }}"
                                                       value="{{ $brand->title }}" class="form-check-input brand-checkbox"
                                                    {{ in_array($brand->title, $selectedBrands) ? 'checked' : '' }}>
                                            </div>
                                            <div>
                                                <span class="fw-bold font-14">({{ $brand->products_count }})</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="text-center mb-3 mt-2">
                                        <button type="submit"
                                                class="btn main-color-green text-white rounded-pill px-5 py-2">
                                            اعمال فیلتر
                                        </button>
                                        @if(!empty($selectedBrands))
                                            <a href="{{ route('home.home.category.show', array_merge(['slug' => $category->slug], request()->except(['brand', 'page']))) }}"
                                               class="btn btn-secondary rounded-pill px-3 py-2 mt-2 d-inline-block">
                                                حذف فیلتر برند
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ====================== فیلتر مرتب‌سازی ====================== --}}
                    <div class="item-box shadow-box">
                        <div class="title">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="font-14">مرتب‌سازی محصولات</h6>
                                <a class="btn border-0" data-bs-toggle="collapse" href="#collapseSort" role="button"
                                   aria-expanded="false">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="desc collapse show" id="collapseSort">
                            <div class="filter-item-content">
                                <form action="{{ route('home.category.show', $category->slug) }}" method="get" id="sortFilterForm">
                                    @foreach(request()->except(['sort', 'page', 'slug']) as $key => $value)
                                        @if(is_array($value))
                                            @foreach($value as $item)
                                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                            @endforeach
                                        @else
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endif
                                    @endforeach

                                    <div class="form-group">
                                        <select name="sort" class="form-control" onchange="this.form.submit()">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>جدیدترین</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>ارزان‌ترین</option>
                                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>گران‌ترین</option>
                                            <option value="most_sold" {{ request('sort') == 'most_sold' ? 'selected' : '' }}>پرفروش‌ترین</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-9">
                <div class="filter-items shadow-box mb-4 bg-white p-4 rounded-4">
                    <div class="row g-3 align-items-center">
                        <section class="archive-category-product-filter">
                            <span>مرتب‌سازی:</span>
                            <div class="archive-category-product-filter-value">
                                <a href="{{ route('home.category.show', ['slug' => $category->slug, 'sort' => 'most_sold']) }}" class="{{ request('sort') == 'most_sold' ? 'active' : '' }}">
                                    پرفروش‌ترین‌ها
                                </a>
                                <a href="{{ route('home.category.show', ['slug' => $category->slug, 'sort' => 'latest']) }}" class="{{ request('sort') == 'latest' ? 'active' : '' }}">
                                    جدیدترین‌ها
                                </a>
                                <a href="{{ route('home.category.show', ['slug' => $category->slug, 'sort' => 'oldest']) }}" class="{{ request('sort') == 'oldest' ? 'active' : '' }}">
                                    قدیمی‌ترین‌ها
                                </a>
                                <a href="{{ route('home.category.show', ['slug' => $category->slug, 'sort' => 'price_asc']) }}" class="{{ request('sort') == 'price_asc' ? 'active' : '' }}">
                                    ارزان‌ترین‌ها
                                </a>
                                <a href="{{ route('home.category.show', ['slug' => $category->slug, 'sort' => 'price_desc']) }}" class="{{ request('sort') == 'price_desc' ? 'active' : '' }}">
                                    گران‌ترین‌ها
                                </a>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row g-4 search" id="products-container">
                    @forelse($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="product-archive-content-items">
                                <div class="product-archive-content-item">
                                    <div class="product-archive-content-item-header">
                                        <img loading="lazy" decoding="async" width="300" height="300"
                                             src="{{ asset('storage/products/'.$product->image) }}"
                                             class="kamand-product-image wp-post-image"
                                             alt="{{ $product->etitle ?? $product->title }}"
                                             sizes="(max-width: 300px) 100vw, 300px">
                                        <div class="product-archive-content-item-header-button">
                                            <div class="product-archive-content-item-header-button-item product-share-btn"
                                                 data-product-title="{{ $product->title }}"
                                                 data-product-url="{{ route('single.product', $product->slug) }}">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 2.25C14.7051 2.25 13.25 3.70507 13.25 5.5C13.25 5.69591 13.2673 5.88776 13.3006 6.07412L8.56991 9.38558C8.54587 9.4024 8.52312 9.42038 8.50168 9.43939C7.94993 9.00747 7.25503 8.75 6.5 8.75C4.70507 8.75 3.25 10.2051 3.25 12C3.25 13.7949 4.70507 15.25 6.5 15.25C7.25503 15.25 7.94993 14.9925 8.50168 14.5606C8.52312 14.5796 8.54587 14.5976 8.56991 14.6144L13.3006 17.9259C13.2673 18.1122 13.25 18.3041 13.25 18.5C13.25 20.2949 14.7051 21.75 16.5 21.75C18.2949 21.75 19.75 20.2949 19.75 18.5C19.75 16.7051 18.2949 15.25 16.5 15.25C15.4472 15.25 14.5113 15.7506 13.9174 16.5267L9.43806 13.3911C9.63809 12.9694 9.75 12.4978 9.75 12C9.75 11.5022 9.63809 11.0306 9.43806 10.6089L13.9174 7.4733C14.5113 8.24942 15.4472 8.75 16.5 8.75C18.2949 8.75 19.75 7.29493 19.75 5.5C19.75 3.70507 18.2949 2.25 16.5 2.25ZM14.75 5.5C14.75 4.5335 15.5335 3.75 16.5 3.75C17.4665 3.75 18.25 4.5335 18.25 5.5C18.25 6.4665 17.4665 7.25 16.5 7.25C15.5335 7.25 14.75 6.4665 14.75 5.5ZM6.5 10.25C5.5335 10.25 4.75 11.0335 4.75 12C4.75 12.9665 5.5335 13.75 6.5 13.75C7.4665 13.75 8.25 12.9665 8.25 12C8.25 11.0335 7.4665 10.25 6.5 10.25ZM16.5 16.75C15.5335 16.75 14.75 17.5335 14.75 18.5C14.75 19.4665 15.5335 20.25 16.5 20.25C17.4665 20.25 18.25 19.4665 18.25 18.5C18.25 17.5335 17.4665 16.75 16.5 16.75Z" fill="#1D2977"></path>
                                                </svg>
                                            </div>
                                            <div class="product-archive-content-item-header-button-item" onclick="loginBeforeWhishlist()">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21827 3.31808C2.97403 3.88683 2.0625 5.23961 2.0625 6.85276C2.0625 8.50081 2.73691 9.77111 3.70371 10.8598C4.50054 11.757 5.46513 12.5007 6.40584 13.2259C6.62928 13.3981 6.85136 13.5694 7.06953 13.7413C7.46406 14.0524 7.81599 14.3253 8.15521 14.5236C8.49461 14.7219 8.7678 14.8124 9 14.8124C9.2322 14.8124 9.50539 14.7219 9.84479 14.5236C10.184 14.3253 10.5359 14.0524 10.9305 13.7413C11.1486 13.5694 11.3707 13.3981 11.5942 13.2259C12.5349 12.5007 13.4995 11.757 14.2963 10.8598C15.2631 9.77111 15.9375 8.50081 15.9375 6.85276C15.9375 5.23961 15.026 3.88683 13.7817 3.31808C12.5729 2.76554 10.9488 2.91187 9.40527 4.51548C9.29923 4.62566 9.15291 4.68791 9 4.68791C8.84709 4.68791 8.70077 4.62566 8.59473 4.51548C7.05125 2.91187 5.42705 2.76554 4.21827 3.31808ZM9 3.34404C7.26596 1.79261 5.32422 1.57559 3.75057 2.2949C2.08853 3.05463 0.9375 4.81871 0.9375 6.85276C0.9375 8.85191 1.77037 10.377 2.86254 11.6068C3.73715 12.5916 4.80767 13.4159 5.75312 14.1439C5.96744 14.3089 6.17533 14.469 6.37306 14.6248C6.75724 14.9277 7.16966 15.2506 7.58762 15.4949C8.00539 15.739 8.4822 15.9374 9 15.9374C9.5178 15.9374 9.99461 15.739 10.4124 15.4949C10.8303 15.2506 11.2428 14.9277 11.6269 14.6248C11.8247 14.469 12.0326 14.3089 12.2469 14.1439C13.1923 13.4159 14.2628 12.5916 15.1375 11.6068C16.2296 10.377 17.0625 8.85191 17.0625 6.85276C17.0625 4.81871 15.9115 3.05463 14.2494 2.2949C12.6758 1.57559 10.734 1.79261 9 3.34404Z" fill="#1D2977"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-product-kamand-item-bottom">
                                        <div class="single-product-kamand-item-bottom-header">
                                            <div class="single-product-kamand-item-bottom-header-name">
                                                <div class="single-product-kamand-item-bottom-header-category">
                                                    <a href="{{ route('single.product', $product->slug) }}" target="_blank" rel="follow" class="single-product-kamand-item-bottom-header-category-name">
                                                        <img decoding="async" src="{{ asset('storage/'.$product->category->image) }}" alt="{{ $product->category->title }}">
                                                        <span>{{ $product->category->title }}</span>
                                                    </a>
                                                    <div class="single-product-kamand-item-bottom-header-category-stock in-stock">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1_11360)">
                                                                <path d="M10.6866 6.68693C10.8818 6.49167 10.8818 6.17508 10.6866 5.97982C10.4913 5.78456 10.1747 5.78456 9.97945 5.97982L6.99968 8.9596L6.01989 7.97982C5.82463 7.78456 5.50805 7.78456 5.31279 7.97982C5.11753 8.17508 5.11753 8.49167 5.31279 8.68693L6.64612 10.0203C6.84138 10.2155 7.15797 10.2155 7.35323 10.0203L10.6866 6.68693Z" fill="#02734C"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99967 0.833373C4.04163 0.833374 0.833008 4.042 0.833008 8.00004C0.833009 11.9581 4.04164 15.1667 7.99968 15.1667C11.9577 15.1667 15.1663 11.9581 15.1663 8.00004C15.1663 4.042 11.9577 0.833373 7.99967 0.833373ZM1.83301 8.00004C1.83301 4.59429 4.59392 1.83337 7.99967 1.83337C11.4054 1.83337 14.1663 4.59428 14.1663 8.00004C14.1663 11.4058 11.4054 14.1667 7.99968 14.1667C4.59392 14.1667 1.83301 11.4058 1.83301 8.00004Z" fill="#02734C"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_1_11360">
                                                                    <rect width="16" height="16" fill="white"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                        @if(($product->productVariant->first()?->stock ?? 0) > 0)
                                                            <span>موجود در انبار</span>
                                                        @else
                                                            <span>ناموجود در انبار</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <a href="{{ route('single.product', $product->slug) }}" class="single-product-kamand-item-bottom-header-name-title">{{ $product->title }}</a>
                                            </div>
                                            <div class="underline-kamand">
                                                <div class="underline-kamand-line"></div>
                                                <div class="underline-kamand-circle"></div>
                                            </div>

                                            @php
                                                $variant = $product->productVariant->first();
                                                $price = $variant?->main_price ?? 0;
                                                $discount = $variant?->discount_percent ?? 0;
                                                $final_price = $discount ? $price - ($price * $discount / 100) : $price;
                                            @endphp

                                            <div class="single-product-kamand-item-bottom-header-price" data-product-id="{{ $product->id }}">
                                                @if($discount)
                                                    <div class="single-product-kamand-item-bottom-header-price-regular">
                                                        <div class="single-product-kamand-item-bottom-header-price-regular-number">
                                                            {{ number_format($price) }}
                                                        </div>
                                                        <div class="single-product-kamand-item-bottom-header-price-regular-discount">
                                                            %{{ $discount }}
                                                        </div>
                                                    </div>
                                                    <div class="single-product-kamand-item-bottom-header-price-sales-off">
                                                        <div class="single-product-kamand-item-bottom-header-price-sales-off-shape"></div>
                                                        <span class="single-product-kamand-item-bottom-header-price-sales-off-number">
                                                            {{ number_format($final_price) }}
                                                        </span>
                                                        <span class="single-product-kamand-item-bottom-header-price-sales-off-symbol">تومان</span>
                                                    </div>
                                                @else
                                                    <div class="single-product-kamand-item-bottom-header-price-sales-off">
                                                        <div class="single-product-kamand-item-bottom-header-price-sales-off-shape"></div>
                                                        <span class="single-product-kamand-item-bottom-header-price-sales-off-number d-flex justify-content-end">
                                                            {{ number_format($price) }}
                                                        </span>
                                                        <span class="single-product-kamand-item-bottom-header-price-sales-off-symbol">تومان</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                هیچ محصولی در این دسته‌بندی یافت نشد.
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="my-paginate mt-5">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // تست ساده جاوااسکریپت
        console.log('جاوااسکریپت بارگذاری شد');

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM آماده است');

            // تست کلیک روی دکمه فیلتر برند
            const brandButton = document.querySelector('.filter-product-brand-buttom');
            if (brandButton) {
                console.log('دکمه برند پیدا شد');
                brandButton.addEventListener('click', function() {
                    console.log('دکمه برند کلیک شد');
                    this.classList.toggle('active');
                });
            } else {
                console.log('دکمه برند پیدا نشد');
            }

            // تست جستجو
            const searchInput = document.getElementById('brand-search-input');
            if (searchInput) {
                console.log('فیلد جستجو پیدا شد');
                searchInput.addEventListener('input', function() {
                    console.log('جستجو:', this.value);
                });
            } else {
                console.log('فیلد جستجو پیدا نشد');
            }
        });
    </script>
@endpush
