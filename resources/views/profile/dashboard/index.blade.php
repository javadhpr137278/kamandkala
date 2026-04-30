@section('dashboard')
    <div class="panel-meta my-5">
        <div class="row g-3">
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('orders.completed') }}">
                    <div class="panel-meta-item d-flex align-items-center">
                        <div class="panel-meta-item-icon">
                            <i class="bi bi bi-bag-check"></i>
                        </div>
                        <div class="panel-meta-title d-flex flex-column">
                            <h6 class="h6">سفارشات تکمیل شده</h6>
                            <h5 class="title-font h3">{{ number_format(auth()->user()->completed_orders_count) }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('user.reviews') }}">
                    <div class="panel-meta-item d-flex align-items-center">
                        <div class="panel-meta-item-icon bg-primary">
                            <i class="bi bi bi-send"></i>
                        </div>
                        <div class="panel-meta-title d-flex flex-column">
                            <h6 class="h6">نظرات</h6>
                            <h5 class="title-font h3">{{ number_format(auth()->user()->reviews_count) }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('orders.returned') }}">
                    <div class="panel-meta-item d-flex align-items-center">
                        <div class="panel-meta-item-icon bg-secondary">
                            <i class="bi bi-repeat"></i>
                        </div>
                        <div class="panel-meta-title d-flex flex-column">
                            <h6 class="h6">سفارشات مرجوعی</h6>
                            <h5 class="title-font h3">{{ number_format(auth()->user()->returned_orders_count) }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-latest-order">
        <div class="table-responsive shadow-box roundedTable p-0">
            <table class="table main-table rounded-0">
                <thead class="text-center">
                <tr>
                    <th class="title-font">#</th>
                    <th class="title-font">شماره سفارش</th>
                    <th class="title-font">تاریخ ثبت سفارش</th>
                    <th class="title-font">مبلغ پرداختی</th>
                    <th class="title-font">وضعیت سفارش</th>
                    <th class="title-font">جزییات</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @forelse($latestOrders as $order)
                    <tr>
                        <td class="font-14">{{ $loop->iteration }}</td>
                        <td class="font-14">{{ $order->order_number ?? '---' }}</td>
                        <td class="font-14">{{ Verta($order->created_at) }}</td>
                        <td class="font-14">{{ number_format($order->total) }} تومان</td>
                        <td class="font-14">
                            <span class="title-font">{{ $order->statusfa ?? 'نامشخص' }}</span>
                        </td>
                        <td class="font-14">
                            <a href="{{ route('dashboard.orders.show', $order->id) }}"
                               class="btn border-0 main-color-one-bg waves-effect waves-light">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-inbox-fill me-2"></i>
                                هیچ سفارشی یافت نشد
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
