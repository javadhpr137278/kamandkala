@extends('admin.layouts.master')
@section('content')

    <div class="page-header">
        <div class="row">

            <div class="col-sm-6 text-left">

                <a href="{{ route('variants.create',$product->id) }}"
                   class="btn btn-outline-info mx-2">

                    <i class="ti-plus"></i>
                    ایجاد تنوع جدید

                </a>

            </div>

        </div>
    </div>


    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                    <tr>

                        <th class="text-center">ردیف</th>

                        <th class="text-center">قیمت اصلی</th>

                        <th class="text-center">تخفیف</th>

                        <th class="text-center">قیمت نهایی</th>

                        <th class="text-center">گارانتی</th>

                        <th class="text-center">موجودی</th>

                        <th class="text-center">حداکثر خرید</th>

                        <th class="text-center">رنگ</th>

                        <th class="text-center">عملیات</th>

                        <th class="text-center">تاریخ</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($variants as $variant)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center">
                                {{ number_format($variant->main_price) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($variant->discount_percent) }} %
                            </td>

                            <td class="text-center">
                                {{ number_format($variant->discount_price) }}
                            </td>

                            <td>{{ $variant->guaranty->title ?? 'بدون گارانتی' }}</td>

                            <td class="text-center">
                                {{ $variant->stock }}
                            </td>

                            <td class="text-center">
                                {{ $variant->max_sell }}
                            </td>

                            <td class="text-center">
                                {{ $variant->color->name ?? '-' }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('variants.edit', [$product->id, $variant->id]) }}"
                                   class="btn btn-outline-warning btn-sm">

                                    ویرایش

                                </a>

                                <form action="{{ route('variants.delete', [$product->id, $variant->id]) }}"
                                      method="POST"
                                      style="display:inline-block">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('آیا حذف شود؟')">

                                        حذف

                                    </button>

                                </form>

                            </td>

                            <td class="text-center">

                                {{ verta($variant->created_at)->format('Y/m/d') }}

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $variants->links() }}

            </div>

        </div>

    </div>

@endsection
