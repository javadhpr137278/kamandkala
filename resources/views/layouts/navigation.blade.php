<div class="col-lg-3 d-lg-block d-none">

    <div class="penel-nav">
        <div class="panel-nav-nav">
            <nav class="navbar profile-box-nav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item active"><a href="{{route('dashboard')}}" class="nav-link">
                            <i class="bi bi-house-door"></i>پروفایل</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.orders') }}" class="nav-link">
                            <i class="bi bi-cart-check"></i> سفارش های من
                            <span class="badge rounded-pill badge-spn">{{ auth()->user()->orders_count }}</span>
                        </a>
                    </li>
                    <li class="nav-item"><a href="{{route('dashboard.address')}}" class="nav-link">
                            <i class="bi bi-pin-map"></i>آدرس های من</a>
                    </li>
                    <li class="nav-item"><a href="" class="nav-link">
                            <i class="bi bi-bell"></i>پیام ها و اطلاعیه ها</a>
                    </li>
                    <li class="nav-item"><a href="" class="nav-link">
                            <i class="bi bi-chat-dots"></i>نظرات من</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" class="nav-link text-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-arrow-right-square"></i> خروج از حساب کاربری
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
