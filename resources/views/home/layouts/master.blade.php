@include('home.layouts.head')
@include('home.layouts.navbar')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            @yield('content')
        </div>
    </div>
</div>
@include('home.layouts.footer')
