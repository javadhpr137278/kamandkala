@forelse($cartItems as $item)
    <div class="cart-mini-detail-product" data-cart-id="{{ $item->id }}">
        <div class="cart-mini-detail-image-product">
            <div class="remove-item" data-id="{{ $item->id }}">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L13 13M13 1L1 13" stroke="white" stroke-width="2"
                          stroke-linecap="round"></path>
                </svg>
            </div>
            <img src="{{ asset('storage/products/' . $item->product->image) }}"
                 alt="{{ $item->product->title }}">
        </div>
        <a href="{{ route('single.product', $item->product->slug) }}"
           class="cart-mini-product-details">
            <h5>
                {{ $item->product->title }}
            </h5>
            <div class="cart-mini-detail-product-underline"></div>
            <div class="cart-mini-detail-product-meta">
                <div class="cart-mini-detail-quantity">
                    <button class="plus mini-cart-plus" data-id="{{ $item->id }}">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 10V6M6 6V2M6 6H10M6 6H2" stroke="#1D2977"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <input type="text" class="mini-cart-quantity"
                           data-id="{{ $item->id }}"
                           value="{{ $item->quantity }}" min="1"
                           max="{{ $item->productVariant->stock ?? 10 }}" readonly>
                    <button class="mines mini-cart-minus" data-id="{{ $item->id }}">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 6H2" stroke="#1D2977" stroke-opacity="0.5"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
                <div class="cart-mini-detail-amount">
                    <div class="price-regular">
                        <span>تــــو مان</span>
                        <span>{{ number_format($item->price * $item->quantity) }}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="cart-mini-empty">
        <p class="text-center py-4">سبد خرید شما خالی است</p>
    </div>
@endforelse
