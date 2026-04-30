@extends('home.auth.layouts.master')

{{-- اضافه کردن متاتگ برای امنیت AJAX --}}
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="auth-items">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="auth-logo text-center">
                    <a href="/">
                        <img src="assets/img/mlogo.png" width="200" alt="لوگو">
                    </a>
                </div>
                <div class="auth-form shadow-xl rounded-3 bg-white">
                    <div class="auth-form-title mb-4 slider-title-desc-center">
                        <h2 class="text-center h4 text-muted title-font">تایید شماره موبایل</h2>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger text-center">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="alert text-center alert-success">
                        کد تایید به شماره {{ session('mobile') }} ارسال شد.
                    </div>

                    <form method="post" action="{{ route('verify.code') }}">
                        @csrf
                        <div id="otp-input">
                            <input placeholder="_" type="number" step="1" min="0" max="9" autocomplete="no">
                            <input placeholder="_" type="number" step="1" min="0" max="9" autocomplete="no">
                            <input placeholder="_" type="number" step="1" min="0" max="9" autocomplete="no">
                            <input placeholder="_" type="number" step="1" min="0" max="9" autocomplete="no">
                            {{-- اگر کد شما 5 رقمی است، یک اینپوت دیگر اینجا اضافه کنید --}}
                            <input id="otp-value" type="hidden" name="code">
                        </div>

                        <!-- بخش اول: تایمر -->
                        <div class="countDownContainer" id="timerWrapper">
                            <div class="countdown-bar" id="countdownB"
                                 style="width: 250px; height: 2px; background-color: rgb(244, 244, 244); border-color: rgb(58, 59, 156); margin: 20px auto;">
                                <div class="progress-fill" style="width: 100%; height: 2px; background-color: rgb(58, 59, 156); transition: width 1s linear;"></div>
                                <div style="width: 250px; height: 20px; text-align: center; margin-top: 5px;">
                                    <span class="timer-text" style="color: #3a3b9c; font-weight: 700; font-family: yekan-bakh; font-size: 14px;">
                                        00:00:31
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- بخش دوم: درخواست کد جدید -->
                        <div class="countDownContainer" id="resendWrapper" style="display: none;">
                            <div class="countdown-bar" id="countdownB2"
                                 style="width: 250px; height: 2px; background-color: rgb(244, 244, 244); border-color: rgb(58, 59, 156); margin: 20px auto;">
                                <div style="width: 100%; height: 2px; background-color: rgb(58, 59, 156);"></div>
                                <div style="width: 250px; height: 20px; text-align: center; margin-top: 5px;">
                                    <span style="font-family: yekan-bakh; font-size: 14px;">
                                        <a href="#" id="resendBtn" style="color: #3a3b9c; font-weight: 700; text-decoration: none;">درخواست کد جدید</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" id="submit" class="btn btn-success w-100 mt-4 btn-login">ورود به سایت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const resendBtn = document.getElementById("resendBtn");

            resendBtn.addEventListener("click", function () {

                resendBtn.disabled = true;

                fetch("/resend-code", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                })
                    .then(res => res.json())
                    .then(data => {

                        if (data.status === "success") {
                            console.log("کد با موفقیت ارسال شد.");
                        } else {
                            console.error("ارسال پیامک ناموفق بود:", data.message);
                        }

                    })
                    .catch(err => {
                        console.error("خطا در ارتباط با سرور:", err);
                    })
                    .finally(() => {
                        setTimeout(() => {
                            resendBtn.disabled = false;
                        }, 30000); // دوباره فعال شدن بعد 30 ثانیه
                    });

            });
        });
    </script>

    <script>
        // --- بخش مربوط به اینپوت‌های OTP ---
        const otpInputs = document.querySelectorAll('#otp-input input[type="number"]');
        const OTPValueContainer = document.querySelector('#otp-value');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                input.value = input.value.slice(0, 1);
                if (input.value && index < otpInputs.length - 1) otpInputs[index + 1].focus();
                updateValue();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        function updateValue() {
            let otp = '';
            otpInputs.forEach(inp => otp += inp.value);
            OTPValueContainer.value = otp;
        }
    </script>

    <style>
        #otp-input {
            display: flex;
            justify-content: center;
            gap: 10px;
            direction: rtl;
        }
        #otp-input input {
            width: 45px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .countDownContainer {
            margin-top: 25px;
        }
        /* حذف فلش‌های اینپوت نانبر */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
