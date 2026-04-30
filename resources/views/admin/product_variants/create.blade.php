@extends('admin.layouts.master')
@section('content')

    <div class="container mt-4">

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="productForm" method="POST" action="{{ route('variants.store',$product->id) }}">
            @csrf

            <div class="row mb-4">

                <div class="col-xxl-9 col-xl-12">

                    <div class="widget-content widget-content-area p-3">

                        {{-- Price fields --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <input type="number" name="main_price" class="form-control"
                                       placeholder="قیمت اصلی محصول" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" name="discount_percent" class="form-control"
                                       placeholder="درصد تخفیف محصول (0-100)">
                            </div>
                        </div>

                        {{-- Stock fields --}}
                        <div class="row mb-4">
                            <div class="col-sm-4">
                                <input type="number" name="stock" class="form-control"
                                       placeholder="موجودی محصول" required>
                            </div>

                            <div class="col-sm-4">
                                <input type="number" name="max_sell" class="form-control"
                                       placeholder="حداکثر فروش (اختیاری)">
                            </div>

                            <div class="col-sm-4">
                                <input type="text" name="sku" class="form-control"
                                       placeholder="کد کالا (اختیاری)">
                            </div>
                        </div>

                        {{-- Special sale --}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="customCheck"
                                           name="is_special"
                                           value="1">
                                    <label class="custom-control-label" for="customCheck">
                                        فروش شگفت‌انگیز
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">تاریخ انقضا</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="datetime-local"
                                       id="countdown_end"
                                       name="special_expiration"
                                       class="form-control"
                                       disabled
                                       value="{{ $variant->special_expiration ? $variant->special_expiration->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Sidebar --}}
                <div class="col-xxl-3 col-xl-12">

                    <div class="widget-content widget-content-area p-3">

                        <div class="row">

                            <div class="col-md-12 mb-4">
                                <label>رنگ محصول</label>
                                <select class="form-select" name="color_id" required>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label>گارانتی محصول</label>
                                <select class="form-select" name="guaranty_id">
                                    <option value="">بدون گارانتی</option>
                                    @foreach($guaranties as $guaranty)
                                        <option value="{{ $guaranty->id }}">
                                            {{ $guaranty->title }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-success w-100">افزودن تنوع</button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection



<script>
    document.addEventListener("change", function (e) {

        if (e.target && e.target.id === "customCheck") {

            const dateInput = document.getElementById("countdown_end");

            if (e.target.checked) {
                dateInput.removeAttribute("disabled");
            } else {
                dateInput.setAttribute("disabled", true);
                dateInput.value = "";
            }

        }

    });
</script>

