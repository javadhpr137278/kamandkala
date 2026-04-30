@extends('admin.layouts.master')

@section('content')

    <div class="middle-content container-xxl py-3">

        <div class="row">

            {{-- RIGHT : CREATE FORM --}}
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">ایجاد گروه ویژگی</h6>

                        @if(session('message'))
                            <div class="alert alert-info">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('property_group.store') }}">
                            @csrf

                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label">نام گروه ویژگی</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       placeholder="مثال: مشخصات فنی"
                                       required>
                            </div>

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
                                ثبت گروه ویژگی
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

                                <thead class="thead-light">
                                <tr>

                                    <th class="text-center text-primary">#</th>
                                    <th class="text-center text-primary">نام گروه ویژگی</th>
                                    <th class="text-center text-primary">دسته بندی</th>
                                    <th class="text-center text-primary">ویرایش</th>
                                    <th class="text-center text-primary">حذف</th>

                                </tr>
                                </thead>

                                <tbody>

                                @foreach($property_groups as $property_group)

                                    <tr>

                                        <td class="text-center align-middle">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="text-center align-middle">
                                            {{ $property_group->title }}
                                        </td>

                                        <td class="text-center align-middle">
                                            {{ $property_group->category->title ?? '-' }}
                                        </td>

                                        <td class="text-center align-middle">

                                            <a href="{{ route('property_group.edit',$property_group->id) }}"
                                               class="btn btn-outline-info btn-sm">
                                                ویرایش
                                            </a>

                                        </td>

                                        <td class="text-center align-middle">

                                            <form action="{{ route('property_group.destroy',$property_group->id) }}"
                                                  method="POST"
                                                  style="display:inline">

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
