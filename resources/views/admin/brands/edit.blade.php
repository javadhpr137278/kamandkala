@extends('admin.layouts.master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- خطاها --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>خطا!</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- پیام موفقیت --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            <div class="card shadow-sm border-0">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti-pencil"></i>
                        ویرایش برند
                    </h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('brands.update', $brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- عنوان برند --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">عنوان برند</label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $brand->title) }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="عنوان برند را وارد کنید">

                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- آپلود تصویر --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">آپلود عکس</label>

                            <input type="file"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- نمایش تصویر فعلی --}}
                            @if ($brand->image)
                                <div class="mt-3">
                                    <p class="mb-1 text-muted">تصویر فعلی:</p>
                                    <img src="{{ asset('storage/brands/'.$brand->image) }}"
                                         class="img-thumbnail"
                                         width="120">
                                </div>
                            @endif
                        </div>

                        {{-- دکمه‌ها --}}
                        <div class="d-flex justify-content-between">

                            <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                                بازگشت
                            </a>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="ti-check"></i>
                                ذخیره تغییرات
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

@endsection
