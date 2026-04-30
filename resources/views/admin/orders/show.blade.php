@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>جزئیات سفارش #{{ $order->order_number }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('orders.print', $order) }}" class="btn btn-secondary" target="_blank">
                                <i class="ti-printer"></i> پرینت
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">
                                <i class="ti-arrow-left"></i> بازگشت
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- کارت تغییر وضعیت --}}
                        <div class="card mb-4 bg-light">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="ti-settings"></i> تغییر وضعیت سفارش</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>وضعیت سفارش</label>
                                            <select class="form-control" id="order_status" data-id="{{ $order->id }}">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>در حال پردازش</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                                <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>ناموفق</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>روش پرداخت</label>
                                            <select class="form-control" id="payment_method">
                                                <option value="bacs" {{ $order->payment_method == 'bacs' ? 'selected' : '' }}>انتقال بانکی</option>
                                                <option value="cod" {{ $order->payment_method == 'cod' ? 'selected' : '' }}>پرداخت در محل</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>تاریخ ارسال</label>
                                            <input type="date" class="form-control" id="shipping_date" value="{{ $order->shipping_date ? date('Y-m-d', strtotime($order->shipping_date)) : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>یادداشت تغییر وضعیت (اختیاری)</label>
                                            <input type="text" class="form-control" id="status_note" placeholder="دلیل تغییر وضعیت...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- دکمه‌های تغییر سریع وضعیت --}}
                        {{-- جایگزین دکمه‌های تغییر سریع وضعیت --}}
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="ti-control-forward"></i> تغییر سریع وضعیت</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group d-flex flex-wrap">
                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="m-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="ti-time"></i> در انتظار پرداخت
                                                </button>
                                            </form>

                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="m-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="ti-reload"></i> در حال پردازش
                                                </button>
                                            </form>

                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="m-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ti-check"></i> تکمیل شده
                                                </button>
                                            </form>

                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="m-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="ti-close"></i> لغو شده
                                                </button>
                                            </form>

                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="m-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="failed">
                                                <button type="submit" class="btn btn-secondary">
                                                    <i class="ti-alert"></i> ناموفق
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- اطلاعات صورتحساب --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>اطلاعات صورتحساب</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>نام:</strong> {{ $order->billing_first_name }} {{ $order->billing_last_name }}</p>
                                        <p><strong>تلفن:</strong> {{ $order->billing_phone }}</p>
                                        <p><strong>ایمیل:</strong> {{ $order->billing_email ?? '-' }}</p>
                                        <p><strong>آدرس:</strong> {{ $order->billing_address_1 ?? '-' }}</p>
                                        <p><strong>آدرس 2:</strong> {{ $order->billing_address_2 ?? '-' }}</p>
                                        <p><strong>شهر:</strong> {{ $order->billing_city ?? '-' }}</p>
                                        <p><strong>استان:</strong> {{ $order->billing_state ?? '-' }}</p>
                                        <p><strong>کدپستی:</strong> {{ $order->billing_postcode ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- اطلاعات ارسال --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>اطلاعات ارسال</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>نوع آدرس:</strong>
                                            @if($order->address_choice == 'billing') صورتحساب
                                            @elseif($order->address_choice == 'shipping') ارسال
                                            @else سفارشی
                                            @endif
                                        </p>

                                        @if($order->address_choice == 'custom')
                                            <p><strong>آدرس:</strong> {{ $order->custom_address ?? '-' }}</p>
                                            <p><strong>شهر:</strong> {{ $order->custom_city ?? '-' }}</p>
                                            <p><strong>کدپستی:</strong> {{ $order->custom_postcode ?? '-' }}</p>
                                        @elseif($order->address_choice == 'shipping')
                                            <p><strong>نام:</strong> {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                                            <p><strong>تلفن:</strong> {{ $order->shipping_phone ?? '-' }}</p>
                                            <p><strong>آدرس:</strong> {{ $order->shipping_address_1 ?? '-' }}</p>
                                            <p><strong>آدرس 2:</strong> {{ $order->shipping_address_2 ?? '-' }}</p>
                                            <p><strong>شهر:</strong> {{ $order->shipping_city ?? '-' }}</p>
                                            <p><strong>استان:</strong> {{ $order->shipping_state ?? '-' }}</p>
                                            <p><strong>کدپستی:</strong> {{ $order->shipping_postcode ?? '-' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- محصولات سفارش --}}
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>محصولات سفارش</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>محصول</th>
                                            <th>قیمت واحد</th>
                                            <th>تعداد</th>
                                            <th>جمع کل</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $orderItems = json_decode($order->order_items, true) ?? [];
                                        @endphp
                                        @forelse($orderItems as $item)
                                            <tr>
                                                <td>{{ $item['product_name'] ?? $item['name'] ?? '-' }}
                                                    @if(!empty($item['color_name']))
                                                        <br><small class="text-muted">رنگ: {{ $item['color_name'] }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($item['unit_price'] ?? $item['price'] ?? 0) }} تومان</td>
                                                <td>{{ $item['quantity'] ?? 1 }}</td>
                                                <td>{{ number_format($item['total_price'] ?? ($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }} تومان</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">محصولی یافت نشد</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                        <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-left">جمع جزء</th>
                                            <th>{{ number_format($order->subtotal) }} تومان</th>
                                        </tr>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-left">هزینه ارسال</th>
                                            <th>{{ number_format($order->shipping_cost) }} تومان</th>
                                        </tr>
                                        @if($order->discount_amount > 0)
                                            <tr class="bg-light">
                                                <th colspan="3" class="text-left">تخفیف</th>
                                                <th class="text-danger">-{{ number_format($order->discount_amount) }} تومان</th>
                                            </tr>
                                        @endif
                                        @if($order->gift_card_amount > 0)
                                            <tr class="bg-light">
                                                <th colspan="3" class="text-left">کارت هدیه</th>
                                                <th class="text-danger">-{{ number_format($order->gift_card_amount) }} تومان</th>
                                            </tr>
                                        @endif
                                        <tr class="bg-success text-white">
                                            <th colspan="3" class="text-left">جمع کل</th>
                                            <th>{{ number_format($order->total) }} تومان</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- یادداشت‌ها --}}
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>یادداشت‌ها</h5>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" id="notes" rows="3" placeholder="یادداشت خود را وارد کنید...">{{ $order->notes ?? '' }}</textarea>
                                <button class="btn btn-primary mt-2" id="saveNotes">ذخیره یادداشت</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // تابع تغییر وضعیت
            function changeOrderStatus(orderId, status, note = '') {
                return $.ajax({
                    url: `/admin/orders/${orderId}/status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        status: status,
                        note: note
                    }
                });
            }

            // تغییر وضعیت از dropdown
            $('#order_status').change(function() {
                const orderId = $(this).data('id');
                const status = $(this).val();
                const note = $('#status_note').val();
                const statusText = $(this).find('option:selected').text();

                Swal.fire({
                    title: 'تغییر وضعیت سفارش',
                    html: `آیا از تغییر وضعیت به <strong>${statusText}</strong> اطمینان دارید؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله، تغییر کن',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        changeOrderStatus(orderId, status, note)
                            .done(function(response) {
                                if (response.success) {
                                    Swal.fire('موفق!', response.message, 'success');
                                    // به‌روزرسانی نمایش وضعیت در صفحه
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }
                            })
                            .fail(function(xhr) {
                                Swal.fire('خطا!', xhr.responseJSON?.message || 'مشکلی در تغییر وضعیت رخ داد', 'error');
                                // بازگرداندن انتخاب قبلی
                                location.reload();
                            });
                    } else {
                        // بازگرداندن انتخاب قبلی
                        location.reload();
                    }
                });
            });

            // دکمه‌های تغییر سریع وضعیت
            $('.quick-status').click(function() {
                const orderId = {{ $order->id }};
                const status = $(this).data('status');
                const statusText = $(this).text().trim();
                const note = $('#status_note').val();

                Swal.fire({
                    title: 'تغییر وضعیت سفارش',
                    html: `آیا از تغییر وضعیت به <strong>${statusText}</strong> اطمینان دارید؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله، تغییر کن',
                    cancelButtonText: 'خیر',
                    input: 'text',
                    inputPlaceholder: 'دلیل تغییر وضعیت (اختیاری)',
                    inputValue: note
                }).then((result) => {
                    if (result.isConfirmed) {
                        changeOrderStatus(orderId, status, result.value || '')
                            .done(function(response) {
                                if (response.success) {
                                    Swal.fire('موفق!', response.message, 'success');
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }
                            })
                            .fail(function(xhr) {
                                Swal.fire('خطا!', xhr.responseJSON?.message || 'مشکلی در تغییر وضعیت رخ داد', 'error');
                            });
                    }
                });
            });

            // ذخیره یادداشت
            $('#saveNotes').click(function() {
                const orderId = {{ $order->id }};
                const notes = $('#notes').val();

                $.ajax({
                    url: `/admin/orders/${orderId}`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        notes: notes
                    },
                    success: function(response) {
                        Swal.fire('موفق!', 'یادداشت با موفقیت ذخیره شد', 'success');
                    },
                    error: function() {
                        Swal.fire('خطا!', 'مشکلی در ذخیره یادداشت رخ داد', 'error');
                    }
                });
            });

            // تغییر روش پرداخت
            $('#payment_method').change(function() {
                const orderId = {{ $order->id }};
                const paymentMethod = $(this).val();

                Swal.fire({
                    title: 'تغییر روش پرداخت',
                    text: 'آیا از تغییر روش پرداخت اطمینان دارید؟',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/orders/${orderId}`,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                payment_method: paymentMethod
                            },
                            success: function(response) {
                                Swal.fire('موفق!', 'روش پرداخت با موفقیت تغییر کرد', 'success');
                            },
                            error: function() {
                                Swal.fire('خطا!', 'مشکلی در تغییر روش پرداخت رخ داد', 'error');
                                location.reload();
                            }
                        });
                    } else {
                        location.reload();
                    }
                });
            });

            // تغییر تاریخ ارسال
            $('#shipping_date').change(function() {
                const orderId = {{ $order->id }};
                const shippingDate = $(this).val();

                $.ajax({
                    url: `/admin/orders/${orderId}`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        shipping_date: shippingDate
                    },
                    success: function(response) {
                        Swal.fire('موفق!', 'تاریخ ارسال با موفقیت تغییر کرد', 'success');
                    },
                    error: function() {
                        Swal.fire('خطا!', 'مشکلی در تغییر تاریخ ارسال رخ داد', 'error');
                    }
                });
            });

        });
    </script>
@endpush

@push('styles')
    <style>
        .quick-status {
            min-width: 150px;
            transition: all 0.3s ease;
        }
        .quick-status:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
