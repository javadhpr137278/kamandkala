@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">لیست دسته‌بندی‌ها</h3>
                        <div class="card-tools">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">ایجاد دسته جدید</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>عنوان انگلیسی</th>
                                    <th>تصویر</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            {{ $category->title }}
                                            @if($category->parent_id == 0)
                                                <span class="badge badge-primary">اصلی</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->etitle }}</td>
                                        <td>
                                            @if($category->image && Storage::disk('public')->exists($category->image))
                                                <img src="{{ Storage::url($category->image) }}"
                                                     alt="{{ $category->title }}"
                                                     width="60"
                                                     height="60"
                                                     style="object-fit: cover; border-radius: 5px;">
                                            @else
                                                <span class="text-muted">بدون تصویر</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">ویرایش</a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئنید؟')">حذف</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @if($category->children->count())
                                        @foreach($category->children as $child)
                                            <tr style="background-color:#f9f9f9">
                                                <td>{{ $child->id }}</td>
                                                <td>↳ {{ $child->title }} <span class="badge badge-secondary">زیردسته</span></td>
                                                <td>{{ $child->etitle }}</td>
                                                <td>
                                                    @if($child->image && Storage::disk('public')->exists($child->image))
                                                        <img src="{{ Storage::url($child->image) }}"
                                                             alt="{{ $child->title }}"
                                                             width="60"
                                                             height="60"
                                                             style="object-fit: cover; border-radius: 5px;">
                                                    @else
                                                        <span class="text-muted">بدون تصویر</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('categories.edit', $child->id) }}" class="btn btn-info btn-sm">ویرایش</a>
                                                    <form action="{{ route('categories.destroy', $child->id) }}" method="POST" style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئنید؟')">حذف</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
