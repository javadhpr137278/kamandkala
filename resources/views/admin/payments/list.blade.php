{{-- resources/views/admin/payments/index.blade.php --}}
@extends('admin.layouts.master')

@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>{{ session('error') }}</div>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
    </div>

    <!-- کارت‌های آماری -->
    <div class="row pb-3">
        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="ti-credit-card text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">کل تراکنش‌ها</p>
                                <h4 class="card-title">{{ number_format($stats['total_payments']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="ti-check-box text-success"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">پرداخت‌های موفق</p>
                                <h4 class="card-title">{{ number_format($stats['successful_payments']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="ti-close text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">پرداخت‌های ناموفق</p>
                                <h4 class="card-title">{{ number_format($stats['failed_payments']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="ti-wallet text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">مجموع مبلغ</p>
                                <h4 class="card-title">{{ number_format($stats['total_amount']) }} تومان</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- کارت‌های آماری اضافی -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">آمار امروز</h6>
                    <div class="d-flex justify-content-between">
                        <span>تعداد تراکنش‌ها:</span>
                        <strong>{{ number_format($stats['today_payments']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>مبلغ امروز:</span>
                        <strong class="text-success">{{ number_format($stats['today_amount']) }} تومان</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">آخرین هفته</h6>
                    <div class="d-flex justify-content-between">
                        <span>تعداد تراکنش‌ها:</span>
                        <strong>{{ number_format($stats['weekly_payments']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>مبلغ هفته:</span>
                        <strong class="text-success">{{ number_format($stats['weekly_amount']) }} تومان</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">آخرین ماه</h6>
                    <div class="d-flex justify-content-between">
                        <span>تعداد تراکنش‌ها:</span>
                        <strong>{{ number_format($stats['monthly_payments']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>مبلغ ماه:</span>
                        <strong class="text-success">{{ number_format($stats['monthly_amount']) }} تومان</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">لیست تراکنش‌های پرداخت</h4>
        </div>
        <div class="card-body">

            <div class="table-responsive">

                <!-- بخش جستجو و فیلتر -->
                <div class="form-group row mb-4">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center flex-wrap">

                        <div class="d-flex mb-2 mb-sm-0">
                            <div class="input-group">
                                <input type="text" id="search-payment" class="form-control" placeholder="جستجوی شماره تراکنش، کاربر، سفارش...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="search-btn">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="button" id="export-excel" class="btn btn-outline-success mx-2">
                                <i class="ti-export"></i> خروجی اکسل
                            </button>
                        </div>

                    </div>
                </div>

                <!-- فیلترهای پیشرفته -->
                <div class="filter-section mb-4">
                    <div class="row">
                        <div class="col-md-2">
                            <label>وضعیت</label>
                            <select id="status-filter" class="form-control">
                                <option value="">همه</option>
                                <option value="pending">در انتظار</option>
                                <option value="processing">در حال پردازش</option>
                                <option value="completed">موفق</option>
                                <option value="failed">ناموفق</option>
                                <option value="refunded">استرداد شده</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>درگاه پرداخت</label>
                            <select id="gateway-filter" class="form-control">
                                <option value="">همه درگاه‌ها</option>
                                @foreach($gateways as $gateway)
                                    <option value="{{ $gateway->name }}">{{ $gateway->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>از تاریخ</label>
                            <input type="text" id="date-from" class="form-control datepicker" placeholder="۱۴۰۳/۰۱/۰۱">
                        </div>

                        <div class="col-md-2">
                            <label>تا تاریخ</label>
                            <input type="text" id="date-to" class="form-control datepicker" placeholder="۱۴۰۳/۱۲/۲۹">
                        </div>

                        <div class="col-md-2">
                            <label>حداقل مبلغ</label>
                            <input type="number" id="min-amount" class="form-control" placeholder="مبلغ از">
                        </div>

                        <div class="col-md-2">
                            <label>حداکثر مبلغ</label>
                            <input type="number" id="max-amount" class="form-control" placeholder="مبلغ تا">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button id="apply-filters" class="btn btn-primary">
                                <i class="ti-filter"></i> اعمال فیلترها
                            </button>
                            <button id="reset-filters" class="btn btn-secondary">
                                <i class="ti-reload"></i> حذف فیلترها
                            </button>
                        </div>
                    </div>
                </div>

                <!-- جدول اصلی -->
                <table class="table table-bordered table-striped table-hover" id="payments-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">شماره تراکنش</th>
                        <th class="text-center">کاربر</th>
                        <th class="text-center">شماره سفارش</th>
                        <th class="text-center">مبلغ</th>
                        <th class="text-center">درگاه</th>
                        <th class="text-center">کد رهگیری</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">تاریخ</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>

                    <tbody id="payments-tbody">
                    @forelse($payments as $payment)
                        <tr id="payment-row-{{ $payment->id }}"
                            class="payment-row"
                            data-status="{{ $payment->status }}"
                            data-gateway="{{ $payment->gateway }}"
                            data-amount="{{ $payment->amount }}"
                            data-date="{{ $payment->created_at->format('Y-m-d') }}">

                            <td class="text-center align-middle">{{ $loop->iteration }}</td>

                            <td class="text-center align-middle">
                                <code class="text-primary">{{ $payment->transaction_id }}</code>
                            </td>

                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <strong>{{ $payment->user->name ?? 'کاربر ناشناس' }}</strong>
                                    <small class="text-muted">{{ $payment->user->mobile ?? $payment->user->email ?? '-' }}</small>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                @if($payment->order)
                                    <a href="{{ route('orders.show', $payment->order_id) }}" class="text-primary">
                                        {{ $payment->order->order_number ?? '#' . $payment->order_id }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <strong>{{ number_format($payment->amount) }}</strong>
                                <small>تومان</small>
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-info">{{ strtoupper($payment->gateway) }}</span>
                            </td>

                            <td class="text-center align-middle">
                                @if($payment->tracking_code)
                                    <code class="text-success">{{ $payment->tracking_code }}</code>
                                @elseif($payment->reference_id)
                                    <code class="text-info">{{ $payment->reference_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                {!! $payment->status_badge !!}
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex flex-column">
                                    <span>{{ verta($payment->created_at)->format('Y/m/d') }}</span>
                                    <small class="text-muted">{{ verta($payment->created_at)->format('H:i') }}</small>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('payments.show', $payment->id) }}"
                                       class="btn btn-outline-info btn-sm"
                                       title="مشاهده جزئیات">
                                        <i class="ti-eye"></i>
                                    </a>

                                    @if($payment->status == 'completed')
                                        <button type="button"
                                                class="btn btn-outline-warning btn-sm refund-payment"
                                                data-id="{{ $payment->id }}"
                                                data-amount="{{ $payment->amount }}"
                                                title="استرداد وجه">
                                            <i class="ti-back-left"></i>
                                        </button>
                                    @endif

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm delete-payment"
                                            data-id="{{ $payment->id }}"
                                            data-transaction="{{ $payment->transaction_id }}"
                                            title="حذف">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">
                                <i class="ti-credit-card" style="font-size: 48px;"></i>
                                <p class="mt-3">هیچ تراکنش پرداختی یافت نشد</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr class="table-secondary">
                        <th colspan="4" class="text-left">جمع کل:</th>
                        <th class="text-center" id="total-amount-footer">0 تومان</th>
                        <th colspan="5"></th>
                    </tr>
                    </tfoot>
                </table>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        {{ $payments->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {

            // محاسبه و نمایش جمع کل
            function updateTotalAmount() {
                let total = 0;
                $('#payments-tbody tr:visible .payment-row, #payments-tbody tr:visible').each(function() {
                    const amountText = $(this).find('td:eq(4) strong').text();
                    if (amountText) {
                        total += parseInt(amountText.replace(/,/g, '')) || 0;
                    }
                });
                $('#total-amount-footer').text(total.toLocaleString() + ' تومان');
            }

            // استرداد وجه
            $('.refund-payment').click(function() {
                const id = $(this).data('id');
                const amount = $(this).data('amount');

                Swal.fire({
                    title: 'استرداد وجه',
                    html: `
                <p>آیا از استرداد وجه این تراکنش اطمینان دارید؟</p>
                <div class="form-group mt-3">
                    <label>مبلغ قابل استرداد:</label>
                    <input type="number" id="refund-amount" class="form-control" value="${amount}" max="${amount}" min="1">
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
                        const reason = $('#refund-reason').val();
                        if (!refundAmount || refundAmount <= 0) {
                            Swal.showValidationMessage('مبلغ استرداد معتبر نیست');
                            return false;
                        }
                        return { amount: refundAmount, reason: reason };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/payments/${id}/refund`,
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
            $('.delete-payment').click(function() {
                const id = $(this).data('id');
                const transaction = $(this).data('transaction');

                Swal.fire({
                    title: 'حذف تراکنش',
                    html: `آیا از حذف تراکنش <strong>${transaction}</strong> اطمینان دارید؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/payments/${id}`,
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function(response) {
                                Swal.fire('حذف شد!', response.message, 'success');
                                $(`#payment-row-${id}`).fadeOut(300, function() {
                                    $(this).remove();
                                    updateTotalAmount();
                                });
                            },
                            error: function(xhr) {
                                const error = xhr.responseJSON?.message || 'خطا در حذف تراکنش';
                                Swal.fire('خطا!', error, 'error');
                            }
                        });
                    }
                });
            });

            // فیلتر کردن
            let searchTimeout;

            function filterPayments() {
                const searchTerm = $('#search-payment').val().toLowerCase();
                const status = $('#status-filter').val();
                const gateway = $('#gateway-filter').val();
                const dateFrom = $('#date-from').val();
                const dateTo = $('#date-to').val();
                const minAmount = parseInt($('#min-amount').val()) || 0;
                const maxAmount = parseInt($('#max-amount').val()) || 0;

                let visibleCount = 0;

                $('#payments-tbody tr').each(function() {
                    let show = true;
                    const row = $(this);

                    const transactionId = row.find('td:eq(1) code').text().toLowerCase();
                    const userName = row.find('td:eq(2) strong').text().toLowerCase();
                    const orderNumber = row.find('td:eq(3) a').text().toLowerCase();
                    const rowStatus = row.data('status');
                    const rowGateway = row.data('gateway');
                    const amount = row.data('amount');
                    const rowDate = row.data('date');

                    // جستجو
                    if (searchTerm && !transactionId.includes(searchTerm) &&
                        !userName.includes(searchTerm) && !orderNumber.includes(searchTerm)) {
                        show = false;
                    }

                    // فیلتر وضعیت
                    if (status && rowStatus !== status) show = false;

                    // فیلتر درگاه
                    if (gateway && rowGateway !== gateway) show = false;

                    // فیلتر مبلغ
                    if (minAmount > 0 && amount < minAmount) show = false;
                    if (maxAmount > 0 && amount > maxAmount) show = false;

                    // فیلتر تاریخ
                    if (dateFrom && rowDate < convertToGregorian(dateFrom)) show = false;
                    if (dateTo && rowDate > convertToGregorian(dateTo)) show = false;

                    if (show) {
                        row.show();
                        visibleCount++;
                    } else {
                        row.hide();
                    }
                });

                updateTotalAmount();

                if (visibleCount === 0) {
                    if ($('#no-data-message').length === 0) {
                        $('#payments-tbody').append(`
                    <tr id="no-data-message">
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="ti-search" style="font-size: 48px;"></i>
                            <p class="mt-3">هیچ تراکنشی با فیلترهای انتخاب شده یافت نشد</p>
                        </td>
                    </tr>
                `);
                    }
                } else {
                    $('#no-data-message').remove();
                }
            }

            // تبدیل تاریخ شمسی به میلادی
            function convertToGregorian(persianDate) {
                // این تابع باید تاریخ شمسی را به میلادی تبدیل کند
                // در اینجا یک تبدیل ساده انجام می‌دهیم
                const parts = persianDate.split('/');
                if (parts.length === 3) {
                    return `${parts[0]}-${parts[1].padStart(2, '0')}-${parts[2].padStart(2, '0')}`;
                }
                return persianDate;
            }

            // رویدادهای فیلتر
            $('#search-payment').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterPayments, 400);
            });

            $('#apply-filters').click(filterPayments);
            $('#reset-filters').click(function() {
                $('#search-payment').val('');
                $('#status-filter').val('');
                $('#gateway-filter').val('');
                $('#date-from').val('');
                $('#date-to').val('');
                $('#min-amount').val('');
                $('#max-amount').val('');
                filterPayments();
            });

            // تاریخ‌شمار
            $('.datepicker').persianDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                initialValue: false
            });

            // محاسبه اولیه جمع کل
            updateTotalAmount();

        });
    </script>
@endpush

@push('styles')
    <style>
        .card-stats .card-body {
            padding: 15px;
        }
        .card-stats .icon-big {
            font-size: 3rem;
        }
        .card-stats .numbers {
            text-align: right;
        }
        .card-stats .card-category {
            margin-bottom: 5px;
            color: #6c757d;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .badge {
            font-size: 11px;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .table th {
            font-weight: 600;
            border-top: none;
        }
        .payment-row {
            transition: all 0.3s ease;
        }
        .payment-row:hover {
            background-color: #f5f5f5;
        }
        code {
            font-size: 11px;
            background: #f4f4f4;
            padding: 3px 6px;
            border-radius: 4px;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
        .pagination {
            justify-content: center;
        }
    </style>
@endpush
