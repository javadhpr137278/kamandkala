@extends('layouts.app')
@section('content')
    <div class="slider-title mt-4">
        <div class="slider-title-desc">
            <div class="slider-title-title pb-4">
                <h2 class="h1 title-font">آدرس های ثبت شده</h2>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- فرم افزودن آدرس جدید -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> افزودن آدرس جدید</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.address.store') }}" method="POST">
                @csrf
                @include('profile.address.address_form', ['address' => null])
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> ذخیره آدرس
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- لیست آدرس‌های ثبت شده -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($addresses->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                    <h5>هیچ آدرسی ثبت نشده است</h5>
                    <p>با استفاده از فرم بالا، آدرس جدید ثبت کنید.</p>
                </div>
            @else
                <div class="row">
                    @foreach($addresses as $address)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 {{ $address->is_default ? 'border-primary border-2' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="card-title mb-1">
                                                <i class="bi bi-geo-alt-fill text-primary"></i>
                                                @if($address->type == 'billing')
                                                    صورت‌حساب
                                                @elseif($address->type == 'shipping')
                                                    ارسال
                                                @else
                                                    سفارشی
                                                @endif
                                                @if($address->is_default)
                                                    <span class="badge bg-primary ms-2">پیش‌فرض</span>
                                                @endif
                                            </h6>
                                            <p class="mb-0 small text-muted">
                                                <i class="bi bi-person"></i> {{ $address->recipient_name }} |
                                                <i class="bi bi-telephone"></i> {{ $address->recipient_phone }}
                                            </p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="showEditForm({{ $address->id }})">
                                                        <i class="bi bi-pencil"></i> ویرایش
                                                    </a>
                                                </li>
                                                @if(!$address->is_default)
                                                    <li>
                                                        <form action="{{ route('dashboard.address.set-default', $address->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bi bi-check-circle"></i> تنظیم به عنوان پیش‌فرض
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('dashboard.address.delete', $address->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('آیا از حذف این آدرس مطمئن هستید؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash"></i> حذف
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <hr>

                                    <p class="card-text small">
                                        <i class="bi bi-building"></i> {{ $address->address }}
                                        @if($address->plaque)
                                            <br>پلاک: {{ $address->plaque }}
                                        @endif
                                        @if($address->unit)
                                            - واحد: {{ $address->unit }}
                                        @endif
                                    </p>

                                    <p class="card-text small text-muted">
                                        <i class="bi bi-geo"></i> {{ $address->city }}
                                        @if($address->state)
                                            - {{ $address->state }}
                                        @endif
                                    </p>

                                    @if($address->postcode)
                                        <p class="card-text small text-muted">
                                            <i class="bi bi-mailbox"></i> کد پستی: {{ $address->postcode }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- فرم ویرایش آدرس (مخفی در ابتدا) -->
                        <div id="editForm{{ $address->id }}" style="display: none;" class="mb-4">
                            <div class="card shadow-sm border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="bi bi-pencil-square"></i> ویرایش آدرس
                                        <button type="button" class="btn-close float-end" onclick="hideEditForm({{ $address->id }})"></button>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('dashboard.address.update', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="edit_id" value="{{ $address->id }}">
                                        @include('profile.address.address_form', ['address' => $address])
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" onclick="hideEditForm({{ $address->id }})">
                                                <i class="bi bi-x-circle"></i> انصراف
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> ذخیره تغییرات
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // دکمه افزودن آدرس
            const addBtn1 = document.getElementById('addAddressBtn');
            const addBtn2 = document.getElementById('addAddressBtn2');

            if (addBtn1) {
                addBtn1.addEventListener('click', openAddAddressModal);
            }

            if (addBtn2) {
                addBtn2.addEventListener('click', openAddAddressModal);
            }

            // دکمه های ویرایش
            const editButtons = document.querySelectorAll('.edit-address-btn');

            editButtons.forEach(function(btn){
                btn.addEventListener('click', function(e){
                    e.preventDefault();

                    const id = this.dataset.id;
                    openEditAddressModal(id);
                });
            });

        });


        // باز کردن مودال افزودن آدرس
        function openAddAddressModal() {

            const modalElement = document.getElementById('addAddressModal');

            if(!modalElement){
                console.error('Modal addAddressModal not found');
                return;
            }

            const modal = new bootstrap.Modal(modalElement);

            modal.show();
        }


        // باز کردن مودال ویرایش آدرس
        function openEditAddressModal(id) {

            const modalElement = document.getElementById('editAddressModal' + id);

            if(!modalElement){
                console.error('Modal editAddressModal'+id+' not found');
                return;
            }

            const modal = new bootstrap.Modal(modalElement);

            modal.show();
        }


        // کپی آدرس
        function copyAddress(address){

            const text =
                address.address + "\n" +
                address.city + "\n" +
                "کد پستی: " + address.postcode + "\n" +
                "گیرنده: " + address.recipient_name + "\n" +
                "تلفن: " + address.recipient_phone;

            navigator.clipboard.writeText(text)
                .then(function(){
                    alert('آدرس با موفقیت کپی شد');
                })
                .catch(function(){
                    alert('خطا در کپی آدرس');
                });

        }
    </script>
@endpush


@push('styles')
    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .border-primary {
            border-color: #0d6efd !important;
        }
        .form-label {
            font-weight: 500;
        }
    </style>
@endpush
