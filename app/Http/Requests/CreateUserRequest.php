<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => [
                'required',
                'string',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile' // اینجا هم unique برای موبایل
            ],
            // اگر عکس اجباری نیست، 'nullable' رو اضافه کن
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'], // max:2MB
            'password' => ['required', 'string', 'min:8'], // حداقل ۸ کاراکتر
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً استفاده شده است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل صحیح نیست (مثال: 09123456789).',
            'mobile.unique' => 'این شماره موبایل قبلاً استفاده شده است.',
            'image.image' => 'فایل انتخابی باید تصویر باشد.',
            'image.mimes' => 'فرمت‌های مجاز برای تصویر: jpg, jpeg, png, gif, webp.',
            'image.max' => 'حجم فایل تصویر نباید بیشتر از ۲ مگابایت باشد.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        ];
    }
}
