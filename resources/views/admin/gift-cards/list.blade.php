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
                            <a href="{{ route('gift-cards.trashed') }}" class="btn btn-outline-danger">
                                <i class="ti-trash px-2"></i>
                                سطل زباله
                            </a>
                        </div>

                        <div class="d-flex">
                            <a href="{{ route('gift-cards.create') }}" class="btn btn-outline-info mx-2">
                                <i class="ti-plus"></i>
                                کارت هدیه جدید
                            </a>
                        </div>

                    </div>
                </div>

                <div class="filter-section mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select id="status-filter" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active">فعال</option>
                                <option value="inactive">غیرفعال</option>
                                <option value="expired">منقضی شده</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="balance-filter" class="form-control">
                                <option value="">همه موجودی‌ها</option>
                                <option value="high">بالای ۱۰۰,۰۰۰ تومان</option>
                                <option value="medium">۵۰,۰۰۰ - ۱۰۰,۰۰۰ تومان</option>
                                <option value="low">کمتر از ۵۰,۰۰۰ تومان</option>
                                <option value="zero">صفر</option>
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

                <table class="table table-bordered table-striped" id="giftcards-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">کد کارت هدیه</th>
                        <th class="text-center text-primary">موجودی اولیه</th>
                        <th class="text-center text-primary">موجودی فعلی</th>
                        <th class="text-center text-primary">کاربر</th>
                        <th class="text-center text-primary">وضعیت</th>
                        <th class="text-center text-primary">تاریخ انقضا</th>
                        <th class="text-center text-primary">تراکنش‌ها</th>
                        <th class="text-center text-primary">تاریخ ایجاد</th>
                        <th class="text-center text-primary">عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($giftCards as $giftCard)
                        <tr id="giftcard-row-{{ $giftCard->id }}" class="giftcard-row">
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-primary">{{ $giftCard->code }}</span>
                            </td>

                            <td class="text-center align-middle">
                                {{ number_format($giftCard->initial_balance) }} تومان
                            </td>

                            <td class="text-center align-middle">
                                @php
                                    $balancePercent = ($giftCard->current_balance / $giftCard->initial_balance) * 100;
                                @endphp
                                <span class="badge {{ $balancePercent > 50 ? 'badge-success' : ($balancePercent > 0 ? 'badge-warning' : 'badge-danger') }}">
                                    {{ number_format($giftCard->current_balance) }} تومان
                                </span>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar {{ $balancePercent > 50 ? 'bg-success' : ($balancePercent > 0 ? 'bg-warning' : 'bg-danger') }}"
                                         style="width: {{ $balancePercent }}%"></div>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                {{ $giftCard->user->name ?? '-' }}
                                @if($giftCard->user)
                                    <br>
                                    <small class="text-muted">{{ $giftCard->user->mobile ?? '' }}</small>
                                @endif
                            </td>

                            <td class="text-center align-middle">
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

                            <td class="text-center align-middle">
                                {{ $giftCard->expires_at ? verta($giftCard->expires_at)->format('Y/m/d') : 'نامحدود' }}
                                @if($giftCard->expires_at && $giftCard->expires_at->isFuture())
                                    <br>
                                    <small class="text-muted">
                                        {{ verta($giftCard->expires_at)->diffForHumans() }}
                                    </small>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <a href="{{ route('gift-cards.show', $giftCard->id) }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="ti-list"></i>
                                    {{ $giftCard->transactions->count() }} تراکنش
                                </a>
                            </td>

                            <td class="text-center align-middle">
                                {{ verta($giftCard->created_at)->format('Y/m/d') }}
                            </td>

                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('gift-cards.show', $giftCard->id) }}"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="ti-eye"></i>
                                        جزئیات
                                    </a>

                                    <button type="button"
                                            class="btn btn-outline-{{ $giftCard->is_active ? 'warning' : 'success' }} btn-sm toggle-status"
                                            data-id="{{ $giftCard->id }}"
                                            data-status="{{ $giftCard->is_active }}">
                                        <i class="ti-{{ $giftCard->is_active ? 'close' : 'check' }}"></i>
                                        {{ $giftCard->is_active ? 'غیرفعال' : 'فعال' }}
                                    </button>

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm delete-giftcard"
                                            data-id="{{ $giftCard->id }}"
                                            data-code="{{ $giftCard->code }}">
                                        <i class="ti-trash"></i>
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <i class="ti-info-alt"></i>
                                هیچ کارت هدیه‌ای یافت نشد
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $giftCards->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // تغییر وضعیت کارت هدیه
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
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
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
                            error: function(xhr) {
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
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
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
                                    $(`#giftcard-row-${giftCardId}`).fadeOut(300, function() {
                                        $(this).remove();
                                        if ($('.giftcard-row').length === 0) {
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

            // جستجو
            let searchTimeout;
            $('#search-giftcard').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    filterGiftCards();
                }, 500);
            });

            $('#search-btn').click(function() {
                filterGiftCards();
            });

            $('#status-filter').change(function() {
                filterGiftCards();
            });

            $('#balance-filter').change(function() {
                filterGiftCards();
            });

            $('#reset-filters').click(function() {
                $('#search-giftcard').val('');
                $('#status-filter').val('');
                $('#balance-filter').val('');
                filterGiftCards();
            });

            function filterGiftCards() {
                const searchTerm = $('#search-giftcard').val().toLowerCase();
                const statusFilter = $('#status-filter').val();
                const balanceFilter = $('#balance-filter').val();

                $('.giftcard-row').each(function() {
                    let show = true;
                    const row = $(this);
                    const code = row.find('td:eq(1)').text().toLowerCase();
                    const statusBadge = row.find('td:eq(5) .badge').text().trim();
                    const balanceText = row.find('td:eq(3)').text().trim();
                    const balance = parseInt(balanceText.replace(/[^0-9]/g, ''));

                    if (searchTerm && !code.includes(searchTerm)) {
                        show = false;
                    }

                    if (statusFilter) {
                        if (statusFilter === 'active' && statusBadge !== 'فعال') {
                            show = false;
                        } else if (statusFilter === 'inactive' && statusBadge !== 'غیرفعال') {
                            show = false;
                        } else if (statusFilter === 'expired' && statusBadge !== 'منقضی شده') {
                            show = false;
                        }
                    }

                    if (balanceFilter) {
                        if (balanceFilter === 'high' && balance <= 100000) {
                            show = false;
                        } else if (balanceFilter === 'medium' && (balance < 50000 || balance > 100000)) {
                            show = false;
                        } else if (balanceFilter === 'low' && (balance >= 50000 || balance === 0)) {
                            show = false;
                        } else if (balanceFilter === 'zero' && balance !== 0) {
                            show = false;
                        }
                    }

                    if (show) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });

                const visibleRows = $('.giftcard-row:visible').length;
                if (visibleRows === 0) {
                    if ($('#no-results-row').length === 0) {
                        $('#giftcards-table tbody').append(`
                        <tr id="no-results-row">
                            <td colspan="10" class="text-center text-muted">
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

        #giftcards-table tbody tr {
            transition: all 0.3s ease;
        }

        #giftcards-table tbody tr:hover {
            background-color: #f5f5f5;
            transform: scale(1.01);
        }

        .input-group {
            width: 250px;
        }

        .progress {
            border-radius: 10px;
            background-color: #e9ecef;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.3s ease;
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

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endpush
