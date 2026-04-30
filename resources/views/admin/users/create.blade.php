@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h6 class="card-title">ایجاد کاربر</h6>
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
                <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-left" dir="rtl" name="name"
                                   placeholder="نام و نام خانوادگی">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-left" dir="rtl" name="mobile"
                                   placeholder="شماره همراه">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <input type="email" class="form-control text-left" dir="rtl" name="email"
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
