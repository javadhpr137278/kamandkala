@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ایجاد درگاه پرداخت جدید</h4>
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

                    <form action="{{ route('payment-gateways.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>نام سیستم (zibal, zarinpal, idpay ...)</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" placeholder="مثال: zibal">
                        </div>

                        <div class="form-group">
                            <label>عنوان نمایشی</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title') }}" placeholder="مثال: درگاه زیبال">
                        </div>

                        <div class="form-group">
                            <label>Merchant</label>
                            <input type="text" name="merchant" class="form-control"
                                   value="{{ old('merchant') }}" placeholder="کد مرچنت">
                        </div>

                        <div class="form-group">
                            <label>Callback URL</label>
                            <input type="text" name="callback_url" class="form-control"
                                   value="{{ old('callback_url') }}" placeholder="مثال: https://example.com/callback/zibal">
                        </div>

                        <div class="form-group">
                            <label>وضعیت</label>
                            <select name="is_active" class="form-control">
                                <option value="0">غیرفعال</option>
                                <option value="1">فعال</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="ti-check"></i>
                            ذخیره درگاه
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
