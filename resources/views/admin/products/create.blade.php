@extends('admin.layouts.master')
@section('content')

    <div class="container mt-4">

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="widget-content widget-content-area ecommerce-create-section p-3">

                        {{-- Title --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" name="title" class="form-control" placeholder="عنوان محصول">
                            </div>
                        </div>

                        {{-- English Title --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" name="etitle" class="form-control"
                                       placeholder="Product English Title">
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label class="form-label">توضیحات محصول</label>

                                <div id="product-description" style="height:250px;"></div>
                                <input type="hidden" name="description" id="description">

                            </div>
                        </div>


                        {{-- Images --}}
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label>آپلود عکس محصول</label>
                                <input type="file" name="image[]" id="product-images" multiple>
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Sidebar --}}
                <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="row">

                        {{-- Stock + Category --}}
                        <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">
                            <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                <div class="row">
                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label>دسته‌بندی</label>
                                        <select class="form-select" name="category">
                                            @foreach($categories as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label>برند</label>
                                        <select class="form-select" name="brand">
                                            @foreach($brands as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tags --}}
                                    <div class="col-xxl-12 col-lg-6 col-md-12">
                                        <label for="tags-input">Tags</label>
                                        <select class="form-select" name="tags[]">
                                            @foreach($tags as $id => $title)
                                                <option value="{{$id}}">{{$title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>


                            {{-- Pricing --}}
                            <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">
                                <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success w-100">افزودن محصول</button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const quill = new Quill('#product-description', {
                theme: 'snow'
            });

            const form = document.getElementById('productForm');

            form.addEventListener('submit', function () {

                let content = quill.root.innerHTML;

                console.log(content); // برای تست

                document.getElementById('description').value = content;
            });

        });
        // FilePond
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.create(document.querySelector('#product-images'));
    </script>
@endsection




