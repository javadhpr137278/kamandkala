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

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label">عنوان جستجو</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-left" dir="rtl" wire:model="search">
                    </div>
                    <div class="col-sm-2 d-flex justify-content-evenly align-items-center text-center">
                        <a href="{{route('tags.trashed')}}" class="btn btn-outline-info mx-2">
                            <i class="ti-trash"></i>
                        </a>
                        <a href="{{route('tags.create')}}" class="btn btn-outline-info mx-2">
                            <i class="ti-plus"></i>
                        </a>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">عنوان تگ</th>
                        <th class="text-center text-primary">ویرایش</th>
                        <th class="text-center text-primary">حذف</th>
                        <th class="text-center text-primary">تاریخ ایجاد</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($tags as $tag)
                        <tr>

                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $tag->title }}
                            </td>

                            <td class="text-center align-middle">
                                <a href="{{ route('tags.edit',$tag->id) }}"
                                   class="btn btn-outline-info btn-sm">
                                    ویرایش
                                </a>
                            </td>

                            <td class="text-center align-middle">

                                @if(!$tag->deleted_at)
                                    <form action="{{ route('tags.destroy',$tag->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-outline-danger btn-sm">
                                            حذف
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-danger">حذف شده</span>
                                @endif

                            </td>

                            <td class="text-center align-middle">
                                {{ verta($tag->created_at)->format('Y/m/d') }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $tags->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
