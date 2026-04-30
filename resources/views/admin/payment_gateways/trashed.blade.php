{{-- resources/views/admin/discounts/trashed.blade.php --}}

@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="form-group row mb-4 pt-2">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-info">
                            <i class="ti-arrow-left"></i>
                            بازگشت به لیست تخفیف‌ها
                        </a>
                    </div>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>کد تخفیف</th>
                        <th>نوع</th>
                        <th>مقدار</th>
                        <th>تاریخ حذف</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($trashedDiscounts as $discount)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $discount->code }}</td>
                            <td>{{ $discount->type == 'percent' ? 'درصدی' : 'مبلغ ثابت' }}</td>
                            <td>{{ number_format($discount->value) }} {{ $discount->type == 'percent' ? '%' : 'تومان' }}</td>
                            <td>{{ verta($discount->deleted_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.discounts.restore', $discount->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="ti-reload"></i>
                                        بازیابی
                                    </button>
                                </form>

                                <form action="{{ route('admin.discounts.force-delete', $discount->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('حذف کامل این کد تخفیف؟')">
                                        <i class="ti-trash"></i>
                                        حذف کامل
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">سطل زباله خالی است</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $trashedDiscounts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
