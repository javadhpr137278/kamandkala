jQuery(document).ready(function($) {

    // تابع بارگذاری مجدد مینی کارت
    function reloadMiniCart() {
        $.ajax({
            url: '/cart/mini',
            type: 'GET',
            success: function(response) {
                if(response.html) {
                    $('.cart-mini-products').html(response.html);
                }
                updateCartTotals();
            },
            error: function() {
                console.log('خطا در بارگذاری مینی کارت');
            }
        });
    }

    // تابع بروزرسانی مقادیر سبد خرید
    function updateCartTotals() {
        $.ajax({
            url: '/cart/totals',
            type: 'GET',
            success: function(response) {
                $('.cart-count-badge').text(response.count);
                $('.cart-total-amount').text(response.total + ' تومان');
                $('.mini-cart-total, .price-header-bottom-left-cart-popup').text(response.total);
                $('#cart-subtotal, #cart-total').text(response.total);
            },
            error: function() {
                console.log('خطا در دریافت مقادیر سبد خرید');
            }
        });
    }

    // بروزرسانی تعداد
    function updateQuantity(cartId, quantity) {
        $.ajax({
            url: '/cart/update-mini/' + cartId,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({ quantity: quantity }),
            contentType: 'application/json',
            success: function(response) {
                if(response.success) {
                    $('.cart-mini-products').html(response.html);
                    updateCartTotals();
                } else {
                    alert(response.message || 'خطا در بروزرسانی');
                    reloadMiniCart();
                }
            },
            error: function(xhr) {
                let message = 'خطا در بروزرسانی';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                alert(message);
                reloadMiniCart();
            }
        });
    }

    // حذف از سبد خرید
    function removeFromCart(cartId) {
        if(confirm('آیا از حذف این محصول اطمینان دارید؟')) {
            $.ajax({
                url: '/cart/remove-mini/' + cartId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        $('.cart-mini-products').html(response.html);
                        updateCartTotals();
                    }
                },
                error: function() {
                    alert('خطا در حذف محصول');
                }
            });
        }
    }

    // رویدادها با event delegation
    $(document).on('click', '.mini-cart-plus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let input = $(this).siblings('.mini-cart-quantity');
        let currentVal = parseInt(input.val());
        let max = parseInt(input.attr('max'));
        let newVal = currentVal + 1;

        if(newVal <= max) {
            updateQuantity(id, newVal);
        } else {
            alert('تعداد وارد شده بیشتر از موجودی انبار است');
        }
    });

    $(document).on('click', '.mini-cart-minus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let input = $(this).siblings('.mini-cart-quantity');
        let currentVal = parseInt(input.val());
        let newVal = currentVal - 1;

        if(newVal >= 1) {
            updateQuantity(id, newVal);
        }
    });

    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        removeFromCart(id);
    });

    // باز و بسته شدن پاپ آپ
    $('.header-bottom-left-cart-icon, .header-bottom-left-cart-data').on('click', function(e) {
        e.preventDefault();
        $('.header-bottom-left-cart-popup, .overly-header-bottom-left-cart-popup').toggleClass('active');

        if($('.header-bottom-left-cart-popup').hasClass('active')) {
            reloadMiniCart();
        }
    });

    $('.overly-header-bottom-left-cart-popup').on('click', function() {
        $('.header-bottom-left-cart-popup, .overly-header-bottom-left-cart-popup').removeClass('active');
    });

    // بارگذاری اولیه مقادیر
    updateCartTotals();
});
