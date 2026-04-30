// remove mobile & desktop
$(document).ready(function (){
    if ($(window).width() < 993) {
        $('.desktop').remove();
    }
    if ($(window).width() > 992) {
        $('.mobile').remove();
    }
});
/*$('.m-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})*/
/*$('.product-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:5
        }
    }
})*/
/*$('.amazing-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:5
        }
    }
})*/
/*$('.special-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:false,
    rtl: true,
    navText : "",
    dots: true,
    dotsData:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})*/

/*$('.insta-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    rtl: true,
    navText : "",
    dots: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:6
        }
    }
})*/
/*$('.brand-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    dots: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:6
        }
    }
})*/
$('.related-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:5
        }
    }
})
$('.related-article-slider').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    rtl: true,
    navText : "",
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1200:{
            items:4
        }
    }
})

$('.insta-slider-single').owlCarousel({
    loop:true,
    margin:0,
    nav:false,
    rtl: true,
    navText : "",
    dots: false,
    responsive:{
        0:{
            items:1
        },
        576:{
            items:3
        },
        768:{
            items:4
        },
        992:{
            items:5
        }
    }
})
/***********timer Amazing***********/
$(document).ready(function (){
    function countdownTimer() {
        var countdownElements = document.querySelectorAll('.box-timer');
        countdownElements.forEach(function (countdownElement) {
            var daysElements = countdownElement.querySelectorAll('.days-value');
            var hoursElements = countdownElement.querySelectorAll('.hours-value');
            var minutesElements = countdownElement.querySelectorAll('.minutes-value');
            var secondsElements = countdownElement.querySelectorAll('.seconds-value');
            var messageElement = countdownElement.querySelector('.timer-message');
            var messagesElement = countdownElement.querySelector('.massages-heddin');
            var targetYear = parseInt(countdownElement.dataset.targetYear);
            var targetMonth = parseInt(countdownElement.dataset.targetMonth) - 1;
            var targetDay = parseInt(countdownElement.dataset.targetDay);
            var targetHour = parseInt(countdownElement.dataset.targetHour);
            var targetMinute = parseInt(countdownElement.dataset.targetMinute);
            var targetSecond = parseInt(countdownElement.dataset.targetSecond);
            var targetDate = new Date(targetYear, targetMonth, targetDay, targetHour, targetMinute, targetSecond);

            function updateTimer() {
                var now = new Date().getTime();
                var timeRemaining = targetDate - now;
                var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                for (var i = 0; i < daysElements.length; i++) {
                    daysElements[i].innerHTML = days;
                }
                for (var i = 0; i < hoursElements.length; i++) {
                    hoursElements[i].innerHTML = hours;
                }
                for (var i = 0; i < minutesElements.length; i++) {
                    minutesElements[i].innerHTML = minutes;
                }
                for (var i = 0; i < secondsElements.length; i++) {
                    secondsElements[i].innerHTML = seconds;
                }
                if (timeRemaining > 0) {
                    setTimeout(updateTimer, 1000);
                } else {
                    messagesElement.style.display = 'none';
                    /*messageElement.style.display = 'block';
                    var messageTextElement = messageElement.querySelector('.timer-message-text');
                    messageTextElement.innerHTML = 'تایمر به پایان رسیده است';*/
                }
            }

            updateTimer();
        });
    }
    countdownTimer();
});

// end modal login
$('.message a').click(function(){
    $('.form-login-shahan form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

// start modal-login
$(document).ready(function (){
    var modal_login = document.getElementById("modal_login");
// Get the button that opens the modal
    var btn_modal_login = document.getElementById("btn_modal_login");
// Get the <span> element that closes the modal
    var close_login = document.getElementsByClassName("close_login")[0];
// When the user clicks the button, open the modal
    btn_modal_login.onclick = function() {
        modal_login.style.display = "block";
    }
// When the user clicks on <span> (x), close the modal
    close_login.onclick = function() {
        modal_login.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal_login) {
            modal_login.style.display = "none";
        }
    }

})

// start modal-video
$(document).ready(function (){
    var modal_video = document.getElementById("modal_video");
    var btn_modal_video = document.getElementById("btn_modal_video");
    var close_video = document.getElementsByClassName("close_video")[0];
    btn_modal_video.onclick = function() {
        modal_video.style.display = "block";
    }
    close_video.onclick = function() {
        modal_video.style.display = "none";
    }
})

// start modal-share
$(document).ready(function (){
    var modal_share = document.getElementById("modal_share");
    var btn_modal_share = document.getElementById("btn_modal_share");
    var close_share = document.getElementsByClassName("close_share")[0];
    btn_modal_share.onclick = function() {
        modal_share.style.display = "block";
    }
    close_share.onclick = function() {
        modal_share.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal_video || event.target == modal_login || event.target == modal_share) {
            modal_video.style.display = "none";
            modal_login.style.display = "none";
            modal_share.style.display = "none";
        }
    }
})


/************quantity number plus and minus************/
$(document).on( 'click', 'button.plus, button.minus', function() {
    var qty = $( this ).parent( '.quantity' ).find( '.qty' );
    var val = parseFloat(qty.val());
    var max = parseFloat(qty.attr( 'max' ));
    var min = parseFloat(qty.attr( 'min' ));
    var step = parseFloat(qty.attr( 'step' ));
    if ( $( this ).is( '.plus' ) ) {
        if ( max && ( max <= val ) ) {
            qty.val( max ).change();
        } else {
            qty.val( val + step ).change();
        }
    } else {
        if ( min && ( min >= val ) ) {
            qty.val( min ).change();
        } else if ( val > 1 ) {
            qty.val( val - step ).change();
        }
    }
});


$(document).ready(function () {
    $('.floating-button i').click(function () {
        $('.contact-list').slideToggle();
        if ($(this).hasClass('fa-comment-dots')) {
            $(this).removeClass('fa-comment-dots').addClass('fa-multiply');
            $(this).css({
                'transform' : 'rotate(180deg)',
            })
        }
        else {
            $(this).removeClass('fa-multiply').addClass('fa-comment-dots');
            $(this).css({
                'transform' : 'rotate(0deg)',
            })
        }
    })
})

// scrollup
$("#scrollup").click(function () {
    $('html').animate({scrollTop:0}, 1000);
})

$(".addtocart_button a.product_type_simple").click(function () {
    $(this).css({
        'transform':'rotate(1080deg)',
    })
    $('#modal_add_to_cart').delay(1000).fadeIn();
    $('#modal_add_to_cart').delay(1000).fadeOut();
})
$(".add-to-cart a.product_type_simple").click(function () {
    $('#modal_add_to_cart').delay(1000).fadeIn();
    $('#modal_add_to_cart').delay(1000).fadeOut();
})

$(document).ready(function () {
    $('.search-main').click(function () {
        $('.overlay').addClass('show');
        // searchbox-two
        $('.searchbox-two form').slideDown();
        $('.search-input').focus();
    })
})
$(document).click(function (e) {
    $('.content-ajax-search').removeClass('show');
    $('.loader-ajax-search').removeClass('show');

    if (!$(e.target).closest('.search-main').length) {
        $('.overlay').removeClass('show');
        // searchbox-two
        $('.searchbox-two form').slideUp();
    }
});

// width-submenu
$(document).ready(function (){
    var cnt = $(".container").width();
    $(".shahan-megamenu > ul > li > ul").innerWidth(cnt - 230),
    $(".header-two .shahan-megamenu > ul > li > ul").innerWidth(cnt - 400),
        $(window).resize(function () {
            var rcnt = $(".container").width();
            $(".shahan-megamenu > ul > li > ul").innerWidth(rcnt - 230);
            $(".header-two .shahan-megamenu > ul > li > ul").innerWidth(rcnt - 400);
        });
});
$(document).ready(function (){
    var owl = $(".special-slider .owl-stage-outer").width();
    $(".special-slider .special-item").innerWidth(owl),
        $(window).resize(function () {
            var stage = $(".special-slider .owl-stage-outer").width();
            $(".special-slider .special-item").innerWidth(stage);
        });
});

// side-shop
$(document).ready(function () {
    $('.filter-shop').click(function () {
        $('.side-single-shop').css({
            'transform' : 'translateX(0px)'
        });
        $('.close-menu-responsive-full-page').css({
            'transform' : 'translateX(0px)'
        });
    });

    $('.close-menu-responsive-full-page').click(function () {
        $('.side-single-shop').css({
            'transform' : 'translateX(1000px)'
        });
        $('.close-menu-responsive-full-page').css({
            'transform' : 'translateX(1000px)'
        });
        $('.navigation').css({
            'transform' : 'translateX(1000px)'
        });
    });
})

$(document).ready(function () {
    $('.navigation ul.sub-menu').before("<i class='sub-menu-arrow fa fa-angle-down'></i>");
    $('.shahan-megamenu > ul > li > ul.sub-menu').before("<i class='sub-menu-arrow fa fa-angle-left'></i>");

    $('#hamberger').click(function () {
        $('.navigation').css({
            'transform' : 'translateX(0px)'
        });
        $('.close-menu-responsive-full-page').css({
            'transform' : 'translateX(0px)'
        });
    });

    $('.navigation i.sub-menu-arrow').click(function () {
        if ($(this).hasClass("fa-angle-down")) {
            $(this).next("ul.sub-menu").slideDown();
            $(this).removeClass("fa-angle-down").addClass("fa-angle-up");
        }
        else {
            $(this).next("ul.sub-menu").slideUp(500);
            $(this).removeClass("fa-angle-up").addClass("fa-angle-down");
        }

    });
});

// sticky-header
$(document).ready(function () {
    $(window).scroll(function (){
        if ($(window).scrollTop() > 100) {
            $(".header-mobile").addClass('header-sticky');
        } else {
            $(".header-mobile").removeClass('header-sticky');
        }
    })
});

$(document).ready(function () {
    $('.search-menu-bottom-mobile').click(function () {
        $('.search-mobile').slideDown();
        $('.search-input').focus();
    });
    $('#close_search_mobile').click(function () {
        $('.search-mobile').fadeOut();
    });
});