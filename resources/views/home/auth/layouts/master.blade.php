@include('home.auth.layouts.head')
@include('home.auth.layouts.navbar')
<div class="content vh-100">
    <div class="container-fluid h-100">
        <div class="auth h-100 d-flex align-items-center">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('home.auth.layouts.footer')
