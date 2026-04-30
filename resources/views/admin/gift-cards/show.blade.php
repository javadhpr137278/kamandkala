@extends('admin.layouts.master')

@section('content')

    <div class="container mt-4">

        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="ti-gift"></i>
                            جزئیات کارت هدیه: {{ $giftCard->code }}
                        </h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            {{-- اطلاعات اصلی --}}
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">کد کارت هدیه</th>
                                        <td><span class="badge badge-primary">{{ $giftCard->code }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>موجودی اولیه</th>
                                        <td>{{ number_format($giftCard->initial_balance) }} تومان</td>
                                    </tr>
                                    <tr>
                                        <th>موجودی فعلی</th>
                                        <td>
                                            <span class="badge {{ $giftCard->current_balance > 0 ? 'badge-success' : 'badge-danger' }}">
                                                {{ number_format($giftCard->current_balance) }} تومان
                                            </span>
                                            @php
                                                $percentUsed = (($giftCard->initial_balance - $giftCard->current_balance) / $giftCard->initial_balance) * 100;
                                            @endphp
                                            <div class="progress mt-2" style="height: 10px;">
                                                <div class="progress-bar bg-success" style="width: {{ 100 - $percentUsed }}%"></div>
                                                <div class="progress-bar bg-secondary" style="width: {{ $percentUsed }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ number_format($percentUsed) }}% استفاده شده</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>وضعیت</th>
                                        <td>
                                            @if($giftCard->is_active && $giftCard->current_balance > 0 && (!$giftCard->expires_at || $giftCard->expires_at->isFuture()))
                                                <span class="badge badge-success">فعال</span>
                                            @elseif($giftCard->current_balance <= 0)
                                                <span class="badge badge-secondary">استفاده شده</span>
                                            @elseif($giftCard->expires_at && $giftCard->expires_at->isPast())
                                                <span class="badge badge-danger">منقضی شده</span>
                                            @else
                                                <span class="badge badge-warning">غیرفعال</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>اختصاص یافته به</th>
                                        <td>
                                            @if($giftCard->user)
                                                {{ $giftCard->user->name }}
                                                <br>
                                                <small>{{ $giftCard->user->mobile ?? $giftCard->user->email }}</small>
                                            @else
                                                <span class="text-muted">بدون اختصاص (عمومی)</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>تاریخ انقضا</th>
                                        <td>
                                            @if($giftCard->expires_at)
                                                {{ verta($giftCard->expires_at)->format('Y/m/d H:i') }}
                                                @if($giftCard->expires_at->isFuture())
                                                    <span class="badge badge-info">({{ verta($giftCard->expires_at)->diffForHumans() }} باقی مانده)</span>
                                                @else
                                                    <span class="badge badge-danger">(منقضی شده)</span>
                                                @endif
                                            @else
                                                <span class="text-muted">نامحدود</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>تاریخ ایجاد</th>
                                        <td>{{ verta($giftCard->created_at)->format('Y/m/d H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            {{-- عملیات --}}
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">عملیات</h6>
                                        <div class="btn-group-vertical w-100">
                                            <button type="button" class="btn btn-outline-warning mb-2 toggle-status"
                                                    data-id="{{ $giftCard->id }}"
                                                    data-status="{{ $giftCard->is_active }}">
                                                <i class="ti-{{ $giftCard->is_active ? 'close' : 'check' }}"></i>
                                                {{ $giftCard->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                                            </button>

                                            <button type="button" class="btn btn-outline-danger delete-giftcard"
                                                    data-id="{{ $giftCard->id }}"
                                                    data-code="{{ $giftCard->code }}">
                                                <i class="ti-trash"></i>
                                                حذف کارت هدیه
                                            </button>

                                            <a href="{{ route('gift-cards.index') }}" class="btn btn-outline-secondary mt-2">
                                                <i class="ti-arrow-left"></i>
                                                بازگشت به لیست
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- تاریخچه تراکنش‌ها --}}
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="ti-list"></i>
                                            تاریخچه تراکنش‌ها
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($giftCard->transactions->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>نوع تراکنش</th>
                                                        <th>مبلغ</th>
                                                        <th>شماره سفارش</th>
                                                        <th>تاریخ</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($giftCard->transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                @if($transaction->type == 'purchase')
                                                                    <span class="badge badge-success">خرید</span>
                                                                @elseif($transaction->type == 'used')
                                                                    <span class="badge badge-warning">استفاده</span>
                                                                @else
                                                                    <span class="badge badge-info">بازگشت وجه</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ number_format($transaction->amount) }} تومان</td>
                                                            <td>
                                                                @if($transaction->order_id)
                                                                    <a href="{{ route('orders.show', $transaction->order_id) }}">
                                                                        #{{ $transaction->order_id }}
                                                                    </a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>{{ verta($transaction->created_at)->format('Y/m/d H:i') }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info text-center mb-0">
                                                <i class="ti-info-alt"></i>
                                                هیچ تراکنشی برای این کارت هدیه ثبت نشده است
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // تغییر وضعیت
            $('.toggle-status').click(function() {
                const btn = $(this);
                const giftCardId = btn.data('id');
                const currentStatus = btn.data('status');

                Swal.fire({
                    title: 'تغییر وضعیت',
                    text: `آیا از ${currentStatus ? 'غیرفعال' : 'فعال'} کردن این کارت هدیه اطمینان دارید؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/gift-cards/${giftCardId}/toggle-status`,
                            type: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('موفق!', response.message, 'success');
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }
                            },
                            error: function() {
                                Swal.fire('خطا!', 'مشکلی در تغییر وضعیت رخ داد', 'error');
                            }
                        });
                    }
                });
            });

            // حذف کارت هدیه
            $('.delete-giftcard').click(function() {
                const btn = $(this);
                const giftCardId = btn.data('id');
                const giftCardCode = btn.data('code');

                Swal.fire({
                    title: 'حذف کارت هدیه',
                    html: `آیا از حذف کارت هدیه <strong>${giftCardCode}</strong> اطمینان دارید؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/gift-cards/${giftCardId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('حذف شد!', response.message, 'success');
                                    setTimeout(() => {
                                        window.location.href = '{{ route("gift-cards.index") }}';
                                    }, 1500);
                                }
                            },
                            error: function() {
                                Swal.fire('خطا!', 'مشکلی در حذف رخ داد', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
