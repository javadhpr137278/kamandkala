@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h6 class="card-title">ایجاد گارانتی</h6>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- نمایش پیام موفقیت --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{route('guaranties.store')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">عنوان گارانتی</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control text-left" dir="rtl" name="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-success btn-uppercase">
                            <i class="ti-check-box m-r-5"></i> ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
