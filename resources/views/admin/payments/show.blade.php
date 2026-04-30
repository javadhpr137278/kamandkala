@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">جزئیات تراکنش</h4>
                    <div class="card-tools">
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ti-arrow-left"></i> بازگشت
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <!-- وضعیت پرداخت -->
                    <div class="alert alert-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'failed' ? 'danger' : 'warning') }} mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>وضعیت پرداخت:</strong> {!! $payment->status_badge !!}
                            </div>
                            @if($payment->status == 'pending')
                                <button type="button" class="btn btn-sm btn-info" id="retry-verify">
                                    <i class="ti-reload"></i> تایید مجدد
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- اطلاعات اصلی -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">اطلاعات اصلی تراکنش</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">شماره تراکنش:</th>
                                            <td><code>{{ $payment->transaction_id }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>درگاه پرداخت:</th>
                                            <td><span class="badge badge-info">{{ strtoupper($payment->gateway) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>مبلغ:</th>
                                            <td><strong class="text-success">{{ number_format($payment->amount) }} تومان</strong></td>
                                        </tr>
                                        <tr>
                                            <th>کد رهگیری:</th>
                                            <td>
                                                @if($payment->tracking_code)
                                                    <code class="text-primary">{{ $payment->tracking_code }}</code>
                                                @elseif($payment->reference_id)
                                                    <code class="text-primary">{{ $payment->reference_id }}</code>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>شماره کارت:</th>
                                            <td>{{ $payment->card_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاریخ ایجاد:</th>
                                            <td>{{ verta($payment->created_at)->format('Y/m/d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاریخ تایید:</th>
                                            <td>{{ $payment->verified_at ? verta($payment->verified_at)->format('Y/m/d H:i:s') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>توضیحات:</th>
                                            <td>{{ $payment->description ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- اطلاعات کاربر -->
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5 class="card-title">اطلاعات کاربر</h5>
                                </div>
                                <div class="card-body">
                                    @if($payment->user)
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">نام و نام خانوادگی:</th>
                                                <td>{{ $payment->user->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>شماره موبایل:</th>
                                                <td>{{ $payment->user->mobile ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>ایمیل:</th>
                                                <td>{{ $payment->user->email ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ ثبت نام:</th>
                                                <td>{{ verta($payment->user->created_at)->format('Y/m/d') }}</td>
                                            </tr>
                                        </table>

                                        <a href="{{ route('users.show', $payment->user_id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="ti-user"></i> مشاهده پروفایل کاربر
                                        </a>
                                    @else
                                        <div class="alert alert-warning">کاربر حذف شده است</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اطلاعات سفارش -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="card-title">اطلاعات سفارش</h5>
                                </div>
                                <div class="card-body">
                                    @if($payment->order)
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="20%">شماره سفارش:</th>
                                                <td>
                                                    <a href="{{ route('orders.show', $payment->order_id) }}" class="text-primary">
                                                        {{ $payment->order->order_number }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>جمع کل سفارش:</th>
                                                <td>{{ number_format($payment->order->total) }} تومان</td>
                                            </tr>
                                            <tr>
                                                <th>وضعیت سفارش:</th>
                                                <td>{!! $payment->order->status_badge !!}</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ ثبت سفارش:</th>
                                                <td>{{ verta($payment->order->created_at)->format('Y/m/d H:i:s') }}</td>
                                            </tr>
                                        </table>

                                        <a href="{{ route('orders.show', $payment->order_id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="ti-shopping-cart"></i> مشاهده جزئیات سفارش
                                        </a>
                                    @else
                                        <div class="alert alert-info">این پرداخت به سفارشی متصل نیست</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اطلاعات اضافی (JSON) -->
                    @if($payment->payment_data || $payment->metadata)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h5 class="card-title">اطلاعات اضافی</h5>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="toggle-extra-data">
                                            <i class="ti-eye"></i> نمایش
                                        </button>
                                    </div>
                                    <div class="card-body" id="extra-data-content" style="display: none;">
                                        @if($payment->payment_data)
                                            <h6>داده‌های پرداخت:</h6>
                                            <pre class="bg-light p-2 rounded">{{ json_encode($payment->payment_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        @endif

                                        @if($payment->metadata)
                                            <h6 class="mt-3">متادیتا:</h6>
                                            <pre class="bg-light p-2 rounded">{{ json_encode($payment->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- دکمه‌های عملیات -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            @if($can_refund)
                                <button type="button" class="btn btn-warning" id="refund-payment" data-amount="{{ $payment->amount }}">
                                    <i class="ti-back-left"></i> استرداد وجه
                                </button>
                            @endif

                            @if($can_delete)
                                <button type="button" class="btn btn-danger" id="delete-payment">
                                    <i class="ti-trash"></i> حذف تراکنش
                                </button>
                            @endif

                            <button type="button" class="btn btn-info" id="print-payment">
                                <i class="ti-printer"></i> چاپ
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // استرداد وجه
            $('#refund-payment').click(function() {
                const maxAmount = $(this).data('amount');

                Swal.fire({
                    title: 'استرداد وجه',
                    html: `
                <p>آیا از استرداد وجه این تراکنش اطمینان دارید؟</p>
                <div class="form-group mt-3">
                    <label>مبلغ قابل استرداد (تومان):</label>
                    <input type="number" id="refund-amount" class="form-control" value="${maxAmount}" max="${maxAmount}" min="1">
                </div>
                <div class="form-group">
                    <label>دلیل استرداد:</label>
                    <textarea id="refund-reason" class="form-control" rows="2" placeholder="دلیل استرداد وجه..."></textarea>
                </div>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، استرداد شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33',
                    preConfirm: () => {
                        const refundAmount = $('#refund-amount').val();
                        if (!refundAmount || refundAmount <= 0 || refundAmount > maxAmount) {
                            Swal.showValidationMessage('مبلغ استرداد معتبر نیست');
                            return false;
                        }
                        return {
                            amount: refundAmount,
                            reason: $('#refund-reason').val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("payments.refund", $payment->id) }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                amount: result.value.amount,
                                reason: result.value.reason
                            },
                            success: function(response) {
                                Swal.fire('موفق!', response.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            },
                            error: function(xhr) {
                                const error = xhr.responseJSON?.message || 'خطا در استرداد وجه';
                                Swal.fire('خطا!', error, 'error');
                            }
                        });
                    }
                });
            });

            // حذف تراکنش
            $('#delete-payment').click(function() {
                Swal.fire({
                    title: 'حذف تراکنش',
                    html: 'آیا از حذف این تراکنش اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("payments.destroy", $payment->id) }}',
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            success: function(response) {
                                Swal.fire('حذف شد!', response.message, 'success');
                                setTimeout(() => {
                                    window.location.href = '{{ route("payments.index") }}';
                                }, 1500);
                            },
                            error: function(xhr) {
                                const error = xhr.responseJSON?.message || 'خطا در حذف تراکنش';
                                Swal.fire('خطا!', error, 'error');
                            }
                        });
                    }
                });
            });

            // تایید مجدد پرداخت
            $('#retry-verify').click(function() {
                Swal.fire({
                    title: 'تایید مجدد پرداخت',
                    text: 'آیا از تایید مجدد این تراکنش اطمینان دارید؟',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله، تایید شود',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("payments.retry-verify", $payment->id) }}',
                            type: 'POST',
                            data: {_token: '{{ csrf_token() }}'},
                            success: function(response) {
                                Swal.fire('موفق!', response.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            },
                            error: function(xhr) {
                                const error = xhr.responseJSON?.message || 'خطا در تایید پرداخت';
                                Swal.fire('خطا!', error, 'error');
                            }
                        });
                    }
                });
            });

            // چاپ
            $('#print-payment').click(function() {
                window.print();
            });

            // نمایش اطلاعات اضافی
            $('#toggle-extra-data').click(function() {
                $('#extra-data-content').slideToggle();
            });

        });
    </script>
@endpush

@push('styles')
    <style>
        @media print {
            .card-tools, .btn, .alert .btn, #toggle-extra-data {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .alert {
                border: 1px solid #ddd !important;
            }
        }
        pre {
            font-size: 11px;
            max-height: 300px;
            overflow: auto;
        }
    </style>
@endpush
