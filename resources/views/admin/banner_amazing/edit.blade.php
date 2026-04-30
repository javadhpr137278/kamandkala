@extends('admin.layouts.master')

@section('content')
    @php
        $colors = $banner->colors ?? [];
    @endphp

    <div class="container">

        <h3 class="mb-4">ویرایش بنر صفحه اصلی</h3>

        <form action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>عنوان محصول</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title',$banner->title ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>درصد تخفیف</label>
                    <input type="number" name="discount_percent" class="form-control"
                           value="{{ old('discount_percent',$banner->discount_percent ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاریخ شروع</label>
                    <input type="text" name="start_date" class="form-control"
                           value="{{ old('start_date',$banner->start_date ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاریخ پایان</label>
                    <input type="text" name="end_date" class="form-control"
                           value="{{ old('end_date',$banner->end_date ?? '') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>عنوان جشنواره</label>
                    <input type="text" name="festival_title" class="form-control"
                           value="{{ old('festival_title',$banner->festival_title ?? '') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>توضیحات جشنواره</label>
                    <textarea name="festival_description" class="form-control" rows="4">{{ old('festival_description',$banner->festival_description ?? '') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>متن دکمه</label>
                    <input type="text" name="button_text" class="form-control"
                           value="{{ old('button_text',$banner->button_text ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>لینک دکمه</label>
                    <input type="text" name="button_link" class="form-control"
                           value="{{ old('button_link',$banner->button_link ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>زمان پایان تایمر</label>
                    <input type="datetime-local" name="countdown_end" class="form-control"
                           value="{{ isset($banner->countdown_end) ? $banner->countdown_end->format('Y-m-d\TH:i') : '' }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تصویر بنر</label>
                    <input type="file" name="image" class="form-control">
                </div>

                @if(isset($banner->image))
                    <div class="col-md-12 mb-3">
                        <img src="{{ asset('storage/'.$banner->image) }}" width="200">
                    </div>
                @endif

            </div>

            <hr>

            <h5 class="mb-3">پالت رنگ</h5>

            <div class="row">

                <div class="col-md-3 mb-3">
                    <input type="color" name="colors[]" class="form-control form-control-color"
                           value="{{ $banner->colors[0] ?? '#3E2F23' }}">
                </div>

                <div class="col-md-3 mb-3">
                    <input type="color" name="colors[]" class="form-control form-control-color"
                           value="{{ $banner->colors[1] ?? '#7A8450' }}">
                </div>

                <div class="col-md-3 mb-3">
                    <input type="color" name="colors[]" class="form-control form-control-color"
                           value="{{ $banner->colors[2] ?? '#508481' }}">
                </div>

                <div class="col-md-3 mb-3">
                    <input type="color" name="colors[]" class="form-control form-control-color"
                           value="{{ $banner->colors[3] ?? '#1D2977' }}">
                </div>

            </div>

            <button class="btn btn-primary mt-3">
                ذخیره تغییرات
            </button>

        </form>

    </div>

@endsection
