@extends('admin.layouts.master')

@section('content')

    <div class="container mt-4">

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

        <form id="discountForm" method="POST" action="{{ route('discounts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="widget-content widget-content-area ecommerce-create-section p-3">

                        {{-- کد تخفیف --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">کد تخفیف <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="code" class="form-control"
                                           placeholder="مثال: SUMMER1403"
                                           value="{{ old('code') }}" required>
                                    <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                        <i class="ti-reload"></i>
                                        تولید خودکار
                                    </button>
                                </div>
                                <small class="text-muted">کد تخفیف باید منحصر به فرد باشد</small>
                            </div>
                        </div>

                        {{-- نوع و مقدار تخفیف --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">نوع تخفیف <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" id="discountType" required>
                                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>درصدی (%)</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (تومان)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">مقدار تخفیف <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="value" class="form-control"
                                           placeholder="مقدار تخفیف"
                                           value="{{ old('value') }}" required step="1000">
                                    <span class="input-group-text" id="valueUnit">%</span>
                                </div>
                            </div>
                        </div>

                        {{-- محدودیت‌ها --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">حداقل مبلغ سفارش</label>
                                <div class="input-group">
                                    <input type="number" name="min_order_amount" class="form-control"
                                           placeholder="حداقل مبلغ برای اعمال تخفیف"
                                           value="{{ old('min_order_amount') }}" step="1000">
                                    <span class="input-group-text">تومان</span>
                                </div>
                                <small class="text-muted">اختیاری - اگر خالی بماند، محدودیتی وجود ندارد</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">حداکثر مبلغ تخفیف</label>
                                <div class="input-group">
                                    <input type="number" name="max_discount_amount" class="form-control"
                                           placeholder="حداکثر تخفیف قابل اعمال"
                                           value="{{ old('max_discount_amount') }}" step="1000">
                                    <span class="input-group-text">تومان</span>
                                </div>
                                <small class="text-muted">اختیاری - فقط برای تخفیف درصدی کاربرد دارد</small>
                            </div>
                        </div>

                        {{-- محدودیت تعداد استفاده --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">محدودیت تعداد استفاده</label>
                                <input type="number" name="usage_limit" class="form-control"
                                       placeholder="حداکثر تعداد دفعات استفاده (اختیاری)"
                                       value="{{ old('usage_limit') }}" min="1">
                                <small class="text-muted">اگر خالی بماند، نامحدود است</small>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="row">

                        <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">
                            <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                {{-- تاریخ شروع و انقضا --}}
                                <div class="row">
                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label class="form-label">تاریخ شروع</label>
                                        <input type="datetime-local" name="starts_at" class="form-control"
                                               value="{{ old('starts_at') }}">
                                        <small class="text-muted">اختیاری - اگر خالی باشد، بلافاصله فعال می‌شود</small>
                                    </div>

                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label class="form-label">تاریخ انقضا</label>
                                        <input type="datetime-local" name="expires_at" class="form-control"
                                               value="{{ old('expires_at') }}">
                                        <small class="text-muted">اختیاری - اگر خالی باشد، تاریخ انقضا ندارد</small>
                                    </div>
                                </div>

                                {{-- وضعیت فعال/غیرفعال --}}
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   name="is_active" value="1"
                                                   id="isActive" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isActive">
                                                فعال بودن کد تخفیف
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- دکمه ثبت --}}
                            <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">
                                <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="ti-save"></i>
                                                ذخیره کد تخفیف
                                            </button>
                                        </div>
                                        <div class="col-sm-12">
                                            <a href="{{ route('discounts.index') }}" class="btn btn-outline-danger w-100">
                                                <i class="ti-close"></i>
                                                انصراف
                                            </a>
                                        </div>
                                    </div>

                                    {{-- پیش‌نمایش تخفیف --}}
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <div class="alert alert-info" id="discountPreview">
                                                <strong>پیش‌نمایش تخفیف:</strong>
                                                <span id="previewText">هنوز مقداری وارد نشده است</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // تولید خودکار کد تخفیف
            const generateCodeBtn = document.getElementById('generateCode');
            const codeInput = document.querySelector('input[name="code"]');

            function generateRandomCode() {
                const prefixes = ['SUMMER', 'WINTER', 'SPRING', 'AUTUMN', 'SALE', 'OFF', 'SPECIAL', 'WELCOME'];
                const randomPrefix = prefixes[Math.floor(Math.random() * prefixes.length)];
                const randomNumber = Math.floor(Math.random() * 9000) + 1000;
                const randomSuffix = Math.random().toString(36).substring(2, 6).toUpperCase();
                return `${randomPrefix}${randomNumber}${randomSuffix}`;
            }

            if (generateCodeBtn) {
                generateCodeBtn.addEventListener('click', function() {
                    codeInput.value = generateRandomCode();
                    // اعتبارسنجی سریع
                    codeInput.classList.remove('is-invalid');
                });
            }

            // تغییر واحد نمایش بر اساس نوع تخفیف
            const discountType = document.getElementById('discountType');
            const valueUnit = document.getElementById('valueUnit');
            const valueInput = document.querySelector('input[name="value"]');
            const maxDiscountRow = document.querySelector('input[name="max_discount_amount"]')?.closest('.col-md-6');

            function updateValueUnit() {
                if (discountType.value === 'percent') {
                    valueUnit.textContent = '%';
                    valueInput.placeholder = 'مثال: 15 (درصد)';
                    valueInput.step = '1';
                    if (maxDiscountRow) {
                        maxDiscountRow.style.display = 'block';
                    }
                } else {
                    valueUnit.textContent = 'تومان';
                    valueInput.placeholder = 'مثال: 50000 (تومان)';
                    valueInput.step = '1000';
                    if (maxDiscountRow) {
                        maxDiscountRow.style.display = 'none';
                    }
                }
                updatePreview();
            }

            if (discountType) {
                discountType.addEventListener('change', updateValueUnit);
                updateValueUnit();
            }

            // پیش‌نمایش تخفیف
            function updatePreview() {
                const type = discountType?.value || 'percent';
                const value = valueInput?.value || 0;
                const minOrder = document.querySelector('input[name="min_order_amount"]')?.value || 0;
                const maxDiscount = document.querySelector('input[name="max_discount_amount"]')?.value || 0;
                const previewSpan = document.getElementById('previewText');

                if (!previewSpan) return;

                if (value > 0) {
                    let preview = '';
                    if (type === 'percent') {
                        preview = `${value}% تخفیف`;
                    } else {
                        preview = `${Number(value).toLocaleString('fa-IR')} تومان تخفیف`;
                    }

                    if (minOrder > 0) {
                        preview += ` | حداقل سفارش: ${Number(minOrder).toLocaleString('fa-IR')} تومان`;
                    }

                    if (type === 'percent' && maxDiscount > 0) {
                        preview += ` | حداکثر تخفیف: ${Number(maxDiscount).toLocaleString('fa-IR')} تومان`;
                    }

                    previewSpan.textContent = preview;
                    previewSpan.parentElement.classList.remove('alert-info');
                    previewSpan.parentElement.classList.add('alert-success');
                } else {
                    previewSpan.textContent = 'مقدار تخفیف را وارد کنید';
                    previewSpan.parentElement.classList.remove('alert-success');
                    previewSpan.parentElement.classList.add('alert-info');
                }
            }

            // اعمال پیش‌نمایش روی تغییرات
            if (valueInput) valueInput.addEventListener('input', updatePreview);
            const minOrderInput = document.querySelector('input[name="min_order_amount"]');
            const maxDiscountInput = document.querySelector('input[name="max_discount_amount"]');
            if (minOrderInput) minOrderInput.addEventListener('input', updatePreview);
            if (maxDiscountInput) maxDiscountInput.addEventListener('input', updatePreview);

            // اعتبارسنجی فرم قبل از ارسال
            const form = document.getElementById('discountForm');

            form.addEventListener('submit', function(e) {
                let isValid = true;
                const code = codeInput?.value.trim();
                const value = parseFloat(valueInput?.value);

                // اعتبارسنجی کد تخفیف
                if (!code) {
                    showError(codeInput, 'کد تخفیف الزامی است');
                    isValid = false;
                } else if (code.length < 3) {
                    showError(codeInput, 'کد تخفیف باید حداقل ۳ کاراکتر باشد');
                    isValid = false;
                } else {
                    clearError(codeInput);
                }

                // اعتبارسنجی مقدار تخفیف
                if (!value || value <= 0) {
                    showError(valueInput, 'مقدار تخفیف باید بزرگتر از 0 باشد');
                    isValid = false;
                } else {
                    clearError(valueInput);
                }

                // اعتبارسنجی حداکثر تخفیف برای نوع درصدی
                const type = discountType?.value;
                const maxDiscount = parseFloat(maxDiscountInput?.value);
                if (type === 'percent' && maxDiscount > 0 && value > 0) {
                    // حداکثر تخفیف نمی‌تواند بیشتر از مبلغ سفارش باشد - در سرور بررسی می‌شود
                }

                // اعتبارسنجی تاریخ‌ها
                const startsAt = document.querySelector('input[name="starts_at"]')?.value;
                const expiresAt = document.querySelector('input[name="expires_at"]')?.value;

                if (startsAt && expiresAt && new Date(startsAt) >= new Date(expiresAt)) {
                    alert('تاریخ شروع باید قبل از تاریخ انقضا باشد');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function showError(input, message) {
                if (!input) return;
                input.classList.add('is-invalid');
                let errorDiv = input.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    input.parentNode.insertBefore(errorDiv, input.nextSibling);
                }
                errorDiv.textContent = message;
            }

            function clearError(input) {
                if (!input) return;
                input.classList.remove('is-invalid');
                const errorDiv = input.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv.remove();
                }
            }

            // راهنمای سریع
            const helpHtml = `
                <div class="alert alert-warning mt-3">
                    <strong><i class="ti-info-alt"></i> نکات مهم:</strong>
                    <ul class="mb-0 mt-2">
                        <li>کد تخفیف باید منحصر به فرد باشد</li>
                        <li>تخفیف درصدی: مقدار بین 1 تا 99</li>
                        <li>تخفیف مبلغ ثابت: حداقل 1,000 تومان</li>
                        <li>اگر تاریخ شروع خالی باشد، کد بلافاصله فعال می‌شود</li>
                        <li>اگر تاریخ انقضا خالی باشد، کد تاریخ انقضا ندارد</li>
                    </ul>
                </div>
            `;

            const sidebarDiv = document.querySelector('.col-xxl-3 .row > div:first-child');
            if (sidebarDiv) {
                sidebarDiv.insertAdjacentHTML('beforeend', helpHtml);
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 12px;
            color: #dc3545;
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        #discountPreview {
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        @media (max-width: 768px) {
            .input-group {
                flex-wrap: wrap;
            }

            .input-group button {
                margin-top: 5px;
                width: 100%;
            }
        }
    </style>
@endsection
