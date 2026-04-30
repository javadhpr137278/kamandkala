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

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">

                <div class="form-group row mb-4 pt-2">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center">

                        <div></div>

                        <div class="d-flex">
                            <div class="input-group">
                                <input type="text" id="search-gateway" class="form-control" placeholder="جستجوی درگاه...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="search-btn">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </div>

                            <a href="{{ route('payment-gateways.create') }}" class="btn btn-outline-info mx-2">
                                <i class="ti-plus"></i>
                                درگاه جدید
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

                <table class="table table-bordered table-striped" id="gateways-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">نام سیستم</th>
                        <th class="text-center text-primary">عنوان نمایشی</th>
                        <th class="text-center text-primary">Merchant</th>
                        <th class="text-center text-primary">Callback</th>
                        <th class="text-center text-primary">وضعیت</th>
                        <th class="text-center text-primary">عملیات</th>
                    </tr>
                    </thead>

                    <tbody id="gateways-tbody">
                    @forelse($gateways as $gateway)
                        <tr id="gateway-row-{{ $gateway->id }}" class="gateway-row">
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>

                            <td class="text-center align-middle">
                                <span class="badge badge-primary">{{ $gateway->name }}</span>
                            </td>

                            <td class="text-center align-middle">{{ $gateway->title }}</td>

                            <td class="text-center align-middle">
                                {{ $gateway->config['merchant'] ?? '-' }}
                            </td>

                            <td class="text-center align-middle">
                                <small>{{ $gateway->config['callback_url'] ?? '-' }}</small>
                            </td>

                            <td class="text-center align-middle">
                                @if($gateway->is_active)
                                    <span class="badge badge-success">فعال</span>
                                @else
                                    <span class="badge badge-warning">غیرفعال</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <div class="btn-group">

                                    <a href="{{ route('payment-gateways.edit', $gateway->id) }}"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="ti-pencil"></i>
                                        ویرایش
                                    </a>

                                    @if(!$gateway->is_active)
                                        <a href="{{ route('payment-gateways.activate', $gateway->id) }}"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="ti-check"></i>
                                            فعال‌سازی
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            فعال است
                                        </button>
                                    @endif

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm delete-gateway"
                                            data-id="{{ $gateway->id }}"
                                            data-name="{{ $gateway->name }}">
                                        <i class="ti-trash"></i>
                                        حذف
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">هیچ درگاهی یافت نشد</td></tr>
                    @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('.delete-gateway').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'حذف درگاه',
                    html: `آیا از حذف درگاه <strong>${name}</strong> اطمینان دارید؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: `/admin/payment-gateways/${id}`,
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function(response) {
                                Swal.fire('حذف شد!', response.message, 'success');
                                $(`#gateway-row-${id}`).fadeOut(300, function(){
                                    $(this).remove();
                                });
                            },
                            error: function() {
                                Swal.fire('خطا!', 'مشکلی رخ داد', 'error');
                            }
                        });

                    }
                });
            });

            let searchTimeout;

            $('#search-gateway').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterGateways, 400);
            });

            $('#status-filter').change(filterGateways);

            $('#reset-filters').click(function() {
                $('#search-gateway').val('');
                $('#status-filter').val('');
                filterGateways();
            });

            function filterGateways() {
                const searchTerm = $('#search-gateway').val().toLowerCase();
                const status = $('#status-filter').val();

                $('.gateway-row').each(function() {
                    let show = true;
                    const row = $(this);

                    const name = row.find('td:eq(1)').text().toLowerCase();
                    const isActive = row.find('td:eq(5) .badge').text().trim() === 'فعال';

                    if (searchTerm && !name.includes(searchTerm)) {
                        show = false;
                    }

                    if (status === 'active' && !isActive) show = false;
                    if (status === 'inactive' && isActive) show = false;

                    row.toggle(show);
                });
            }

        });
    </script>

@endpush


@push('styles')
    <style>
        .badge { font-size: 12px; padding: 5px 10px; border-radius: 20px; }
        #gateways-table tbody tr { transition: .3s; }
        #gateways-table tbody tr:hover { background: #f5f5f5; transform: scale(1.01); }
        .filter-section { background: #f8f9fa; padding: 15px; border-radius: 8px; }
        .input-group { width: 250px; }
    </style>
@endpush
