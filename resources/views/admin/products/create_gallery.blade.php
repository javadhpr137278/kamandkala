@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-12 layout-spacing layout-top-spacing">
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

        </div>
        <div class="middle-content container-xxl">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title"> ایجاد گالری محصول {{$product->title}} </h6>
                        <form class="dropzone border border-primary" method="POST" action="{{route('galleries.store',$product->id)}}">
                            @csrf
                            <div class="form-group row">
                                <div class="fallback">
                                    <input type="file" name="image" multiple>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="middle-content container-xxl py-3">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">

                            <thead class="thead-light">
                            <tr>

                                <th class="text-center text-primary">#</th>
                                <th class="text-center text-primary">عکس</th>
                                <th class="text-center text-primary">حذف</th>

                            </tr>
                            </thead>


                            <tbody>

                            @foreach($galleries as $gallery)

                                <tr>

                                    <td class="text-center align-middle">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td class="text-center align-middle">

                                        @if($gallery->image)

                                            <img
                                                src="{{ asset('/storage/'.$gallery->image) }}"
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

                                        <form action="{{ route('galleries.delete', [$product->id, $gallery->id]) }}"
                                              method="POST"
                                              style="display:inline;">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger btn-sm">
                                                حذف
                                            </button>

                                        </form>


                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection




