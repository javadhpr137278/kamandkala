
<div class="body-categories-main">
    @foreach($categories as $index => $category)
        <div class="body-categories-main-item {{ $loop->first ? 'active' : '' }}">
            <div class="rectangle-categories-main-item"></div>

            {{-- نمایش شماره با فرمت 01، 02 و ... --}}
            <span class="counter-categories-main-item">
                {{ sprintf('%02d', $loop->iteration) }}
            </span>

            <div class="line-categories-main-item"></div>
            <span class="name-categories-main-item">{{ $category->title }}</span>

            <div class="content-categories-main-item">
                <div class="top-content-categories-main-item">
                    <div class="title-category-main">
                        <div class="shape-category-main"></div>
                        <a href="{{ route('home.category.show', $category->slug) }}" class="subtitle-category-main">
                            {{ $category->title }}
                        </a>
                        <div class="counter-product-category-main">
                            <span>
                                {{ $category->products->count() }} محصول موجود است.
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('home.category.show', $category->slug) }}" class="button-show-categories">
                        <svg width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.6216 14.1066C23.4648 14.2633 23.2504 14.3623 23.0029 14.3623L13.8623 14.3623L13.8623 23.5029C13.8623 23.9813 13.4664 24.3773 12.9879 24.3773C12.5094 24.3773 12.1134 23.9813 12.1134 23.5029L12.1134 13.4879C12.1134 13.0094 12.5094 12.6134 12.9879 12.6134L23.0029 12.6134C23.4813 12.6134 23.8773 13.0094 23.8773 13.4879C23.8856 13.7271 23.7783 13.9498 23.6216 14.1066Z" fill="#1D2977"></path>
                            <path d="M27.6308 28.1308C27.2926 28.469 26.7316 28.469 26.3934 28.1308L12.5093 14.2468C12.1711 13.9085 12.1711 13.3476 12.5093 13.0093C12.8476 12.6711 13.4085 12.6711 13.7468 13.0093L27.6308 26.8934C27.9691 27.2316 27.9691 27.7926 27.6308 28.1308Z" fill="#1D2977"></path>
                        </svg>
                    </a>
                </div>

                <div class="bottom-content-categories-main-item">
                    {{-- فرض بر این است که فیلد تصویر در مدل داری --}}
                    <img decoding="async" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}">

                    <div class="circle-one-bottom-content-categories-main-item"></div>
                    <div class="circle-two-bottom-content-categories-main-item"></div>
                    <div class="circle-three-bottom-content-categories-main-item">
                        {{-- SVG تزئینی --}}
                        <svg width="51" height="49" viewBox="0 0 51 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                            {{-- ... (بقیه کدهای SVG شما) ... --}}
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

