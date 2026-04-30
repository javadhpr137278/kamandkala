@extends('admin.layouts.master')

@section('content')

    <div class="container mt-4">

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
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

        <form id="giftCardForm" method="POST" action="{{ route('gift-cards.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="widget-content widget-content-area ecommerce-create-section p-3">

                        {{-- موجودی اولیه --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">موجودی اولیه <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="initial_balance" class="form-control"
                                           placeholder="مبلغ کارت هدیه به تومان"
                                           value="{{ old('initial_balance') }}" required step="1000" min="1000">
                                    <span class="input-group-text">تومان</span>
                                </div>
                                <small class="text-muted">حداقل مبلغ ۱,۰۰۰ تومان</small>
                            </div>
                        </div>

                        {{-- اختصاص به کاربر (اختیاری) --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">اختصاص به کاربر (اختیاری)</label>
                                <select name="user_id" class="form-select">
                                    <option value="">بدون اختصاص به کاربر خاص</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->mobile ?? $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">در صورت انتخاب کاربر، این کارت هدیه فقط توسط آن کاربر قابل استفاده است</small>
                            </div>
                        </div>

                        {{-- توضیحات (اختیاری) --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">توضیحات (اختیاری)</label>
                                <textarea name="description" class="form-control" rows="3"
                                          placeholder="توضیحات مربوط به کارت هدیه...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="row">

                        <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">
                            <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                {{-- تاریخ انقضا --}}
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label class="form-label">تاریخ انقضا (اختیاری)</label>
                                        <input type="datetime-local" name="expires_at" class="form-control"
                                               value="{{ old('expires_at') }}">
                                        <small class="text-muted">اگر خالی بماند، کارت هدیه تاریخ انقضا ندارد</small>
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
                                                فعال بودن کارت هدیه
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
                                                ایجاد کارت هدیه
                                            </button>
                                        </div>
                                        <div class="col-sm-12">
                                            <a href="{{ route('gift-cards.index') }}" class="btn btn-outline-danger w-100">
                                                <i class="ti-close"></i>
                                                انصراف
                                            </a>
                                        </div>
                                    </div>

                                    {{-- پیش‌نمایش کارت هدیه --}}
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <div class="alert alert-info" id="giftCardPreview">
                                                <strong><i class="ti-gift"></i> پیش‌نمایش:</strong>
                                                <div id="previewText" class="mt-2">
                                                    <span>کد: <strong id="previewCode">------</strong></span><br>
                                                    <span>مبلغ: <strong id="previewAmount">0</strong> تومان</span>
                                                </div>
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

            // پیش‌نمایش مبلغ
            const balanceInput = document.querySelector('input[name="initial_balance"]');
            const previewAmount = document.getElementById('previewAmount');
            const previewCode = document.getElementById('previewCode');

            // تولید کد پیش‌نمایش تصادفی
            function generatePreviewCode() {
                return 'GC-' + Math.random().toString(36).substring(2, 10).toUpperCase();
            }

            previewCode.textContent = generatePreviewCode();

            function updatePreview() {
                let amount = balanceInput?.value || 0;
                previewAmount.textContent = Number(amount).toLocaleString('fa-IR');

                if (amount >= 1000) {
                    previewAmount.parentElement.parentElement.parentElement.classList.remove('alert-info');
                    previewAmount.parentElement.parentElement.parentElement.classList.add('alert-success');
                } else {
                    previewAmount.parentElement.parentElement.parentElement.classList.remove('alert-success');
                    previewAmount.parentElement.parentElement.parentElement.classList.add('alert-info');
                }
            }

            if (balanceInput) {
                balanceInput.addEventListener('input', updatePreview);
                updatePreview();
            }

            // هر بار که کاربر تغییر می‌دهد، کد پیش‌نمایش به‌روز می‌شود
            setInterval(function() {
                if (document.activeElement !== balanceInput) {
                    previewCode.textContent = generatePreviewCode();
                }
            }, 3000);

            // اعتبارسنجی فرم
            const form = document.getElementById('giftCardForm');

            form.addEventListener('submit', function(e) {
                const balance = parseFloat(balanceInput?.value);

                if (!balance || balance < 1000) {
                    e.preventDefault();
                    alert('موجودی کارت هدیه باید حداقل ۱,۰۰۰ تومان باشد');
                    balanceInput?.focus();
                    return false;
                }

                const expiresAt = document.querySelector('input[name="expires_at"]')?.value;
                if (expiresAt && new Date(expiresAt) < new Date()) {
                    e.preventDefault();
                    alert('تاریخ انقضا نمی‌تواند در گذشته باشد');
                    return false;
                }
            });

            // راهنمای سریع
            const helpHtml = `
                <div class="alert alert-warning mt-3">
                    <strong><i class="ti-info-alt"></i> نکات مهم:</strong>
                    <ul class="mb-0 mt-2">
                        <li>کد کارت هدیه به صورت خودکار و یکتا تولید می‌شود</li>
                        <li>حداقل مبلغ کارت هدیه ۱,۰۰۰ تومان است</li>
                        <li>در صورت اختصاص به کاربر، فقط آن کاربر می‌تواند استفاده کند</li>
                        <li>کارت هدیه پس از استفاده کامل، به صورت خودکار غیرفعال می‌شود</li>
                        <li>می‌توانید تاریخ انقضا تعیین کنید یا نامحدود بگذارید</li>
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

        #giftCardPreview {
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        #previewCode {
            font-family: monospace;
            font-size: 14px;
            letter-spacing: 1px;
        }
    </style>
@endsection
