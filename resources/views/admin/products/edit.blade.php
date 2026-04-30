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

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <form id="productForm" method="POST" action="{{ route('products.update',$product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="widget-content widget-content-area ecommerce-create-section p-3">

                        {{-- Title --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title',$product->title) }}" placeholder="عنوان محصول">
                            </div>
                        </div>

                        {{-- English Title --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" name="etitle" class="form-control"
                                       value="{{ old('etitle',$product->etitle) }}"
                                       placeholder="Product English Title">
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="row mb-4">
                            <div class="col-sm-12">

                                <label class="form-label">توضیحات محصول</label>

                                <div id="product-description" style="height:250px;">
                                    {!! old('description',$product->description) !!}
                                </div>

                                <input type="hidden" name="description" id="description">

                            </div>
                        </div>

                        {{-- Current Image --}}
                        @if($product->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/products/'.$product->image) }}" width="120">
                            </div>
                        @endif

                        {{-- Images --}}
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label>آپلود عکس جدید</label>
                                <input type="file" name="image[]" id="product-images" multiple>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Sidebar --}}
                <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <div class="row">

                        <div class="col-xxl-12 col-xl-8 col-lg-8 col-md-7 mt-xxl-0 mt-4">

                            <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                <div class="row">

                                    {{-- Category --}}
                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label>دسته‌بندی</label>
                                        <select class="form-select" name="category">

                                            @foreach($categories as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $product->category_id == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    {{-- Brand --}}
                                    <div class="col-xxl-12 col-md-6 mb-4">
                                        <label>برند</label>
                                        <select class="form-select" name="brand">

                                            @foreach($brands as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $product->brand_id == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>


                                    {{-- Tags --}}
                                    <div class="col-xxl-12 col-lg-6 col-md-12">
                                        <label>Tags</label>

                                        <select class="form-select" name="tags[]" multiple>

                                            @foreach($tags as $id => $title)

                                                <option value="{{$id}}"
                                                    {{ $product->tags->contains($id) ? 'selected' : '' }}>
                                                    {{$title}}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>
                            </div>


                            {{-- Price --}}
                            <div class="col-xxl-12 col-xl-4 col-lg-4 col-md-5 mt-4">

                                <div class="widget-content widget-content-area ecommerce-create-section p-3">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary w-100">Update Product</button>
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

                            document.getElementById('description').value =
                                quill.root.innerHTML;

                        });

                    });

                    FilePond.registerPlugin(FilePondPluginImagePreview);
                    FilePond.create(document.querySelector('#product-images'));

                </script>

@endsection
