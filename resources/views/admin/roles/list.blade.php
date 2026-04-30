@extends('admin.layouts.master')

@section('content')

    {{-- پیام سیستم --}}
    <div class="row">
        @if(session()->has('message'))
            <div class="alert alert-info">
                <div>{{ session('message') }}</div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">

            {{-- ردیف بالای جدول (دکمه افزودن نقش) --}}
            <div class="d-flex justify-content-between mb-3">
                <h5 class="mb-0">نقش‌های کاربری</h5>
                <a href="{{ route('roles.create') }}" class="btn btn-success">
                    + افزودن نقش کاربری
                </a>
            </div>

            {{-- جدول جدید --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">نام نقش</th>
                        <th scope="col">تاریخ ایجاد</th>
                        <th class="text-center" scope="col">وضعیت</th>
                        <th class="text-center" scope="col">عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($roles as $role)
                        <tr>

                            {{-- نام نقش --}}
                            <td>
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="mb-0">{{ $role->name }}</h6>
                                    </div>
                                </div>
                            </td>

                            {{-- تاریخ ایجاد --}}
                            <td>
                                <p class="mb-0">
                                    {{ \Hekmatinasser\Verta\Verta::instance($role->created_at)->format('%d %B %Y') }}
                                </p>
                            </td>

                            {{-- وضعیت (نمونه: همیشه فعال) --}}
                            <td class="text-center">
                                <span class="badge badge-light-success">فعال</span>
                            </td>

                            {{-- عملیات --}}
                            <td class="text-center">
                                <div class="action-btns">

                                    {{-- ویرایش --}}
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                       class="action-btn btn-edit bs-tooltip me-2"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="ویرایش">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>

                                    {{-- حذف --}}
                                    <form method="POST"
                                          action="{{ route('roles.destroy', $role->id) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('آیا از حذف این نقش مطمئن هستید؟')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn btn-delete bs-tooltip border-0"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-trash-2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                     a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection
