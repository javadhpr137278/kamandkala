
//========= start home slider =========///
var swiper = new Swiper("#homeSlider", {
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 5500,
        disableOnInteraction: false,
    },
    effect: "fade",
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

///=============end home slider ============/

//========= end product box ==============/

/**
 * image animation with tilt plugin
 */

$('.img-tilt').tilt({
    maxTilt: 10,
    perspective: 1000,   // Transform perspective, the lower the more extreme the tilt gets.
    easing: "cubic-bezier(0.250, 0.460, 0.450, 0.940)",    // Easing on enter/exit.
    speed: 500,    // Speed of the enter/exit transition.
    transition: true,   // Set a transition on enter/exit.
    disableAxis: null,   // What axis should be disabled. Can be X or Y.
    reset: true,   // If the tilt effect has to be reset on exit.
    glare: true,  // Enables glare effect
    maxGlare: 0.5      // From 0 - 1.
})





//=========== product gallery ===================//

var proSwiper = new Swiper(".product-gallery-thumb", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 3,
            spaceBetween: 10
        },
    },
});
var proThumbswiper = new Swiper(".product-gallery", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    zoom: {
        maxRatio: 3,
        minRatio: 1
    },
    thumbs: {
        swiper: proSwiper,
    },
});

//=========== end product gallery ===================//






