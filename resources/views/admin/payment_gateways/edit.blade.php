@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ویرایش درگاه: {{ $payment_gateway->title }}</h4>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>خطا!</strong> لطفاً موارد زیر را اصلاح کنید:
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('payment-gateways.update', $payment_gateway->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>نام سیستم (فقط خواندنی)</label>
                            <input type="text" class="form-control" value="{{ $payment_gateway->name }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>عنوان نمایشی</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $payment_gateway->title) }}">
                        </div>

                        <div class="form-group">
                            <label>Merchant</label>
                            <input type="text" name="merchant" class="form-control"
                                   value="{{ old('merchant', $payment_gateway->config['merchant'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label>Callback URL</label>
                            <input type="text" name="callback_url" class="form-control"
                                   value="{{ old('callback_url', $payment_gateway->config['callback_url'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label>وضعیت</label>
                            <select name="is_active" class="form-control">
                                <option value="0" {{ !$payment_gateway->is_active ? 'selected' : '' }}>غیرفعال</option>
                                <option value="1" {{ $payment_gateway->is_active ? 'selected' : '' }}>فعال</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="ti-check"></i>
                            ذخیره تغییرات
                        </button>

                        <a href="{{ route('payment-gateways.index') }}" class="btn btn-secondary mt-3">
                            بازگشت
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
