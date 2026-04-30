@extends('admin.layouts.master')

@section('content')

    <div class="row">
        @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">

                <div class="form-group row mb-4">

                    <label class="col-sm-2 col-form-label">جستجو</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control"
                               wire:model="search"
                               placeholder="جستجوی برند ...">
                    </div>

                    <div class="col-sm-2 d-flex justify-content-center align-items-center">

                        <a href="{{route('brands.trashed')}}" class="btn btn-outline-danger mx-1">
                            <i class="ti-trash"></i>
                        </a>

                        <a href="{{route('brands.create')}}" class="btn btn-outline-success mx-1">
                            <i class="ti-plus"></i>
                        </a>

                    </div>
                </div>

                <table class="table table-hover table-striped table-bordered">

                    <thead>

                    <tr>

                        <th width="40">
                            <input type="checkbox">
                        </th>
                        <th>
                            عکس
                        </th>

                        <th>برند</th>

                        <th class="text-center">وضعیت</th>

                        <th class="text-center">عملیات</th>

                        <th class="text-center">تاریخ</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($brands as $brand)

                        <tr>

                            <td>
                                <input type="checkbox" value="{{$brand->id}}">
                            </td>
                            <td>
                                <div class="me-3">

                                    @if($brand->image)

                                        <img src="{{ asset('storage/brands/'.$brand->image) }}"
                                             width="50"
                                             height="50"
                                             class="rounded-circle">

                                    @else

                                        <img src="{{ asset('images/no-image.png') }}"
                                             width="50"
                                             height="50"
                                             class="rounded-circle">

                                    @endif

                                </div>
                            </td>

                            <td>

                                <div class="d-flex align-items-center">
                                        <div class="fw-bold">
                                            {{$brand->title}}
                                        </div>
                                </div>

                            </td>

                            <td class="text-center">

                                @if(!$brand->deleted_at)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-danger">حذف شده</span>
                                @endif

                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center">

                                    <a href="{{route('brands.edit',$brand->id)}}"
                                       class="btn btn-sm btn-outline-primary mx-1">
                                        <i class="ti-pencil"></i>
                                    </a>

                                    @if(!$brand->deleted_at)

                                        <a href="#"
                                           class="btn btn-sm btn-outline-danger mx-1"
                                           onclick="event.preventDefault(); if(confirm('حذف شود؟')) document.getElementById('delete-brand-{{$brand->id}}').submit();">

                                            <i class="ti-trash"></i>

                                        </a>

                                        <form id="delete-brand-{{$brand->id}}"
                                              action="{{route('brands.destroy',$brand->id)}}"
                                              method="POST"
                                              style="display:none">

                                            @csrf
                                            @method('DELETE')

                                        </form>

                                    @endif

                                </div>

                            </td>

                            <td class="text-center">

                                {{ verta($brand->created_at)->format('Y/m/d') }}

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="d-flex justify-content-center mt-4">

                    {{ $brands->links() }}

                </div>

            </div>

        </div>
    </div>

@endsection
