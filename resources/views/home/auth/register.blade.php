@extends('home.auth.layouts.master')
@section('content')
    <div class="auth-items">
        <div class="row justify-content-center">
            <div class="col-lg-4">

                <div class="auth-logo text-center">
                    <div class="description d-md-block d-none">
                        <h6 class="font-20 title-font">فروشگاه آنلاین کمند</h6>
                        <p class="mb-0 mt-1 text-muted"> برای همه سلیقه ها</p>
                    </div>
                </div>
                <div class="auth-form shadow-xl rounded-3  mt-5 bg-white">
                    <div class="auth-form-title mb-4 slider-title-desc-center">
                        <h2 class="text-center h4 text-muted title-font">ورود / ثبت نام</h2>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Success --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="comment-item mb-3">
                            <input type="text" class="form-control" id="floatingInputName" name="name">
                            <label for="floatingInputName" class="form-label label-float">نام و نام خانوادگی خود را وارد
                                کنید</label>
                        </div>

                        <div class="comment-item mb-3">
                            <input type="text" class="form-control" id="floatingInputMobile" name="mobile">
                            <label for="floatingInputMobile" class="form-label label-float">شماره همراه خود را وارد
                                کنید</label>
                        </div>
                        <div class="comment-item mb-3">
                            <input type="password" class="form-control" id="floatingInputPassword" name="password">
                            <label for="floatingInputPassword" class="form-label label-float">رمز عبور خود را وارد
                                کنید</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100 mt-4 btn-login">ثبت نام در
                                سایت
                            </button>
                            <p class="loginTermsDesc">قبلا ثبت نام کرده اید؟ <a class="underlined main-color-one-color fw-bold" href="{{route('login')}}">وارد شوید</a></p>
                        </div>
                    </form>
                </div>

                <p class="loginTermsDesc">با ورود و یا ثبت نام در کمند شما <a
                        class="underlined main-color-one-color fw-bold" href="/rules/">شرایط و
                        قوانین</a> استفاده از سرویس‌های سایت کمند و <a class="underlined main-color-one-color fw-bold"
                                                                       href="/privacy-polices/">قوانین حریم
                        خصوصی</a> آن را می‌پذیرید.</p>
            </div>
        </div>
    </div>
@endsection
