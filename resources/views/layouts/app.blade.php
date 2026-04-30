@include('home.layouts.head')
@include('home.layouts.navbar')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="content">
                <div class="container-fluid">

                    <div class="custom-filter d-lg-none d-block">
                        <button class="btn btn-filter-float border-0 main-color-two-bg shadow-box px-4 rounded-3 position-fixed"
                                style="z-index: 999;bottom:80px;" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="bi bi-list font-20 fw-bold text-white"></i>
                            <span class="d-block font-14 text-white">منو</span>
                        </button>

                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasRight"
                             aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title">منو</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">

                                <div class="penel-nav">
                                    <div class="panel-nav-nav">
                                        <nav class="navbar-5 profile-box-nav">
                                            <ul class="navbar-nav-5 flex-column">
                                                <li class="nav-item active w-100"><a href="" class="nav-link">
                                                        <i class="bi bi-house-door"></i>پروفایل</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-cart-check"></i>سفارش های من <span
                                                            class="badge rounded-pill badge-spn">5</span></a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-pin-map"></i>آدرس های من</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-bell"></i>پیام ها و اطلاعیه ها</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-chat-dots"></i>نظرات من</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-question-circle"></i>درخواست پشتیبانی</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-heart"></i>محصولات مورد علاقه</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-gift"></i>کد های تخفیف من</a>
                                                </li>
                                                <li class="nav-item"><a href="" class="nav-link">
                                                        <i class="bi bi-arrow-right-square"></i>خروج از حساب کاربری</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel position-relative">
                        <div class="row gy-4">
                            @include('layouts.navigation')
                            <div class="col-lg-9">
                                <div class="position-sticky top-0">
                                    <div class="panel-header">
                                        <div class="content-box">
                                            <div class="container-fluid">
                                                <div class="row gy-5 align-items-center justify-content-between">
                                                    <div class="col-md-6 col-8">
                                                        <div class="d-flex align-items-center">
                                                            <h6>{{ Auth::user()->name }} عزیز به پنل کاربری خوش آمدید</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex align-items-center panel-profile">
                                                            <img src="{{ Auth::user()->image_url }}"
                                                                 class="img-fluid img-profile-panel rounded-circle me-3 shadow-md"
                                                                 alt="پروفایل {{ Auth::user()->name }}">
                                                            <div class="d-grid gap-2">
                                                                <h6 class="font-14 main-color-one-color">حساب کاربری من</h6>
                                                                <div class="d-flex align-items-center">
                                                                    <h6 class="font-14">
                                                                        {{ Auth::user()->name }}
                                                                    </h6>
                                                                    <a href="{{ route('profile.edit') }}" class="ms-2">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('home.layouts.footer')
