@extends('admin.layouts.master')

@section('content')

    <div class="row">
        @if(session('message'))
            <div class="alert alert-info">
                <div>{{ session('message') }}</div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <div class="form-group row mb-4 pt-2">
                    <div class="col-sm-12 d-flex justify-content-start align-items-center text-center">

                        <a href="{{route('products.trashed')}}" class="btn btn-outline-danger">
                            سطل زباله
                            <i class="ti-trash px-2"></i>
                        </a>

                        <a href="{{route('products.create')}}" class="btn btn-outline-info mx-2">
                            <i class="ti-plus"></i>
                        </a>

                    </div>
                </div>


                <table class="table table-bordered table-striped">

                    <thead class="thead-light">
                    <tr>

                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">عکس</th>
                        <th class="text-center text-primary">نام محصول</th>
                        <th class="text-center text-primary">دسته بندی</th>
                        <th class="text-center text-primary">تنوع قیمت</th>
                        <th class="text-center text-primary">ویژگی محصول</th>
                        <th class="text-center text-primary">گالری محصول</th>
                        <th class="text-center text-primary">ویرایش</th>
                        <th class="text-center text-primary">حذف</th>
                        <th class="text-center text-primary">تاریخ ایجاد</th>

                    </tr>
                    </thead>


                    <tbody>

                    @foreach($products as $product)

                        <tr>

                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>


                            <td class="text-center align-middle">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/products/'.$product->image) }}"
                                        width="60"
                                        height="60"
                                        class="rounded"
                                        alt="{{ $product->title }}"
                                    >

                                @else

                                    <img
                                        src="{{ asset('images/no-image.png') }}"
                                        width="60"
                                        height="60"
                                        class="rounded"
                                    >

                                @endif

                            </td>


                            <td class="text-center align-middle">
                                {{ $product->title }}
                            </td>


                            <td class="text-center align-middle">
                                {{ $product->category->title ?? '-' }}
                            </td>


                            <td class="text-center align-middle" scope="col">

                                <a href="{{ route('variants.index',$product->id) }}"
                                   class="btn btn-outline-info btn-sm">
                                    تنوع ها
                                </a>


                            </td>

                            <td class="text-center align-middle" scope="col">

                                <a href="{{ route('create.product.properties', $product->id) }}"
                                   class="btn btn-outline-warning btn-sm">
                                    ویژگی ها
                                </a>


                            </td>

                            <td class="text-center align-middle" scope="col">

                                <a href="{{route('galleries.create',$product->id)}}"
                                   class="btn btn-outline-info btn-sm">
                                    گالری
                                </a>


                            </td>
                            <td class="text-center align-middle">

                                <a href="{{ route('products.edit',$product->id) }}"
                                   class="btn btn-outline-info btn-sm">

                                    ویرایش

                                </a>

                            </td>


                            <td class="text-center align-middle">

                                <form
                                    action="{{ route('products.destroy',$product->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-sm">

                                        حذف

                                    </button>

                                </form>

                            </td>


                            <td class="text-center align-middle">

                                {{ verta($product->created_at)->format('Y/m/d') }}

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>


                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>


            </div>
        </div>
    </div>

@endsection
