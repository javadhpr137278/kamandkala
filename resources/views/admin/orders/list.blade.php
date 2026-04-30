@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">
        {{-- کارت‌های آماری --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">کل سفارشات</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_orders']) }}</h2>
                        <small>مجموع تمام سفارشات</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">فروش کل</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_sales']) }}</h2>
                        <small>تومان</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">سفارشات امروز</h5>
                        <h2 class="mb-0">{{ number_format($stats['today_orders']) }}</h2>
                        <small>{{ number_format($stats['today_sales']) }} تومان</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">در انتظار پرداخت</h5>
                        <h2 class="mb-0">{{ number_format($stats['pending_orders']) }}</h2>
                        <small>نیاز به بررسی</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- فیلترها --}}
        <div class="card mt-4">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.index') }}" class="row">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">همه وضعیت‌ها</option>
                            @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="payment_method" class="form-control">
                            <option value="">همه روش‌ها</option>
                            @foreach($paymentMethods as $key => $value)
                                <option value="{{ $key }}" {{ request('payment_method') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" placeholder="از تاریخ" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" placeholder="تا تاریخ" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">فیلتر</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول سفارشات --}}
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>شماره سفارش</th>
                            <th>مشتری</th>
                            <th>تلفن</th>
                            <th>مبلغ کل</th>
                            <th>وضعیت</th>
                            <th>روش پرداخت</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->full_name }}</td>
                                <td>{{ $order->billing_phone }}</td>
                                <td>{{ number_format($order->total) }} تومان</td>
                                <td>{!! $order->status_badge !!}</td>
                                <td>{{ $order->payment_method === 'cod' ? 'پرداخت در محل' : 'انتقال بانکی' }}</td>
                                <td>{{ verta($order->created_at)->format('Y/m/d H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="ti-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-order" data-id="{{ $order->id }}">
                                        <i class="ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">هیچ سفارشی یافت نشد</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.delete-order').click(function() {
                const orderId = $(this).data('id');

                Swal.fire({
                    title: 'حذف سفارش',
                    text: 'آیا از حذف این سفارش اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/orders/${orderId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('حذف شد!', response.message, 'success');
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
