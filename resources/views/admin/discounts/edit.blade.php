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

        <form id="discountForm" method="POST" action="{{ route('discounts.update', $discount->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="widget-content widget-content-area ecommerce-create-section p-3">

                        {{-- کد تخفیف --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">کد تخفیف <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control"
                                       placeholder="مثال: SUMMER1403"
                                       value="{{ old('code', $discount->code) }}" required>
                                <small class="text-muted">کد تخفیف باید منحصر به فرد باشد</small>
                            </div>
                        </div>

                        {{-- نوع و مقدار تخفیف --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">نوع تخفیف <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" id="discountType" required>
                                    <option value="percent" {{ old('type', $discount->type) == 'percent' ? 'selected' : '' }}>درصدی (%)</option>
                                    <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (تومان)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">مقدار تخفیف <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="value" class="form-control"
                                           placeholder="مقدار تخفیف"
                                           value="{{ old('value', $discount->value) }}" required step="1000">
                                    <span class="input-group-text" id="valueUnit">{{ $discount->type == 'percent' ? '%' : 'تومان' }}</span>
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
                                           value="{{ old('min_order_amount', $discount->min_order_amount) }}" step="1000">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                            <div class="col-md-6" id="maxDiscountContainer" style="{{ $discount->type == 'fixed' ? 'display: none;' : '' }}">
                                <label class="form-label">حداکثر مبلغ تخفیف</label>
                                <div class="input-group">
                                    <input type="number" name="max_discount_amount" class="form-control"
                                           placeholder="حداکثر تخفیف قابل اعمال"
                                           value="{{ old('max_discount_amount', $discount->max_discount_amount) }}" step="1000">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>

                        {{-- محدودیت تعداد استفاده --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">محدودیت تعداد استفاده</label>
                                <input type="number" name="usage_limit" class="form-control"
                                       placeholder="حداکثر تعداد دفعات استفاده (اختیاری)"
                                       value="{{ old('usage_limit', $discount->usage_limit) }}" min="1">
                                <small class="text-muted">تعداد استفاده شده: {{ $discount->used_count }} بار</small>
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
                                               value="{{ old('starts_at', $discount->starts_at ? \Carbon\Carbon::parse($discount->starts_at)->format('Y-m-d\TH:i') : '') }}">
                                    </div>

                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label class="form-label">تاریخ انقضا</label>
                                        <input type="datetime-local" name="expires_at" class="form-control"
                                               value="{{ old('expires_at', $discount->expires_at ? \Carbon\Carbon::parse($discount->expires_at)->format('Y-m-d\TH:i') : '') }}">
                                    </div>
                                </div>

                                {{-- وضعیت فعال/غیرفعال --}}
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   name="is_active" value="1"
                                                   id="isActive" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isActive">
                                                فعال بودن کد تخفیف
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- دکمه‌ها --}}
                            <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">
                                <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="ti-save"></i>
                                                به‌روزرسانی کد تخفیف
                                            </button>
                                        </div>
                                        <div class="col-sm-12">
                                            <a href="{{ route('discounts.index') }}" class="btn btn-outline-danger w-100">
                                                <i class="ti-close"></i>
                                                انصراف
                                            </a>
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

            const discountType = document.getElementById('discountType');
            const valueUnit = document.getElementById('valueUnit');
            const valueInput = document.querySelector('input[name="value"]');
            const maxDiscountContainer = document.getElementById('maxDiscountContainer');

            function updateValueUnit() {
                if (discountType.value === 'percent') {
                    valueUnit.textContent = '%';
                    valueInput.placeholder = 'مثال: 15 (درصد)';
                    valueInput.step = '1';
                    if (maxDiscountContainer) {
                        maxDiscountContainer.style.display = 'block';
                    }
                } else {
                    valueUnit.textContent = 'تومان';
                    valueInput.placeholder = 'مثال: 50000 (تومان)';
                    valueInput.step = '1000';
                    if (maxDiscountContainer) {
                        maxDiscountContainer.style.display = 'none';
                    }
                }
            }

            if (discountType) {
                discountType.addEventListener('change', updateValueUnit);
            }

            // اعتبارسنجی فرم
            const form = document.getElementById('discountForm');

            form.addEventListener('submit', function(e) {
                let isValid = true;
                const code = document.querySelector('input[name="code"]')?.value.trim();
                const value = parseFloat(valueInput?.value);

                if (!code || code.length < 3) {
                    alert('کد تخفیف معتبر وارد کنید');
                    isValid = false;
                }

                if (!value || value <= 0) {
                    alert('مقدار تخفیف باید بزرگتر از 0 باشد');
                    isValid = false;
                }

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
        });
    </script>
@endsection
