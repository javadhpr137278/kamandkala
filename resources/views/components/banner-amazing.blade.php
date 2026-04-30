<div class="banner-amazing-shape"></div>

<div class="banner-amazing-image">
    <img decoding="async"
         src="{{ $banner? asset('storage/'.$banner->image) : '' }}"
         alt="{{ $banner->title ?? '' }}">

    <div class="banner-amazing-image-circle"></div>
</div>



<div class="banner-amazing-content">

    <div class="banner-amazing-content-right">

        <div class="banner-amazing-content-right-board">
            <div class="banner-amazing-content-right-board-line-one"></div>

            <div class="banner-amazing-content-right-board-text">
                <span>
                    <strong>{{ $banner->discount_percent ?? 0 }}%</strong>
                    تخفیف
                </span>
            </div>

            <div class="banner-amazing-content-right-board-line-two"></div>
        </div>


        <span class="banner-amazing-content-right-title">
            {{ $banner->title }}
        </span>

        <span class="banner-amazing-content-right-subtitle">
            <strong>{{ $banner->start_date }}</strong>
            الی
            <strong>{{ $banner->end_date }}</strong>
        </span>

        <div class="banner-amazing-content-right-shape"></div>

    </div>


    <div class="banner-amazing-content-left">

        <div class="banner-amazing-content-left-header">

            <p class="banner-amazing-content-left-header-title">
                {{ $banner->festival_title }}
            </p>

            <p class="banner-amazing-content-left-header-subtitle">
                {!! $banner->festival_description !!}
            </p>

        </div>


        <div class="banner-amazing-content-left-bottom">

            <a href="{{ $banner->button_link }}">
                <span>{{ $banner->button_text }}</span>

                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.0747 11.4906C19.9404 11.625 19.7565 11.7098 19.5444 11.7098L11.7096 11.7098L11.7096 19.5446C11.7096 19.9547 11.3702 20.2941 10.9601 20.2941C10.55 20.2941 10.2106 19.9547 10.2106 19.5446L10.2106 10.9603C10.2106 10.5502 10.55 10.2108 10.9601 10.2108L19.5444 10.2108C19.9545 10.2108 20.2939 10.5502 20.2939 10.9603C20.301 11.1654 20.2091 11.3563 20.0747 11.4906Z" fill="#1D2977"></path>
                    <path d="M23.5111 23.5115C23.2212 23.8014 22.7404 23.8014 22.4505 23.5115L10.5499 11.6109C10.2599 11.321 10.2599 10.8402 10.5499 10.5502C10.8398 10.2603 11.3206 10.2603 11.6105 10.5502L23.5111 22.4508C23.801 22.7408 23.801 23.2216 23.5111 23.5115Z" fill="#1D2977"></path>
                </svg>

            </a>

        </div>

    </div>

</div>



<div class="banner-amazing-counter"
     data-countdown="{{ $banner->countdown_end }}">
</div>
