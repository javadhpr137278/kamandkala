<div class="single-product-kamand-item-bottom">
    <div class="single-product-kamand-item-bottom-header">
        <div class="single-product-kamand-item-bottom-header-name">
            <div class="single-product-kamand-item-bottom-header-category">
                <a href="{{ route('categories.show', $product->category->slug) }}" target="_blank" rel="follow" class="single-product-kamand-item-bottom-header-category-name">
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
                    <span>موجود در انبار</span>
                </div>
            </div>
            <a href="{{ route('product.show', $product->slug) }}" class="single-product-kamand-item-bottom-header-name-title">{{ $product->title }}</a>
        </div>
        <div class="underline-kamand">
            <div class="underline-kamand-line"></div>
            <div class="underline-kamand-circle"></div>
        </div>
        <div class="single-product-kamand-item-bottom-header-price" data-product-id="{{ $product->id }}">
            @if($product->discount > 0)
                <div class="single-product-kamand-item-bottom-header-price-regular">
                    <div class="single-product-kamand-item-bottom-header-price-regular-number">
                        {{ number_format($product->price) }}
                    </div>
                    <div class="single-product-kamand-item-bottom-header-price-regular-discount">
                        %{{ $product->discount }}
                    </div>
                </div>
                <div class="single-product-kamand-item-bottom-header-price-sales-off">
                    <div class="single-product-kamand-item-bottom-header-price-sales-off-shape"></div>
                    <span class="single-product-kamand-item-bottom-header-price-sales-off-number">
                    {{ number_format($product->price * (100 - $product->discount) / 100) }}
                </span>
                    <span class="single-product-kamand-item-bottom-header-price-sales-off-symbol">تومان</span>
                </div>
            @else
                <div class="single-product-kamand-item-bottom-header-price-sales-off">
                    <div class="single-product-kamand-item-bottom-header-price-sales-off-shape"></div>
                    <span class="single-product-kamand-item-bottom-header-price-sales-off-number">
                    {{ number_format($product->price) }}
                </span>
                    <span class="single-product-kamand-item-bottom-header-price-sales-off-symbol">تومان</span>
                </div>
            @endif
        </div>
        <div class="underline-kamand">
            <div class="underline-kamand-line"></div>
            <div class="underline-kamand-circle"></div>
        </div>
    </div>
    <div class="single-product-kamand-item-bottom-content">
        <div class="single-product-kamand-item-bottom-content-img">
            <img decoding="async" src="{{url('home/assets/img/bb7f73a9cf8f176d0c59d17f25b009f126d2719a.jpg')}}" alt="">
        </div>
        <span><strong>{{ $product->sold }}+ </strong> نفر از این محصول خرید کرده‌اند</span>
    </div>
</div>
