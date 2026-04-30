<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\Messages\SMS\SmsService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class VerifyMobileController extends Controller
{
    /**
     * نمایش فرم وارد کردن کد تأیید
     */
    public function verify()
    {
        if (!Session::has('mobile')) {
            return redirect()->route('register');
        }

        return view('home.auth.verify_otp');
    }

    /**
     * بررسی صحت کد تأیید و ثبت کاربر
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'numeric']
        ]);

        $mobile = Session::get('mobile');

        $isValid = VerificationCode::CheckVerificationCode($mobile, $request->code);

        if ($isValid) {
            $user = User::create([
                'name'     => Session::get('name'),
                'mobile'   => $mobile,
                'password' => Hash::make(Session::get('password')),
            ]);

            event(new Registered($user));

            Auth::login($user);

            Session::forget(['name', 'mobile', 'password']);
            VerificationCode::where('mobile', $mobile)->delete();


            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'کد وارد شده اشتباه است.']);
    }
}
