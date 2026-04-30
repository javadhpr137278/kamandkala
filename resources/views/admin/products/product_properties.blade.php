@extends('admin.layouts.master')

@section('content')

    <div class="middle-content container-xxl py-3">

        <div class="row">

            {{-- RIGHT : CREATE FORM --}}
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">ایجاد ویژگی محصول</h6>

                        @if(session('message'))
                            <div class="alert alert-info">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('store.product.properties',$product->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">نام ویژگی</label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    placeholder="مثال: وزن"
                                    required
                                >

                            </div>

                            <div class="mb-3">
                                <label class="form-label">گروه ویژگی</label>

                                <select class="form-select" name="property_group_id" required>

                                    <option value="">انتخاب گروه</option>

                                    @foreach($property_groups as $group)

                                        <option value="{{ $group->id }}">
                                            {{ $group->title }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <button class="btn btn-primary w-100">
                                ثبت ویژگی
                            </button>

                        </form>

                    </div>
                </div>

            </div>


            {{-- LEFT : TABLE --}}
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>
                                <tr>

                                    <th class="text-center">#</th>
                                    <th class="text-center">نام ویژگی</th>
                                    <th class="text-center">گروه ویژگی</th>
                                    <th class="text-center">ویرایش</th>
                                    <th class="text-center">حذف</th>

                                </tr>
                                </thead>

                                <tbody>

                                @foreach($properties as $property)

                                    <tr>

                                        <td class="text-center align-middle">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            {{ $property->title }}
                                        </td>

                                        <td class="text-center align-middle">
                                            {{ $property->propertyGroup->title ?? '-' }}
                                        </td>

                                        <td class="text-center align-middle">

                                            <a href="{{ route('property.edit',$property->id) }}"
                                               class="btn btn-outline-info btn-sm">
                                                ویرایش
                                            </a>

                                        </td>

                                        <td class="text-center align-middle">

                                            <form
                                                action="{{ route('property.destroy',$property->id) }}"
                                                method="POST"
                                                style="display:inline"
                                            >

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

    </div>

@endsection
