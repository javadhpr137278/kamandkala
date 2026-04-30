@extends('admin.layouts.master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>خطا!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            <div class="card shadow-sm border-0">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti-tag"></i>
                        ایجاد برند جدید
                    </h5>
                </div>


                <div class="card-body">

                    <form method="POST"
                          action="{{route('brands.store')}}"
                          enctype="multipart/form-data">

                        @csrf


                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                عنوان برند
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="مثلاً: Samsung">

                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                آپلود لوگو برند
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{route('brands.index')}}"
                               class="btn btn-outline-secondary">

                                بازگشت

                            </a>


                            <button type="submit"
                                    class="btn btn-success px-4">

                                <i class="ti-check"></i>
                                ذخیره برند

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>
    </div>

@endsection
