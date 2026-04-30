var proSwiper = new Swiper(".product-gallery-thumb", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
        320: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        768: {
            slidesPerView: 4
        }
    }
});

var proThumbswiper = new Swiper(".product-gallery", {
    spaceBetween: 10,
    zoom: {
        maxRatio: 3,
        minRatio: 1
    },
    navigation: {
        nextEl: ".product-gallery .swiper-button-next",
        prevEl: ".product-gallery .swiper-button-prev",
    },
    pagination: {
        el: ".product-gallery .swiper-pagination",
        clickable: true,
    },
    thumbs: {
        swiper: proSwiper,
    },
});
