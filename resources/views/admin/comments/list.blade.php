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

                </div>

                <table class="table table-hover table-striped table-bordered">

                    <thead>

                    <tr>
                        <th class="text-center">نام کاربر</th>
                        <th class="text-center">دیدگاه محصول</th>
                        <th class="text-center">نام محصول</th>
                        <th class="text-center">تاریخ</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>


                    </tr>

                    </thead>

                    <tbody>

                    @foreach($comments as $comment)

                        <tr>

                            <td class="text-center">{{ $comment->user->name }}</td>

                            <td class="text-center">{{ $comment->body }}</td>

                            <td class="text-center">
                                @if($comment->commentable)
{{--                                    {{ class_basename($comment->commentable_type) }} :--}}
                                    {{ $comment->commentable->title ?? $comment->commentable->name ?? '---' }}
                                @else
                                    ---
                                @endif
                            </td>

                            <td class="text-center">{{ verta($comment->created_at)->format('Y/m/d') }}</td>

                            <td class="text-center">
                                @if($comment->status === 'approved')
                                    <span class="badge badge-success">تأیید شده</span>
                                @else
                                    <span class="badge badge-warning">در انتظار</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm
                                        {{ $comment->status === 'approved' ? 'btn-danger' : 'btn-success' }}">
                                        {{ $comment->status === 'approved' ? 'عدم تأیید' : 'تأیید' }}
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="d-flex justify-content-center mt-4">

                    {{ $comments->links() }}

                </div>

            </div>

        </div>
    </div>

@endsection
