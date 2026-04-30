@extends('admin.layouts.master')

@section('content')

    <div class="container mt-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('property_group.update',$property_groups->id) }}">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-lg-8">

                    <div class="widget-content widget-content-area p-4">

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="form-label">نام گروه ویژگی</label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title',$property_groups->title) }}"
                                   placeholder="مثال: مشخصات فنی">
                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="widget-content widget-content-area p-4">

                        {{-- Category --}}
                        <div class="mb-3">
                            <label class="form-label">دسته‌بندی</label>
                            <select class="form-select" name="category_id" required>
                                <option value="">انتخاب دسته</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <button class="btn btn-primary w-100">
                            بروزرسانی گروه ویژگی
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection
