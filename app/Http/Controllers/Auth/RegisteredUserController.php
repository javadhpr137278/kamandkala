<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\Messages\MessageService;
use App\Services\Messages\SMS\MelipayamakService;
use App\Services\Messages\SMS\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('home.auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'mobile' => ['required', 'string', 'max:11', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        Session::put('name', $request->name);
        Session::put('mobile', $request->mobile);
        Session::put('password', $request->password);

        $code = rand(1111, 9999);

        VerificationCode::VerificationCode($request->mobile, $code);

        // اینجا از smsService تزریق شده استفاده کن
        $smsService = new SmsService(
            receiver: $request->mobile,
            content: $code,
            melipayamak: app(MelipayamakService::class)
        );

        $messageService = new MessageService($smsService);
        $messageService->send();

        return redirect()->route('verify.mobile');
    }
}
