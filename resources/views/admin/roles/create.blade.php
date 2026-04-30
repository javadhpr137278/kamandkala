@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">

                <h6 class="card-title">ایجاد نقش</h6>

                {{-- errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- success --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf

                    {{-- role name --}}
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">نام نقش</label>

                        <div class="col-sm-10">
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >
                        </div>
                    </div>


                    {{-- submit --}}
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">

                            <button type="submit" class="btn btn-success">
                                ذخیره
                            </button>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
