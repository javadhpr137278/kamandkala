@extends('admin.layouts.master')
@section('content')
    <div class="dt--top-section">
        <div class="row">
            <div class="col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center">
                <a href="{{route('users.create')}}" class="btn btn-outline-success btn-rounded mb-2 me-4">افزودن کاربر</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام و نام خانوادگی</th>
                <th scope="col">نقش کاربر</th>
                <th scope="col">اتصال نقش کاربر</th>
                <th scope="col">شماره موبایل</th>
                <th class="text-center" scope="col">وضعیت</th>
                <th class="text-center" scope="col">عملیات</th>
                <th class="text-center" scope="col">تاریخ ایجاد</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>
                        {{$users->firstItem()+$index}}
                    </td>
                    <td>
                        <div class="media">
                            <div class="avatar me-2">
                                <img alt="{{$user->name}}" src="{{ asset('storage/users/'.$user->image) }}"
                                     class="rounded-circle"/>
                            </div>
                            <div class="media-body align-self-center">
                                <h6 class="mb-0">{{$user->name}}</h6>
                                <span>{{$user->email}}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-danger">
                            {{ $user->getRoleNames()->implode(', ') ?? 'کاربر' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('create.user.role', $user->id) }}"
                           class="btn btn-outline-secondary mb-2 me-4">
                            اتصال نقش کاربری
                        </a>
                    </td>
                    <td>
                        <span class="text-success">{{$user->mobile}}</span>
                    </td>
                    <td class="text-center">
                        @if($user->status==\App\Enums\UserStatus::Active->value)
                            <span class="badge badge-light-success">فعال</span>
                        @elseif($user->status==\App\Enums\UserStatus::InActive->value)
                            <span class="badge badge-light-warning">غیرفعال</span>
                        @elseif($user->status==\App\Enums\UserStatus::Banned->value)
                            <span class="badge badge-light-danger">بن شده</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="action-btns">

                            <!-- Edit -->
                            <a href="{{ route('users.edit', $user) }}"
                               class="action-btn btn-edit bs-tooltip me-2"
                               data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-edit-2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  style="display:inline-block"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-btn btn-delete bs-tooltip"
                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                        style="border: none; background: transparent;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-trash-2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </td>

                    <td class="text-center align-middle">{{\Hekmatinasser\Verta\Verta::instance($user->created_at)->format('%d %B %Y ')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
