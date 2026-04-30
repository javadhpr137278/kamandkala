$(document).ready(function () {
    // ====================== Mega Menu (نسخه ساده و مطمئن) ======================
    function initMegaMenu() {
        $(".mega-menu-trigger").each(function () {
            const $trigger = $(this);
            const $link = $trigger.find("> a");
            const $menu = $trigger.find(".mega-menu");

            let hoverTimer;

            // تابع نمایش منو
            function showMenu() {
                clearTimeout(hoverTimer);
                $trigger.addClass("active");
            }

            // تابع مخفی کردن منو
            function hideMenu() {
                clearTimeout(hoverTimer);
                hoverTimer = setTimeout(() => {
                    $trigger.removeClass("active");
                }, 200);
            }

            // رویداد هاور روی لینک
            $link.on("mouseenter", showMenu);
            $link.on("mouseleave", hideMenu);

            // رویداد هاور روی منو
            $menu.on("mouseenter", showMenu);
            $menu.on("mouseleave", hideMenu);
        });
    }

    // مقداردهی اولیه مگامنو
    initMegaMenu();

    // اطمینان از بسته شدن منوها بعد از لود صفحه
    $(window).on("load", function () {
        setTimeout(() => {
            $(".mega-menu-trigger").removeClass("active");
        }, 100);
    });

    // بستن منو هنگام کلیک خارج از آن
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".mega-menu-trigger").length) {
            $(".mega-menu-trigger").removeClass("active");
        }
    });

    // بستن منو هنگام اسکرول
    $(window).on("scroll", function () {
        $(".mega-menu-trigger").removeClass("active");
    });

    // ====================== Sidebar Tabs ======================
    const $sidebarTabs = $(".navbar-sidebar-responsive-tab ul li");
    const $sidebarPanels = $(".navbar-sidebar-responsive-content-item");

    function activateSidebarTab($tab) {
        const targetId = $tab.data("tab-navbar");
        const $targetPanel = $("#" + targetId);
        if (!$targetPanel.length) return;

        $sidebarTabs.removeClass("active");
        $sidebarPanels.removeClass("active");
        $tab.addClass("active");
        $targetPanel.addClass("active");
    }

    $sidebarTabs.on("click", function (e) {
        e.preventDefault();
        activateSidebarTab($(this));
    });

    if ($sidebarTabs.length && $sidebarPanels.length) {
        activateSidebarTab($sidebarTabs.first());
    }

    // ====================== My Account Dropdown ======================
    const $signupTop = $(".my-account-header-name");

    if ($signupTop.length) {
        $signupTop.on("mouseenter", function () {
            $(this).addClass("active");
        });

        $(document).on("click", function (e) {
            if (!$signupTop.is(e.target) && $signupTop.has(e.target).length === 0) {
                $signupTop.removeClass("active");
            }
        });
    }

    // ====================== Navbar Toggle ======================
    const $navbarToggle = $(".navbar-toggle svg");
    const $navbarBtnClose = $(".close-navbar-toggle");
    const $navbarOverly = $(".navbar-toggle-overly");
    const $navbarResult = $(".navbar-toggle-result");

    if ($navbarToggle.length && $navbarBtnClose.length) {
        $navbarToggle.on("click", function () {
            $(this).toggleClass("active");
        });

        $navbarBtnClose.on("click", function () {
            $navbarToggle.toggleClass("active");
        });

        $navbarOverly.on("click", function () {
            $navbarToggle.toggleClass("active");
        });

        $(window).on("scroll", function () {
            if ($(window).scrollTop() >= 65) {
                $navbarOverly.css("top", "0px");
                $navbarResult.css("top", "20px");
            } else {
                $navbarOverly.css("top", "90px");
                $navbarResult.css("top", "122px");
            }
        });
    }

    // ====================== Responsive Mega Menu Tabs ======================
    $(".mega-menu-responsive").each(function () {
        const $container = $(this);
        const $tabs = $container.find(".mega-menu-tab-item-responsive");
        const $panels = $container.find(".mega-menu-content-responsive");

        $tabs.on("click", function () {
            const panelId = $(this).data("tab-responsive");
            $tabs.removeClass("active");
            $panels.removeClass("active");
            $(this).addClass("active");
            $("#" + CSS.escape(panelId)).addClass("active");
        });

        if ($tabs.length) {
            $tabs.first().trigger("click");
        }
    });

    // ====================== Mega Menu Tabs (Desktop) ======================
    const $megaTabs = $(".mega-menu-tab-item");
    const $megaPanels = $(".mega-menu-content-item");

    $megaTabs.on("mouseenter", function () {
        const targetId = $(this).data("tab");
        $megaTabs.removeClass("active");
        $megaPanels.removeClass("active");
        $(this).addClass("active");
        $("#" + targetId).addClass("active");
    });

    if ($megaTabs.length) {
        $megaTabs.first().trigger("mouseenter");
    }

    // ====================== Sale Products Circles ======================
    $(".sale-products-card-circle-color span").each(function (index, el) {
        const $circles = $(".sale-products-card-circle-color span");
        $(el).css("z-index", $circles.length - index);
    });

    // ====================== Swiper Sliders ======================
    if (typeof Swiper !== 'undefined') {
        new Swiper(".sale-products-body-bottom", {
            loop: true,
            navigation: {
                nextEl: ".sale-products-body-bottom-right",
                prevEl: ".sale-products-body-bottom-left",
            },
            breakpoints: {
                640: {slidesPerView: 1},
                768: {slidesPerView: 1},
                1024: {slidesPerView: 3},
            },
        });

        new Swiper(".review-wrapper-center-content .swiper", {
            loop: true,
            autoplay: {delay: 6000, disableOnInteraction: false},
            navigation: {
                nextEl: ".review-wrapper-center-pagination-right",
                prevEl: ".review-wrapper-center-pagination-left",
            },
        });
    }

    // ====================== Main Slider Product ======================
    function initSlider($tabContainer) {
        const $cards = $tabContainer.find(".slider-product-card");
        const $prevBtn = $tabContainer.find(".slider-product-prev");
        const $nextBtn = $tabContainer.find(".slider-product-next");
        const $detailCard = $tabContainer.find(".slider-product-main-wrapper");

        if (!$cards.length || !$detailCard.length) return;

        let currentIndex = 0;

        function formatPrice(number) {
            return new Intl.NumberFormat("fa-IR").format(number);
        }

        function updateDetailCard($card) {
            if (!$card.length) return;

            $detailCard.find(".product-title").text($card.data("title") || "");
            $detailCard.find(".product-link").attr("href", $card.data("link") || "#");
            $detailCard.find(".slider-product-main-wrapper-header-left-add-to-cart-button a").attr("href", $card.data("link") || "#");

            const $image = $detailCard.find(".product-image");
            if ($image.length && $card.find("img").length) {
                $image.attr("src", $card.find("img").attr("src"));
                $image.attr("alt", $card.data("title") || "");
            }

            $detailCard.find(".product-regular").text(formatPrice($card.data("price") || 0));
            $detailCard.find(".product-sale").text(formatPrice($card.data("sale-price") || 0));
            const discount = $card.data("discount") || 0;
            $detailCard.find(".product-discount-percent").text(discount ? `%${discount}` : "");

            const $shareBtn = $detailCard.find(".slider-product-main-wrapper-header-left-add-to-cart-share .product-share-btn");
            const $wishlistBtn = $detailCard.find(".slider-product-main-wrapper-header-left-add-to-cart-share .wishlist-btn");

            if ($shareBtn.length) {
                $shareBtn.data("product-title", $card.data("title") || "");
                $shareBtn.data("product-url", $card.data("link") || "#");
            }

            if ($wishlistBtn.length) {
                const productId = $card.data("id") || $card.attr("data-id") || "";
                $wishlistBtn.data("product-id", productId);
                if ($card.data("is-favorite") === "1") {
                    $wishlistBtn.addClass("active");
                } else {
                    $wishlistBtn.removeClass("active");
                }
            }

            $detailCard.find(".product-reviews").text($card.data("reviews") ? `(${$card.data("reviews")} نظر)` : "");

            const $starsEl = $detailCard.find(".slider-product-main-wrapper-header-left-review-stars");
            if ($starsEl.length) {
                $starsEl.empty();
                const rating = parseFloat($card.data("rating") || 0);
                for (let i = 1; i <= 5; i++) {
                    const starClass = i <= Math.round(rating) ? "active" : "inactive";
                    $starsEl.append(`<span class="fa fa-star ${starClass}"></span>`);
                }
            }

            $detailCard.find(".product-discount").text($card.data("badge") || "");

            const sold = parseInt($card.data("sold") || 0);
            const remaining = parseInt($card.data("remaining") || 0);
            const total = sold + remaining;
            const soldPercent = total > 0 ? (sold / total) * 100 : 0;

            $detailCard.find(".slider-product-main-wrapper-header-left-counter-progressbar").css("width", soldPercent + "%");
            $detailCard.find(".slider-product-main-wrapper-header-left-counter-progressbar-head span:first-child b").text(sold);
            $detailCard.find(".slider-product-main-wrapper-header-left-counter-progressbar-head span:last-child b").text(remaining);

            const $galleryContainer = $detailCard.find(".slider-product-main-wrapper-body");
            if ($galleryContainer.length) {
                $galleryContainer.empty();
                try {
                    const images = JSON.parse($card.data("gallery"));
                    images.slice(0, 5).forEach((img) => {
                        $galleryContainer.append(`<div><img src="${img}" alt="${$card.data("title") || "Product image"}"></div>`);
                    });
                } catch (e) {
                    $galleryContainer.append(`<div><img src="${$card.find("img").attr("src")}" alt="${$card.data("title") || "Product image"}"></div>`);
                }
            }
        }

        function updateSlider() {
            $cards.removeClass("active").hide();

            const isMobile = $(window).width() <= 768;

            if (isMobile) {
                if ($cards.eq(currentIndex).length) {
                    $cards.eq(currentIndex).show().addClass("active");
                    updateDetailCard($cards.eq(currentIndex));
                }
                return;
            }

            if (currentIndex - 1 >= 0) $cards.eq(currentIndex - 1).show();
            if ($cards.eq(currentIndex).length) {
                $cards.eq(currentIndex).show().addClass("active");
                updateDetailCard($cards.eq(currentIndex));
            }
            if (currentIndex + 1 < $cards.length) $cards.eq(currentIndex + 1).show();

            if (currentIndex === 0 && $cards.length > 2) $cards.eq(2).show();
            if (currentIndex === $cards.length - 1 && $cards.length > 2) $cards.eq($cards.length - 3).show();

            updateDetailCard($cards.eq(currentIndex));
        }

        $prevBtn.on("click", function () {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : $cards.length - 1;
            updateSlider();
        });

        $nextBtn.on("click", function () {
            currentIndex = currentIndex < $cards.length - 1 ? currentIndex + 1 : 0;
            updateSlider();
        });

        $cards.on("click", function () {
            currentIndex = $cards.index($(this));
            updateSlider();
        });

        updateSlider();
    }

    $(".slider-product-main").each(function () {
        initSlider($(this));
    });

    // Tab Management for Sliders
    const $sliderTabs = $(".slider-product-head-tab-item");
    const $sliderContents = $(".slider-product-main");

    function showSliderTab($tab) {
        const targetId = $tab.data("tab-product");
        $sliderContents.css({
            opacity: 0,
            visibility: "hidden",
            position: "absolute",
            top: "150px"
        });
        $("#" + targetId).css({
            opacity: 1,
            visibility: "visible",
            position: "absolute",
            top: "100px"
        });
        $sliderTabs.removeClass("active");
        $tab.addClass("active");
    }

    $sliderTabs.on("click", function () {
        showSliderTab($(this));
    });

    const $activeTab = $(".slider-product-head-tab-item.active");
    if ($activeTab.length) showSliderTab($activeTab);

    // ====================== Footer More Description ======================
    $(document).on("click", ".more-description", function (e) {
        const $btn = $(this);
        const $p = $btn.closest(".footer-body-top-section-two-about-description").find("p");
        const expanded = $p.hasClass("expanded");
        $p.toggleClass("expanded");
        $btn.attr("aria-expanded", !expanded);
        $btn.text(expanded ? "مشاهده بیشتر …" : "مشاهده کمتر");
    });

    // ====================== Wishlist Function ======================
    window.loginBeforeWhishlist = function () {
        if (typeof Swal !== 'undefined') {
            Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            }).fire({
                icon: "info",
                title: wc_ajax_obj?.title_whishlist || "لطفاً ابتدا وارد حساب کاربری خود شوید",
            });
        }
    };

    $(".lamkadeh-wishlist-btn, .wishlist-product").on("click", function () {
        const $btn = $(this);
        const productId = $btn.data("product-id") || $btn.attr("data-product-id");

        if (!productId) {
            window.loginBeforeWhishlist();
            return;
        }

        $.ajax({
            url: wc_ajax_obj?.ajax_url || "",
            method: "POST",
            data: {
                action: "toggle_wishlist",
                product_id: productId,
                security: wc_ajax_obj?.nonce || ""
            },
            success: function (response) {
                if (response.success) {
                    if (response.data.added) {
                        $btn.addClass("active");
                        showToast("success", wc_ajax_obj?.add_whishlist || "محصول به علاقه‌مندی‌ها اضافه شد");
                    } else {
                        $btn.removeClass("active");
                        showToast("info", wc_ajax_obj?.remove_whishlist || "محصول از علاقه‌مندی‌ها حذف شد");
                    }
                } else {
                    showToast("error", wc_ajax_obj?.error_whishlist || "خطا در انجام عملیات");
                }
            },
            error: function () {
                showToast("error", "خطا در ارتباط با سرور");
            }
        });
    });

    // ====================== Share Product ======================
    function showToast(icon, title) {
        if (typeof Swal !== 'undefined') {
            Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            }).fire({icon: icon, title: title});
        } else {
            alert(title);
        }
    }

    function copyToClipboard(text) {
        const $textarea = $("<textarea>").val(text).css({position: "fixed", opacity: 0}).appendTo("body");
        $textarea.select();
        document.execCommand("copy");
        $textarea.remove();
    }

    async function shareProduct(url, title) {
        if (navigator.share) {
            try {
                await navigator.share({title: title, url: url});
            } catch (err) {
                console.log("اشتراک‌گذاری لغو شد");
            }
        } else {
            copyToClipboard(url);
            showToast("success", "لینک با موفقیت کپی شد");
        }
    }

    $(".share-product, .product-share-btn, #share-single-blog, .shareProductBtn, .shareProductBtnTwo").on("click", async function () {
        const $btn = $(this);
        const url = $btn.data("product-url") || $btn.data("url") || window.location.href;
        const title = $btn.data("product-title") || document.title;
        await shareProduct(url, title);
    });

    // ====================== Cart Counter ======================
    $(document).on("click", ".cart-counter-plus", function () {
        const $wrapper = $(this).closest(".cart-counter-product");
        const $input = $wrapper.find(".number-input-cart");
        let value = parseInt($input.val()) || 0;
        const max = parseInt($input.attr("max")) || 500;
        if (value < max) $input.val(value + 1);
    });

    $(document).on("click", ".cart-counter-mines", function () {
        const $wrapper = $(this).closest(".cart-counter-product");
        const $input = $wrapper.find(".number-input-cart");
        let value = parseInt($input.val()) || 1;
        const min = parseInt($input.attr("min")) || 1;
        if (value > min) $input.val(value - 1);
    });

    $(document).on("change", ".number-input-cart", function () {
        let v = parseInt($(this).val()) || 1;
        const min = parseInt($(this).attr("min")) || 1;
        const max = parseInt($(this).attr("max")) || 500;
        if (v < min) $(this).val(min);
        if (v > max) $(this).val(max);
    });

    // ====================== Product Brands List ======================
    $(".product-brands-list-left-header-item").on("click", function () {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
    });

    // ====================== Footer Title Styling ======================
    $(".footer-body-top-section-one-list-title.footer-head-title-nav span").each(function () {
        let text = $(this).text().trim();
        if (!text) return;
        let parts = text.split(/\s+/);
        if (parts.length > 1) {
            let lastWord = parts.pop();
            $(this).html(parts.join(" ") + " <strong>" + lastWord + "</strong>");
        } else {
            $(this).html("<strong>" + text + "</strong>");
        }
    });

    // ====================== Archive Content Height ======================
    const $archiveItems = $(".product-archive-content-item");
    const count = $archiveItems.length;
    if (count <= 4) {
        $("<style>.product-archive .product-archive-content::after { height: 580px !important; }</style>").appendTo("head");
    } else if (count > 4) {
        $("<style>.product-archive .product-archive-content::after { height: 1080px !important; }</style>").appendTo("head");
    }

    // ====================== Sidebar Menu Toggle ======================
    $(".navbar-sidebar-responsive-content-item .menu-item-has-children > a").on("click", function (e) {
        if ($(window).width() <= 991) {
            e.preventDefault();
            $(this).parent().toggleClass("active");
        }
    });

    // ====================== Brands Scroll ======================
    const $brandsWrapper = $(".product-brands-list-left-header-item-wrapper");
    const $scrollLeft = $(".brands-scroll-btn.left");
    const $scrollRight = $(".brands-scroll-btn.right");
    const scrollAmount = 200;

    $scrollLeft.on("click", () => $brandsWrapper.scrollLeft($brandsWrapper.scrollLeft() - scrollAmount));
    $scrollRight.on("click", () => $brandsWrapper.scrollLeft($brandsWrapper.scrollLeft() + scrollAmount));

    // ====================== Features Center Text ======================
    $(".features-center .features-center-top-title-content span").each(function () {
        const text = $(this).text();
        $(this).html(`<span style="color:white;">${text.slice(0, 4)}</span>${text.slice(4)}`);
    });

    // ====================== Categories Main Rotation ======================
    const $categoriesItems = $(".body-categories-main-item");
    let catCurrentIndex = 0;
    let catInterval;

    function setActiveCat(index) {
        $categoriesItems.removeClass("active");
        $categoriesItems.eq(index).addClass("active");
    }

    function startCatRotation() {
        catInterval = setInterval(() => {
            catCurrentIndex = (catCurrentIndex + 1) % $categoriesItems.length;
            setActiveCat(catCurrentIndex);
        }, 5000);
    }

    function stopCatRotation() {
        clearInterval(catInterval);
    }

    $categoriesItems.each(function (index) {
        const $span = $(this).find(".counter-categories-main-item");
        if ($span.length) {
            $span.text(String(index + 1).padStart(2, "0"));
        }

        $(this).on("mouseenter", function () {
            stopCatRotation();
            setActiveCat(index);
        });

        $(this).on("mouseleave", function () {
            catCurrentIndex = index;
            startCatRotation();
        });
    });

    setActiveCat(0);
    startCatRotation();

    // ====================== Add to Cart ======================
    $(".cart-product").on("click", function () {
        const $btn = $(this);
        const productId = $btn.data("product-id");
        const productType = $btn.data("product-type");
        const productUrl = $btn.data("product-url");

        if (productType === "simple") {
            $.ajax({
                url: "",
                method: "POST",
                data: {action: "woocommerce_add_to_cart", product_id: productId, quantity: 1},
                success: function (data) {
                    if (data.error) {
                        showToast("error", data.error);
                    } else {
                        showToast("success", "محصول به سبد خرید اضافه شد");
                    }
                },
                error: function () {
                    showToast("error", "خطا در افزودن به سبد خرید");
                }
            });
        } else {
            window.location.href = productUrl;
        }
    });

    // ====================== Product Variation Handler ======================
    const $priceWrapper = $(".single-product-kamand-item-bottom-header-price");
    const $variationForm = $("form.variations_form");

    if ($variationForm.length && $priceWrapper.length) {
        $variationForm.on("found_variation", function (event, variation) {
            const regular = variation.display_regular_price;
            const sale = variation.display_price;
            const discount = regular > sale ? Math.round(((regular - sale) / regular) * 100) : 0;

            const $regularBox = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular");
            const $regularNumber = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular-number");
            const $discountEl = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular-discount");
            const $saleNumber = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-sales-off-number");

            if (discount > 0) {
                $regularBox.show();
                $regularNumber.text(regular.toLocaleString());
                $discountEl.text("%" + discount);
            } else {
                $regularBox.hide();
            }

            $saleNumber.text(sale.toLocaleString());
        });

        $variationForm.on("reset_data", function () {
            const $regularBox = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular");
            const $regularNumber = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular-number");
            const $discountEl = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-regular-discount");
            const $saleNumber = $priceWrapper.find(".single-product-kamand-item-bottom-header-price-sales-off-number");

            $regularBox.show();
            $regularNumber.text("56,000,000");
            $discountEl.text("%54");
            $saleNumber.text("26,000,000");
        });
    }

    // ====================== Filter: Brand ======================
    $("#content-brand-item").on("click", function () {
        const brandSlug = $(this).data("brand-slug");
        const currentParams = new URLSearchParams(window.location.search);
        let selectedBrands = currentParams.get("brand") ? currentParams.get("brand").split(",") : [];

        if ($(this).hasClass("active")) {
            selectedBrands = selectedBrands.filter(b => b !== brandSlug);
        } else {
            selectedBrands.push(brandSlug);
        }

        if (selectedBrands.length > 0) {
            currentParams.set("brand", selectedBrands.join(","));
        } else {
            currentParams.delete("brand");
        }

        window.location.href = window.location.pathname + "?" + currentParams.toString();
    });

    // ====================== Filter: Category ======================
    $(".content-category-item").on("click", function () {
        const url = $(this).data("category-url");
        if (url) window.location.href = url;
    });

    // ====================== Filter: Color ======================
    $(".content-color-item").on("click", function () {
        const colorSlug = $(this).data("color-slug");
        const currentParams = new URLSearchParams(window.location.search);
        let selectedColors = currentParams.get("color") ? currentParams.get("color").split(",") : [];

        if ($(this).hasClass("active")) {
            selectedColors = selectedColors.filter(c => c !== colorSlug);
        } else {
            selectedColors.push(colorSlug);
        }

        if (selectedColors.length > 0) {
            currentParams.set("color", selectedColors.join(","));
        } else {
            currentParams.delete("color");
        }

        window.location.href = window.location.pathname + "?" + currentParams.toString();
    });

    // ====================== Filter: Properties ======================
    $(".content-property-item").on("click", function () {
        const propertyName = $(this).data("property-slug");
        const groupId = $(this).data("property-group");
        const propertyKey = groupId + "|" + propertyName;
        const currentParams = new URLSearchParams(window.location.search);
        let selectedProperties = currentParams.get("properties") ? currentParams.get("properties").split(",") : [];

        if ($(this).hasClass("active")) {
            selectedProperties = selectedProperties.filter(p => p !== propertyKey);
        } else {
            selectedProperties.push(propertyKey);
        }

        if (selectedProperties.length > 0) {
            currentParams.set("properties", selectedProperties.join(","));
        } else {
            currentParams.delete("properties");
        }

        window.location.href = window.location.pathname + "?" + currentParams.toString();
    });

    // ====================== Filter: Price Slider ======================
    let minPriceVal = window.minPrice || 0;
    let maxPriceVal = window.maxPrice || 100000000;
    let currentMin = window.currentMin || minPriceVal;
    let currentMax = window.currentMax || maxPriceVal;

    let leftPercent = (currentMin - minPriceVal) / (maxPriceVal - minPriceVal);
    let rightPercent = (currentMax - minPriceVal) / (maxPriceVal - minPriceVal);

    const $track = $("#track");
    const $fill = $("#fill");
    const $leftKnob = $("#left-knob");
    const $rightKnob = $("#right-knob");
    const $minDisplay = $("#min-price-display");
    const $maxDisplay = $("#max-price-display");

    function updatePricePositions() {
        if (!$track.length) return;
        const trackWidth = $track.width();
        const leftPx = leftPercent * trackWidth;
        const rightPx = rightPercent * trackWidth;

        $leftKnob.css("left", leftPx + "px");
        $rightKnob.css("left", rightPx + "px");
        $fill.css({left: leftPx + "px", width: (rightPx - leftPx) + "px"});

        const leftValue = Math.round(minPriceVal + (maxPriceVal - minPriceVal) * leftPercent);
        const rightValue = Math.round(minPriceVal + (maxPriceVal - minPriceVal) * rightPercent);

        $minDisplay.text(leftValue.toLocaleString("fa-IR"));
        $maxDisplay.text(rightValue.toLocaleString("fa-IR"));
    }

    let activePriceKnob = null;

    function handlePriceDrag(e) {
        if (!activePriceKnob || !$track.length) return;
        const rect = $track[0].getBoundingClientRect();
        let percent = (e.clientX - rect.left) / rect.width;
        percent = Math.max(0, Math.min(1, percent));

        if (activePriceKnob === $leftKnob[0] && percent < rightPercent - 0.02) {
            leftPercent = percent;
        } else if (activePriceKnob === $rightKnob[0] && percent > leftPercent + 0.02) {
            rightPercent = percent;
        }
        updatePricePositions();
    }

    function updatePriceURL() {
        const leftValue = Math.round(minPriceVal + (maxPriceVal - minPriceVal) * leftPercent);
        const rightValue = Math.round(minPriceVal + (maxPriceVal - minPriceVal) * rightPercent);
        const currentParams = new URLSearchParams(window.location.search);

        if (leftValue > minPriceVal) {
            currentParams.set("min_price", leftValue);
        } else {
            currentParams.delete("min_price");
        }

        if (rightValue < maxPriceVal) {
            currentParams.set("max_price", rightValue);
        } else {
            currentParams.delete("max_price");
        }

        window.location.href = window.location.pathname + "?" + currentParams.toString();
    }

    if ($track.length) {
        $leftKnob.on("mousedown", function () {
            activePriceKnob = this;
        });
        $rightKnob.on("mousedown", function () {
            activePriceKnob = this;
        });
        $(document).on("mouseup", function () {
            if (activePriceKnob) {
                activePriceKnob = null;
                updatePriceURL();
            }
        });
        $(document).on("mousemove", handlePriceDrag);
        $(window).on("resize", updatePricePositions);
        updatePricePositions();
    }

    // ====================== Brand Search ======================
    const $brandSearch = $("#brand-search");
    if ($brandSearch.length) {
        $brandSearch.on("input", function () {
            const searchTerm = $(this).val().toLowerCase();
            $(".content-brand-item").each(function () {
                const brandName = $(this).data("brand-name")?.toLowerCase() || "";
                $(this).css("display", brandName.includes(searchTerm) ? "flex" : "none");
            });
        });
    }

    // ====================== Quantity Buttons ======================
    $(".quantity").each(function () {
        const $container = $(this);
        const $plus = $container.find(".plus");
        const $minus = $container.find(".minus");
        const $input = $container.find(".qty");

        $plus.on("click", function () {
            let value = parseInt($input.val()) || 1;
            $input.val(value + 1);
        });

        $minus.on("click", function () {
            let value = parseInt($input.val()) || 1;
            if (value > 1) $input.val(value - 1);
        });
    });

    // ====================== Variant Radio ======================
    $(".variant-radio").on("change", function () {
        const $radio = $(this);
        const mainPrice = $radio.data("main-price");
        const finalPrice = $radio.data("final-price");
        const discount = $radio.data("discount");
        const expiration = $radio.data("expiration");

        const $oldPrice = $("#old-price");
        const $newPrice = $("#new-price");
        const $timerBox = $("#discount-timer");

        $newPrice.text(new Intl.NumberFormat().format(finalPrice ?? mainPrice));

        if (discount > 0) {
            $oldPrice.removeClass("d-none").text(new Intl.NumberFormat().format(mainPrice));
        } else {
            $oldPrice.addClass("d-none");
        }

        if ($timerBox.length) {
            if (expiration) {
                $timerBox.removeClass("d-none");
                startTimer(expiration);
            } else {
                $timerBox.addClass("d-none");
                if (window.discountInterval) clearInterval(window.discountInterval);
            }
        }
    });

    // ====================== Timer Functions ======================
    window.startTimer = function (expireDate) {
        const $timer = $("#discount-timer");
        if (!$timer.length) return;

        const $days = $timer.find(".days");
        const $hours = $timer.find(".hours");
        const $minutes = $timer.find(".minutes");
        const $seconds = $timer.find(".seconds");

        const expire = new Date(expireDate).getTime();

        if (window.discountInterval) clearInterval(window.discountInterval);

        window.discountInterval = setInterval(function () {
            const now = new Date().getTime();
            const distance = expire - now;

            if (distance < 0) {
                clearInterval(window.discountInterval);
                $timer.addClass("d-none");
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $days.text(days);
            $hours.text(String(hours).padStart(2, "0"));
            $minutes.text(String(minutes).padStart(2, "0"));
            $seconds.text(String(seconds).padStart(2, "0"));
        }, 1000);
    };

    // ====================== Banner Countdown ======================
    const $bannerCounter = $(".banner-amazing-counter");
    if ($bannerCounter.length) {
        let dateStr = $bannerCounter.data("countdown")?.replace(" ", "T");
        const endDate = new Date(dateStr).getTime();

        function updateBannerCountdown() {
            const now = Date.now();
            const distance = endDate - now;

            if (distance <= 0) {
                $bannerCounter.html(`
                    <div class="banner-amazing-counter-item"><span>0</span><span>روز</span></div>
                    <div class="banner-amazing-counter-item-line"></div>
                    <div class="banner-amazing-counter-item"><span>0</span><span>ساعت</span></div>
                    <div class="banner-amazing-counter-item-line"></div>
                    <div class="banner-amazing-counter-item banner-amazing-counter-item-badge"><span>0</span><span>دقیقه</span></div>
                    <div class="banner-amazing-counter-item-line"></div>
                    <div class="banner-amazing-counter-item"><span>0</span><span>ثانیه</span></div>
                `);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $bannerCounter.html(`
                <div class="banner-amazing-counter-item"><span>${days}</span><span>روز</span></div>
                <div class="banner-amazing-counter-item-line"></div>
                <div class="banner-amazing-counter-item"><span>${String(hours).padStart(2, "0")}</span><span>ساعت</span></div>
                <div class="banner-amazing-counter-item-line"></div>
                <div class="banner-amazing-counter-item banner-amazing-counter-item-badge"><span>${String(minutes).padStart(2, "0")}</span><span>دقیقه</span>
                    <svg width="41" height="74" viewBox="0 0 41 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.5 9L8 0L10 9H0.5Z" fill="#E80645" fill-opacity="0.6"></path>
                        <path d="M0.5 65L8 74L10 65H0.5Z" fill="#E80645" fill-opacity="0.6"></path>
                        <path d="M8 0H29C35.6274 0 41 5.37258 41 12V62C41 68.6274 35.6274 74 29 74H8V0Z" fill="#E80645"></path>
                    </svg>
                </div>
                <div class="banner-amazing-counter-item-line"></div>
                <div class="banner-amazing-counter-item"><span>${String(seconds).padStart(2, "0")}</span><span>ثانیه</span></div>
            `);
        }

        updateBannerCountdown();
        setInterval(updateBannerCountdown, 1000);
    }

    // ====================== Sale Products Timer ======================
    $(".sale-products-timer-counter").each(function () {
        const $counter = $(this);
        const rawDate = $counter.data("countdown");
        if (!rawDate) return;

        const endDate = new Date(rawDate.replace(" ", "T")).getTime();
        const $spans = $counter.find(".sale-products-time span:first-child");

        function updateSaleCountdown() {
            const now = Date.now();
            const distance = endDate - now;

            if (distance <= 0) {
                $spans.eq(0).text("00");
                $spans.eq(1).text("00");
                $spans.eq(2).text("00");
                $spans.eq(3).text("00");
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $spans.eq(0).text(days);
            $spans.eq(1).text(String(hours).padStart(2, "0"));
            $spans.eq(2).text(String(minutes).padStart(2, "0"));
            $spans.eq(3).text(String(seconds).padStart(2, "0"));
        }

        updateSaleCountdown();
        setInterval(updateSaleCountdown, 1000);
    });

    // ====================== Tooltip and Modal ======================
    if ($.fn.tooltip) {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }
});


// Discount Carts

// تنظیم CSRF token برای تمام درخواست‌های AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// توابع Global
window.formatNumber = function(number) {
    return new Intl.NumberFormat('fa-IR').format(number);
};

window.updateCartAfterDiscount = function(response) {
    console.log('Updating cart with discount:', response);

    if (!response.cart) {
        console.error('No cart data in response');
        return;
    }

    if (response.cart.discount_amount > 0 && response.cart.discount_code) {
        const discountHtml = `
            <div class="applied-discount-box" id="applied-discount-box">
                <div class="applied-code">
                    <span class="code-label">کد تخفیف اعمال شده:</span>
                    <strong class="code-value">${response.cart.discount_code}</strong>
                    <span class="discount-value">(-${window.formatNumber(response.cart.discount_amount)} تومان)</span>
                    <button type="button" class="remove-discount-btn" onclick="window.removeDiscountCode()">
                        ✕
                    </button>
                </div>
            </div>
        `;
        $('#applied-discount-box').remove();
        $('#discount-section').html(discountHtml);
        $('#discount-row').show();
        $('#discount-code').text(response.cart.discount_code);
        $('#discount-amount').text('-' + window.formatNumber(response.cart.discount_amount) + ' تومان');
    } else {
        $('#discount-row').hide();
        $('#applied-discount-box').remove();
    }

    const subtotal = response.cart.subtotal;
    const discountAmount = response.cart.discount_amount;
    const finalTotal = Math.max(0, subtotal - discountAmount);

    $('#subtotal-amount').text(window.formatNumber(subtotal) + ' تومان');
    $('#final-total').text(window.formatNumber(finalTotal) + ' تومان');
    $('#cart-subtotal').text(window.formatNumber(subtotal));
    $('#cart-total').text(window.formatNumber(finalTotal));

    if (discountAmount > 0 && response.cart.discount_code) {
        if ($('.discount-row').length === 0) {
            const discountRowHtml = `
                <tr class="discount-row">
                    <th>تخفیف (${response.cart.discount_code})</th>
                    <td data-title="تخفیف">
                        <span class="amount discount-amount">
                            -${window.formatNumber(discountAmount)} تومان
                        </span>
                    </td>
                </tr>
            `;
            $('.order-total').before(discountRowHtml);
        } else {
            $('.discount-row th').html(`تخفیف (${response.cart.discount_code})`);
            $('.discount-row .discount-amount').html(`-${window.formatNumber(discountAmount)} تومان`);
        }
    } else {
        $('.discount-row').remove();
    }
};

window.removeDiscountCode = function() {
    Swal.fire({
        title: 'حذف کد تخفیف',
        text: 'آیا از حذف کد تخفیف اطمینان دارید؟',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف شود',
        cancelButtonText: 'خیر',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/cart/remove-discount',
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('حذف شد!', response.message, 'success')
                            .then(() => location.reload());
                    }
                },
                error: function(xhr) {
                    Swal.fire('خطا!', 'مشکلی در حذف تخفیف رخ داد', 'error');
                }
            });
        }
    });
};

$(document).ready(function() {
    console.log('Document ready - Cart page initialized');

    function updateQuantity(cartId, quantity) {
        $.ajax({
            url: `/cart/update/${cartId}`,
            type: 'PUT',
            data: {quantity: quantity},
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: xhr.responseJSON?.message || 'خطا در بروزرسانی',
                    confirmButtonText: 'باشه'
                }).then(() => location.reload());
            }
        });
    }

    function removeFromCart(cartId) {
        Swal.fire({
            title: 'حذف محصول',
            text: 'آیا از حذف این محصول از سبد خرید اطمینان دارید؟',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'بله، حذف شود',
            cancelButtonText: 'خیر',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/cart/remove/${cartId}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('حذف شد!', 'محصول از سبد خرید حذف شد.', 'success')
                                .then(() => location.reload());
                        }
                    },
                    error: function() {
                        Swal.fire('خطا!', 'مشکلی در حذف محصول رخ داد', 'error');
                    }
                });
            }
        });
    }

    // رویدادها
    $(document).on('click', '.cart-counter-plus', function() {
        let id = $(this).data('id');
        let input = $(`.cart-quantity-input[data-id="${id}"]`);
        let newVal = parseInt(input.val()) + 1;
        let max = parseInt(input.attr('max'));
        if (newVal <= max) {
            updateQuantity(id, newVal);
        }
    });

    $(document).on('click', '.cart-counter-mines', function() {
        let id = $(this).data('id');
        let input = $(`.cart-quantity-input[data-id="${id}"]`);
        let newVal = parseInt(input.val()) - 1;
        if (newVal >= 1) {
            updateQuantity(id, newVal);
        }
    });

    $(document).on('click', '.remove-from-cart', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        removeFromCart(id);
    });

    $(document).on('change', '.cart-quantity-input', function() {
        let id = $(this).data('id');
        let newVal = parseInt($(this).val());
        let max = parseInt($(this).attr('max'));
        if (newVal >= 1 && newVal <= max) {
            updateQuantity(id, newVal);
        } else {
            $(this).val($(this).attr('value'));
        }
    });

    // اعمال کد تخفیف
    $('#apply-coupon').off('click').on('click', function() {
        const couponCode = $('#coupon_code').val().trim();
        console.log('Apply coupon clicked. Code:', couponCode);

        if (!couponCode) {
            Swal.fire({
                icon: 'warning',
                title: 'توجه',
                text: 'لطفا کد تخفیف را وارد کنید',
                confirmButtonText: 'باشه'
            });
            return;
        }

        const $btn = $(this);
        const originalText = $btn.html();
        $btn.html('در حال بررسی...').prop('disabled', true);

        $.ajax({
            url: '/cart/apply-discount',
            type: 'POST',
            data: {
                code: couponCode,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تبریک!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    window.updateCartAfterDiscount(response);
                    $('#coupon_code').val('');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: response.message,
                        confirmButtonText: 'باشه'
                    });
                }
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                let message = 'خطا در اعمال کد تخفیف';
                if (xhr.status === 419) {
                    message = 'خطای اعتبارسنجی. لطفا صفحه را رفرش کنید.';
                } else if (xhr.status === 404) {
                    message = 'مسیر مورد نظر یافت نشد.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: message,
                    confirmButtonText: 'باشه'
                });
            },
            complete: function() {
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Enter key on coupon input
    $('#coupon_code').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#apply-coupon').click();
        }
    });

    console.log('All event handlers registered');
});
