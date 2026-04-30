{{-- resources/views/admin/payment_gateways/create.blade.php --}}
@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ایجاد درگاه پرداخت جدید</h4>
                    <a href="{{ route('payment-gateways.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left"></i> بازگشت
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('payment-gateways.store') }}" method="POST" id="gateway-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">نام سیستم <span class="text-danger">*</span></label>
                                    <select name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                                        <option value="">انتخاب درگاه...</option>
                                        <option value="zarinpal" {{ old('name') == 'zarinpal' ? 'selected' : '' }}>زرین‌پال (Zarinpal)</option>
                                        <option value="idpay" {{ old('name') == 'idpay' ? 'selected' : '' }}>آیدی پی (IDPay)</option>
                                        <option value="zibal" {{ old('name') == 'zibal' ? 'selected' : '' }}>زیبال (Zibal)</option>
                                        <option value="payir" {{ old('name') == 'payir' ? 'selected' : '' }}>پی (Pay.ir)</option>
                                        <option value="nextpay" {{ old('name') == 'nextpay' ? 'selected' : '' }}>نکست پی (NextPay)</option>
                                        <option value="saman" {{ old('name') == 'saman' ? 'selected' : '' }}>سامان (Saman)</option>
                                        <option value="parsian" {{ old('name') == 'parsian' ? 'selected' : '' }}>پارسیان (Parsian)</option>
                                        <option value="paypal" {{ old('name') == 'paypal' ? 'selected' : '' }}>پی‌پال (PayPal)</option>
                                    </select>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">نام یکتای درگاه در سیستم (غیرقابل تغییر بعد از ایجاد)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان نمایشی <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}"
                                           placeholder="مثال: پرداخت آنلاین (زرین‌پال)"
                                           required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">عنوانی که در صفحه تسویه حساب به کاربر نمایش داده می‌شود</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="2">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">توضیحات اختیاری برای نمایش به کاربر</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">تنظیمات درگاه</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="gateway-config-fields">
                                            {{-- فیلدهای پویا با جاوااسکریپت پر می‌شوند --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sandbox">حالت آزمایشی</label>
                                    <select name="sandbox" id="sandbox" class="form-control">
                                        <option value="0" {{ old('sandbox') == '0' ? 'selected' : '' }}>غیرفعال (واقعی)</option>
                                        <option value="1" {{ old('sandbox') == '1' ? 'selected' : '' }}>فعال (تست)</option>
                                    </select>
                                    <small class="form-text text-muted">در حالت آزمایشی، تراکنش‌ها واقعی نیستند</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">وضعیت درگاه</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                                    </select>
                                    <small class="form-text text-muted">در صورت فعال بودن، در لیست درگاه‌ها نمایش داده می‌شود</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="agree_terms"
                                               name="agree_terms"
                                               required>
                                        <label class="custom-control-label" for="agree_terms">
                                            اطلاعات وارد شده صحیح است
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-save"></i> ذخیره درگاه
                            </button>
                            <a href="{{ route('payment-gateways.index') }}" class="btn btn-secondary">
                                <i class="ti-close"></i> انصراف
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // نمایش فیلدهای پیکربندی بر اساس درگاه انتخاب شده
            function loadConfigFields(gateway) {
                const container = $('#gateway-config-fields');
                let html = '';

                const configs = {
                    zarinpal: {
                        fields: [
                            { name: 'merchant_id', label: 'Merchant ID', type: 'text', required: true, placeholder: 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت Merchant ID به پنل زرین‌پال مراجعه کنید'
                    },
                    idpay: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'sandbox_api_key', label: 'API Key تست', type: 'text', required: false, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت API Key به پنل آیدی‌پی مراجعه کنید'
                    },
                    zibal: {
                        fields: [
                            { name: 'merchant', label: 'Merchant Code', type: 'text', required: true, placeholder: 'zibal' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'Merchant Code پیش‌فرض "zibal" است'
                    },
                    payir: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت API Key به پنل پی دات آی آر مراجعه کنید'
                    },
                    nextpay: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت API Key به پنل نکست‌پی مراجعه کنید'
                    },
                    saman: {
                        fields: [
                            { name: 'merchant_id', label: 'Merchant ID', type: 'text', required: true, placeholder: 'xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت Merchant ID به پنل بانک سامان مراجعه کنید'
                    },
                    parsian: {
                        fields: [
                            { name: 'pin', label: 'PIN', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت PIN به پنل بانک پارسیان مراجعه کنید'
                    },
                    paypal: {
                        fields: [
                            { name: 'client_id', label: 'Client ID', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'client_secret', label: 'Client Secret', type: 'password', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ],
                        help: 'برای دریافت Client ID و Secret به PayPal Developer مراجعه کنید'
                    }
                };

                const config = configs[gateway];

                if (config) {
                    html += '<div class="alert alert-info">';
                    html += '<i class="ti-info-alt"></i> ' + config.help;
                    html += '</div>';

                    config.fields.forEach(field => {
                        html += `
                    <div class="form-group">
                        <label for="config_${field.name}">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="${field.type}"
                               name="config[${field.name}]"
                               id="config_${field.name}"
                               class="form-control"
                               placeholder="${field.placeholder}"
                               ${field.required ? 'required' : ''}>
                        <small class="form-text text-muted">${field.placeholder}</small>
                    </div>
                `;
                    });
                } else {
                    html = '<div class="alert alert-warning">لطفاً یک درگاه را انتخاب کنید</div>';
                }

                container.html(html);
            }

            // هنگام تغییر درگاه
            $('#name').change(function() {
                const gateway = $(this).val();
                if (gateway) {
                    loadConfigFields(gateway);
                } else {
                    $('#gateway-config-fields').html('<div class="alert alert-info">لطفاً یک درگاه را انتخاب کنید</div>');
                }
            });

            // اگر مقدار قدیمی وجود داشت
            const oldGateway = $('#name').val();
            if (oldGateway) {
                loadConfigFields(oldGateway);
            }

            // اعتبارسنجی فرم
            $('#gateway-form').submit(function(e) {
                const gateway = $('#name').val();
                if (!gateway) {
                    e.preventDefault();
                    toastr.error('لطفاً یک درگاه را انتخاب کنید');
                    return false;
                }

                // بررسی فیلدهای مورد نیاز
                let isValid = true;
                $('input[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    toastr.error('لطفاً تمام فیلدهای required را پر کنید');
                    return false;
                }
            });

        });
    </script>
@endpush
