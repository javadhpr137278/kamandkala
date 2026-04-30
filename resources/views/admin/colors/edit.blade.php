@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h6 class="card-title">ویرایش رنگ</h6>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- نمایش پیام موفقیت --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('colors.update', $color->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">عنوان رنگ</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control text-left"
                                   dir="rtl"
                                   name="name"
                                   value="{{ old('name', $color->name) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">کد رنگ</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control text-left"
                                   dir="rtl"
                                   name="code"
                                   value="{{ old('code', $color->code) }}">
                        </div>
                    </div>


                    <div class="form-group row mt-3">
                        <button type="submit" class="btn btn-success">
                            ذخیره تغییرات
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
