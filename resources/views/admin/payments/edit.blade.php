{{-- resources/views/admin/payment_gateways/edit.blade.php --}}
@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ویرایش درگاه پرداخت: {{ $paymentGateway->title }}</h4>
                    <a href="{{ route('payment-gateways.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left"></i> بازگشت
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('payment-gateways.update', $paymentGateway->id) }}" method="POST" id="gateway-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">نام سیستم</label>
                                    <input type="text"
                                           class="form-control"
                                           value="{{ strtoupper($paymentGateway->name) }}"
                                           disabled>
                                    <small class="form-text text-muted">نام سیستم غیرقابل تغییر است</small>
                                    <input type="hidden" name="name" value="{{ $paymentGateway->name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان نمایشی <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', $paymentGateway->title) }}"
                                           required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control"
                                              rows="2">{{ old('description', $paymentGateway->description) }}</textarea>
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
                                            {{-- فیلدهای پیکربندی با جاوااسکریپت پر می‌شوند --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sandbox">حالت آزمایشی</label>
                                    <select name="sandbox" id="sandbox" class="form-control">
                                        <option value="0" {{ old('sandbox', $paymentGateway->config['sandbox'] ?? 0) == '0' ? 'selected' : '' }}>غیرفعال (واقعی)</option>
                                        <option value="1" {{ old('sandbox', $paymentGateway->config['sandbox'] ?? 0) == '1' ? 'selected' : '' }}>فعال (تست)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="is_active">وضعیت درگاه</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="0" {{ old('is_active', $paymentGateway->is_active) == '0' ? 'selected' : '' }}>غیرفعال</option>
                                        <option value="1" {{ old('is_active', $paymentGateway->is_active) == '1' ? 'selected' : '' }}>فعال</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>تاریخ ایجاد</label>
                                    <input type="text" class="form-control" value="{{ verta($paymentGateway->created_at)->format('Y/m/d H:i') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-save"></i> بروزرسانی
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

            // نمایش فیلدهای پیکربندی
            function loadConfigFields(gateway, oldConfig = {}) {
                const container = $('#gateway-config-fields');
                let html = '';

                const configs = {
                    zarinpal: {
                        fields: [
                            { name: 'merchant_id', label: 'Merchant ID', type: 'text', required: true, placeholder: 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    idpay: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'sandbox_api_key', label: 'API Key تست', type: 'text', required: false, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    zibal: {
                        fields: [
                            { name: 'merchant', label: 'Merchant Code', type: 'text', required: true, placeholder: 'zibal' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    payir: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    nextpay: {
                        fields: [
                            { name: 'api_key', label: 'API Key', type: 'text', required: true, placeholder: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    saman: {
                        fields: [
                            { name: 'merchant_id', label: 'Merchant ID', type: 'text', required: true, placeholder: 'xxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    parsian: {
                        fields: [
                            { name: 'pin', label: 'PIN', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    },
                    paypal: {
                        fields: [
                            { name: 'client_id', label: 'Client ID', type: 'text', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'client_secret', label: 'Client Secret', type: 'password', required: true, placeholder: 'xxxxxxxxxxxxxxxxxxxx' },
                            { name: 'callback_url', label: 'URL بازگشت', type: 'url', required: true, placeholder: 'https://yourdomain.com/payment/verify' }
                        ]
                    }
                };

                const config = configs[gateway];

                if (config) {
                    config.fields.forEach(field => {
                        const value = oldConfig[field.name] || '';
                        html += `
                    <div class="form-group">
                        <label for="config_${field.name}">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="${field.type}"
                               name="config[${field.name}]"
                               id="config_${field.name}"
                               class="form-control"
                               placeholder="${field.placeholder}"
                               value="${value.replace(/"/g, '&quot;')}"
                               ${field.required ? 'required' : ''}>
                        <small class="form-text text-muted">${field.placeholder}</small>
                    </div>
                `;
                    });
                }

                container.html(html);
            }

            // بارگذاری پیکربندی موجود
            const gateway = '{{ $paymentGateway->name }}';
            const oldConfig = @json($paymentGateway->config ?? []);
            loadConfigFields(gateway, oldConfig);

            // اعتبارسنجی فرم
            $('#gateway-form').submit(function(e) {
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
