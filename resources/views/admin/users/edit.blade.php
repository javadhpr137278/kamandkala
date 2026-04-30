@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h6 class="card-title">ویرایش کاربر</h6>
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
                <form method="POST" action="{{route('users.update', $user)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-left" dir="rtl" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="نام و نام خانوادگی">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-left" dir="rtl" name="mobile"
                                   placeholder="شماره همراه"
                                   value="{{ old('mobile', $user->mobile) }}"
                            >
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="email" class="form-control text-left" dir="rtl" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="ایمیل">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password"
                                   placeholder="Confirm Password *">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            @if ($user->image)
                                <div class="mt-2">
                                    <img src="{{ $user->getImageUrlAttribute() }}" alt="تصویر فعلی" width="100">
                                </div>
                            @endif
                            <div class="multiple-file-upload">
                                <input type="file"
                                       class="filepond file-upload-multiple"
                                       name="image"
                                       multiple
                                       data-allow-reorder="true"
                                       data-max-file-size="3MB"
                                       data-max-files="3">
                            </div>
                            <script>
                                /**
                                 * ====================
                                 * Multiple File Upload
                                 * ====================
                                 */

                                // We want to preview images, so we register
                                // the Image Preview plugin, We also register
                                // exif orientation (to correct mobile image
                                // orientation) and size validation, to prevent
                                // large files from being added
                                FilePond.registerPlugin(
                                    FilePondPluginImagePreview,
                                    FilePondPluginImageExifOrientation,
                                    FilePondPluginFileValidateSize,
                                    // FilePondPluginImageEdit
                                );

                                // Select the file input and use
                                // create() to turn it into a pond
                                FilePond.create(
                                    document.querySelector('.file-upload-multiple')
                                );
                            </script>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">ویرایش</button>
                </form>
            </div>
        </div>
    </div>
@endsection
