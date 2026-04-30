@extends('layouts.app')
@section('content')
    <div class="panel-latest-order pt-2">

        <div class="slider-title">
            <div class="slider-title-desc">
                <div class="slider-title-title pb-4">
                    <h2 class="h1"><span class="title-font main-color-one-color">همه</span> سفارشات</h2>
                    <p class="text-muted">تعداد کل سفارشات: {{ $latestOrders->total() }}</p>
                </div>
            </div>
        </div>

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
                @forelse($latestOrders as $index => $order)
                    <tr>
                        <td class="font-14">{{ $latestOrders->firstItem() + $index }}</td>
                        <td class="font-14">{{ $order->order_number ?? $order->id }}</td>
                        <td class="font-14">{{ verta($order->created_at)->format('l j F Y') }}</td>
                        <td class="font-14">{{ number_format($order->total) }} تومان</td>
                        <td class="font-14">
                            @php
                                $statuses = [
                                    'pending' => ['text' => 'در انتظار پرداخت', 'class' => 'text-warning'],
                                    'processing' => ['text' => 'در حال پردازش', 'class' => 'text-info'],
                                    'shipped' => ['text' => 'ارسال شده', 'class' => 'text-primary'],
                                    'delivered' => ['text' => 'تحویل داده شده', 'class' => 'text-success'],
                                    'completed' => ['text' => 'تکمیل شده', 'class' => 'text-success'],
                                    'cancelled' => ['text' => 'لغو شده', 'class' => 'text-danger'],
                                    'returned' => ['text' => 'مرجوع شده', 'class' => 'text-warning'],
                                    'refunded' => ['text' => 'بازپرداخت شده', 'class' => 'text-secondary'],
                                ];
                                $status = $statuses[$order->status] ?? ['text' => 'نامشخص', 'class' => 'text-dark'];
                            @endphp
                            <a href="{{ route('orders.show', $order->id) }}" class="title-font {{ $status['class'] }}">
                                {{ $status['text'] }}
                            </a>
                        </td>
                        <td class="font-14">
                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn border-0 main-color-one-bg waves-effect waves-light">
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

        {{-- Pagination --}}
        @if($latestOrders->hasPages())
            <div class="my-paginate mt-5">
                {{ $latestOrders->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
@endsection
