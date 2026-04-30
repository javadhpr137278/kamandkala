@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ایجاد دسته‌بندی جدید</h3>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm float-left">بازگشت</a>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>عنوان (فارسی) <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>عنوان (انگلیسی) <span class="text-danger">*</span></label>
                                <input type="text" name="etitle" class="form-control @error('etitle') is-invalid @enderror" value="{{ old('etitle') }}">
                                @error('etitle')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>دسته والد</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">بدون والد (دسته اصلی)</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}">➜ {{ $child->title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>تصویر دسته‌بندی</label>
                                <div class="custom-file">
                                    <input type="file"
                                           name="image"
                                           class="custom-file-input @error('image') is-invalid @enderror"
                                           id="imageInput"
                                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    <label class="custom-file-label" for="imageInput">انتخاب فایل</label>
                                    @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">فرمت‌های مجاز: JPEG, PNG, JPG, GIF, WEBP - حداکثر حجم: 2 مگابایت</small>

                                {{-- پیش‌نمایش تصویر --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label>پیش‌نمایش:</label>
                                    <div>
                                        <img id="preview" src="#" alt="پیش‌نمایش" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // پیش‌نمایش تصویر
            document.getElementById('imageInput').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.getElementById('preview');
                        preview.src = event.target.result;
                        document.getElementById('imagePreview').style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // نمایش نام فایل
            document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                var fileName = e.target.files[0].name;
                var label = e.target.nextElementSibling;
                label.innerHTML = fileName;
            });
        </script>
    @endpush
@endsection
