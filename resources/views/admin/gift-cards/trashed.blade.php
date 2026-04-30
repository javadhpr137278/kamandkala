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
                            <a href="{{ route('gift-cards.index') }}" class="btn btn-outline-info">
                                <i class="ti-arrow-left"></i>
                                بازگشت به لیست کارت هدیه‌ها
                            </a>
                        </div>

                        <div class="d-flex">
                            <div class="input-group">
                                <input type="text" id="search-trashed" class="form-control" placeholder="جستجوی کارت هدیه حذف شده...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="search-btn">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">کد کارت هدیه</th>
                        <th class="text-center text-primary">موجودی اولیه</th>
                        <th class="text-center text-primary">موجودی هنگام حذف</th>
                        <th class="text-center text-primary">کاربر</th>
                        <th class="text-center text-primary">تاریخ انقضا</th>
                        <th class="text-center text-primary">تاریخ حذف</th>
                        <th class="text-center text-primary">عملیات</th>
                    </tr>
                    </thead>

                    <tbody id="trashed-tbody">
                    @forelse($trashedGiftCards as $giftCard)
                        <tr id="giftcard-row-{{ $giftCard->id }}" class="giftcard-row">
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-danger">{{ $giftCard->code }}</span>
                            </td>

                            <td class="text-center align-middle">
                                {{ number_format($giftCard->initial_balance) }} تومان
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-warning">
                                    {{ number_format($giftCard->current_balance) }} تومان
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                {{ $giftCard->user->name ?? '-' }}
                                @if($giftCard->user)
                                    <br>
                                    <small class="text-muted">{{ $giftCard->user->mobile ?? '' }}</small>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                {{ $giftCard->expires_at ? verta($giftCard->expires_at)->format('Y/m/d') : 'نامحدود' }}
                            </td>

                            <td class="text-center align-middle">
                                {{ verta($giftCard->deleted_at)->format('Y/m/d H:i') }}
                                <br>
                                <small class="text-muted">{{ verta($giftCard->deleted_at)->diffForHumans() }}</small>
                            </td>

                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <button type="button"
                                            class="btn btn-outline-success btn-sm restore-giftcard"
                                            data-id="{{ $giftCard->id }}"
                                            data-code="{{ $giftCard->code }}">
                                        <i class="ti-reload"></i>
                                        بازیابی
                                    </button>

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm force-delete-giftcard"
                                            data-id="{{ $giftCard->id }}"
                                            data-code="{{ $giftCard->code }}">
                                        <i class="ti-trash"></i>
                                        حذف کامل
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="ti-info-alt"></i>
                                سطل زباله خالی است
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $trashedGiftCards->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // بازیابی کارت هدیه
            $('.restore-giftcard').click(function() {
                const btn = $(this);
                const giftCardId = btn.data('id');
                const giftCardCode = btn.data('code');

                Swal.fire({
                    title: 'بازیابی کارت هدیه',
                    html: `آیا از بازیابی کارت هدیه <strong>${giftCardCode}</strong> اطمینان دارید؟`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'بله، بازیابی شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/gift-cards/${giftCardId}/restore`,
                            type: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('بازیابی شد!', response.message, 'success');
                                    $(`#giftcard-row-${giftCardId}`).fadeOut(300, function() {
                                        $(this).remove();
                                        if ($('.giftcard-row').length === 0) {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('خطا!', 'مشکلی در بازیابی رخ داد', 'error');
                            }
                        });
                    }
                });
            });

            // حذف کامل کارت هدیه
            $('.force-delete-giftcard').click(function() {
                const btn = $(this);
                const giftCardId = btn.data('id');
                const giftCardCode = btn.data('code');

                Swal.fire({
                    title: 'حذف کامل کارت هدیه',
                    html: `آیا از حذف کامل کارت هدیه <strong class="text-danger">${giftCardCode}</strong> اطمینان دارید؟<br>
                       <small class="text-warning">این عمل غیرقابل بازگشت است!</small>`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف کامل شود',
                    cancelButtonText: 'خیر',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/gift-cards/${giftCardId}/force-delete`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('حذف کامل شد!', response.message, 'success');
                                    $(`#giftcard-row-${giftCardId}`).fadeOut(300, function() {
                                        $(this).remove();
                                        if ($('.giftcard-row').length === 0) {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('خطا!', 'مشکلی در حذف کامل رخ داد', 'error');
                            }
                        });
                    }
                });
            });

            // جستجوی داینامیک
            let searchTimeout;
            $('#search-trashed').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    filterTrashed();
                }, 500);
            });

            $('#search-btn').click(function() {
                filterTrashed();
            });

            function filterTrashed() {
                const searchTerm = $('#search-trashed').val().toLowerCase();

                $('.giftcard-row').each(function() {
                    const row = $(this);
                    const code = row.find('td:eq(1)').text().toLowerCase();
                    const user = row.find('td:eq(4)').text().toLowerCase();

                    if (searchTerm && !code.includes(searchTerm) && !user.includes(searchTerm)) {
                        row.hide();
                    } else {
                        row.show();
                    }
                });

                const visibleRows = $('.giftcard-row:visible').length;
                if (visibleRows === 0) {
                    if ($('#no-results-row').length === 0) {
                        $('#trashed-tbody').append(`
                        <tr id="no-results-row">
                            <td colspan="8" class="text-center text-muted">
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

        #trashed-tbody tr {
            transition: all 0.3s ease;
        }

        #trashed-tbody tr:hover {
            background-color: #f5f5f5;
        }

        .input-group {
            width: 300px;
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

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endpush
