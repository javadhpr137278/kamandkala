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
                    <div class="col-sm-12">

                        <a href="{{route('products.index')}}" class="btn btn-danger">
                            بازگشت به محصولات
                        </a>

                    </div>
                </div>

                <table class="table table-bordered table-striped">

                    <thead class="thead-light">
                    <tr>

                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">عکس</th>
                        <th class="text-center text-primary">نام محصول</th>
                        <th class="text-center text-primary">قیمت</th>
                        <th class="text-center text-primary">دسته بندی</th>
                        <th class="text-center text-primary">برند</th>
                        <th class="text-center text-primary">بازیابی</th>
                        <th class="text-center text-primary">حذف کامل</th>

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
                                {{ $product->price_formatted }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $product->category->title ?? '-' }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $product->brand->title ?? '-' }}
                            </td>

                            <td class="text-center align-middle">

                                <form action="{{ route('products.restore',$product->id) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-outline-info btn-sm">
                                        بازیابی
                                    </button>

                                </form>

                            </td>

                            <td class="text-center align-middle">

                                <form action="{{ route('products.forceDelete',$product->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-sm">
                                        حذف کامل
                                    </button>

                                </form>

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
