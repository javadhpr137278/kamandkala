
@extends('admin.layouts.master')

@section('content')

    <div class="row">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>{{ session('error') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <div class="form-group row mb-4 pt-2">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center">

                        <div class="d-flex">
                            {{-- لینک سطل زباله - با بررسی وجود route --}}
                            @if(Route::has('discounts.trashed'))
                                <a href="{{ route('discounts.trashed') }}" class="btn btn-outline-danger">
                                    <i class="ti-trash px-2"></i>
                                    سطل زباله
                                </a>
                            @else
                                <button type="button" class="btn btn-outline-danger" disabled>
                                    <i class="ti-trash px-2"></i>
                                    سطل زباله (غیرفعال)
                                </button>
                            @endif
                        </div>

                        <div class="d-flex">
                            <div class="input-group">
                                <input type="text" id="search-discount" class="form-control" placeholder="جستجوی کد تخفیف...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="search-btn">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="{{ route('discounts.create') }}" class="btn btn-outline-info mx-2">
                                <i class="ti-plus"></i>
                                کد تخفیف جدید
                            </a>
                        </div>

                    </div>
                </div>

                <div class="filter-section mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select id="type-filter" class="form-control">
                                <option value="">همه انواع تخفیف</option>
                                <option value="percent">درصدی</option>
                                <option value="fixed">مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="status-filter" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active">فعال</option>
                                <option value="inactive">غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="reset-filters" class="btn btn-secondary">
                                <i class="ti-reload"></i>
                                حذف فیلترها
                            </button>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="discounts-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">کد تخفیف</th>
                        <th class="text-center text-primary">نوع</th>
                        <th class="text-center text-primary">مقدار</th>
                        <th class="text-center text-primary">حداقل سفارش</th>
                        <th class="text-center text-primary">حداکثر تخفیف</th>
                        <th class="text-center text-primary">دفعات استفاده</th>
                        <th class="text-center text-primary">وضعیت</th>
                        <th class="text-center text-primary">تاریخ شروع</th>
                        <th class="text-center text-primary">تاریخ انقضا</th>
                        <th class="text-center text-primary">عملیات</th>
                    </tr>
                    </thead>

                    <tbody id="discounts-tbody">
                    @forelse($discounts as $discount)
                        <tr id="discount-row-{{ $discount->id }}" class="discount-row">
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-primary">{{ $discount->code }}</span>
                            </td>

                            <td class="text-center align-middle">
                                @if($discount->type == 'percent')
                                    <span class="badge badge-success">درصدی</span>
                                @else
                                    <span class="badge badge-info">مبلغ ثابت</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                @if($discount->type == 'percent')
                                    {{ number_format($discount->value) }}%
                                @else
                                    {{ number_format($discount->value) }} تومان
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                {{ $discount->min_order_amount ? number_format($discount->min_order_amount) . ' تومان' : '-' }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $discount->max_discount_amount ? number_format($discount->max_discount_amount) . ' تومان' : '-' }}
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-secondary">
                                    {{ $discount->used_count }} / {{ $discount->usage_limit ?? '∞' }}
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                @if($discount->is_active && (!$discount->expires_at || $discount->expires_at->isFuture()))
                                    <span class="badge badge-success">فعال</span>
                                @elseif($discount->expires_at && $discount->expires_at->isPast())
                                    <span class="badge badge-danger">منقضی شده</span>
                                @else
                                    <span class="badge badge-warning">غیرفعال</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                {{ $discount->starts_at ? verta($discount->starts_at)->format('Y/m/d') : '-' }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $discount->expires_at ? verta($discount->expires_at)->format('Y/m/d') : '-' }}
                            </td>

                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('discounts.edit', $discount->id) }}"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="ti-pencil"></i>
                                        ویرایش
                                    </a>

                                    <button type="button"
                                            class="btn btn-outline-{{ $discount->is_active ? 'warning' : 'success' }} btn-sm toggle-status"
                                            data-id="{{ $discount->id }}"
                                            data-status="{{ $discount->is_active }}">
                                        <i class="ti-{{ $discount->is_active ? 'close' : 'check' }}"></i>
                                        {{ $discount->is_active ? 'غیرفعال' : 'فعال' }}
                                    </button>

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm delete-discount"
                                            data-id="{{ $discount->id }}"
                                            data-code="{{ $discount->code }}">
                                        <i class="ti-trash"></i>
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                <i class="ti-info-alt"></i>
                                هیچ کد تخفیفی یافت نشد
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $discounts->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // تابع تغییر وضعیت (فعال/غیرفعال)
            $('.toggle-status').click(function() {
                const btn = $(this);
                const discountId = btn.data('id');
                const currentStatus = btn.data('status');

                Swal.fire({
                    title: 'تغییر وضعیت',
                    text: `آیا از ${currentStatus ? 'غیرفعال' : 'فعال'} کردن این کد تخفیف اطمینان دارید؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/discounts/${discountId}/toggle-status`,
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
                            error: function(xhr) {
                                Swal.fire('خطا!', 'مشکلی در تغییر وضعیت رخ داد', 'error');
                            }
                        });
                    }
                });
            });

            // تابع حذف کد تخفیف
            $('.delete-discount').click(function() {
                const btn = $(this);
                const discountId = btn.data('id');
                const discountCode = btn.data('code');

                Swal.fire({
                    title: 'حذف کد تخفیف',
                    html: `آیا از حذف کد تخفیف <strong>${discountCode}</strong> اطمینان دارید؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/discounts/${discountId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('حذف شد!', response.message, 'success');
                                    $(`#discount-row-${discountId}`).fadeOut(300, function() {
                                        $(this).remove();
                                        if ($('.discount-row').length === 0) {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('خطا!', 'مشکلی در حذف رخ داد', 'error');
                            }
                        });
                    }
                });
            });

            // جستجوی داینامیک
            let searchTimeout;
            $('#search-discount').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    const searchTerm = $('#search-discount').val();
                    filterDiscounts();
                }, 500);
            });

            $('#search-btn').click(function() {
                filterDiscounts();
            });

            // فیلتر بر اساس نوع
            $('#type-filter').change(function() {
                filterDiscounts();
            });

            // فیلتر بر اساس وضعیت
            $('#status-filter').change(function() {
                filterDiscounts();
            });

            // ریست فیلترها
            $('#reset-filters').click(function() {
                $('#search-discount').val('');
                $('#type-filter').val('');
                $('#status-filter').val('');
                filterDiscounts();
            });

            function filterDiscounts() {
                const searchTerm = $('#search-discount').val().toLowerCase();
                const typeFilter = $('#type-filter').val();
                const statusFilter = $('#status-filter').val();

                $('.discount-row').each(function() {
                    let show = true;
                    const row = $(this);
                    const code = row.find('td:eq(1)').text().toLowerCase();
                    const type = row.find('td:eq(2)').text().trim();
                    const statusBadge = row.find('td:eq(7) .badge').text().trim();

                    // فیلتر جستجو
                    if (searchTerm && !code.includes(searchTerm)) {
                        show = false;
                    }

                    // فیلتر نوع
                    if (typeFilter) {
                        const typeText = typeFilter === 'percent' ? 'درصدی' : 'مبلغ ثابت';
                        if (type !== typeText) {
                            show = false;
                        }
                    }

                    // فیلتر وضعیت
                    if (statusFilter) {
                        if (statusFilter === 'active' && statusBadge !== 'فعال') {
                            show = false;
                        } else if (statusFilter === 'inactive' && (statusBadge === 'فعال' || statusBadge === 'منقضی شده')) {
                            show = false;
                        }
                    }

                    if (show) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });

                // نمایش پیام خالی بودن نتایج
                const visibleRows = $('.discount-row:visible').length;
                if (visibleRows === 0) {
                    if ($('#no-results-row').length === 0) {
                        $('#discounts-tbody').append(`
                        <tr id="no-results-row">
                            <td colspan="11" class="text-center text-muted">
                                <i class="ti-info-alt"></i>
                                هیچ نتیجه‌ای یافت نشد
                            </td>
                        </tr>
                    `);
                    }
                } else {
                    $('#no-results-row').remove();
                }
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        #discounts-table tbody tr {
            transition: all 0.3s ease;
        }

        #discounts-table tbody tr:hover {
            background-color: #f5f5f5;
            transform: scale(1.01);
        }

        .input-group {
            width: 250px;
        }

        @media (max-width: 768px) {
            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .input-group {
                width: 100%;
                margin-bottom: 10px;
            }

            .filter-section .row > div {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
