@extends('admin.layouts.master')

@section('content')
    <div class="row">
        @if(session('message'))
            <div class="alert alert-info">
                <div>{{ session('message') }}</div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label">عنوان جستجو</label>
                    <div class="col-sm-8">
                        <label>
                            <input type="text" class="form-control text-left" dir="rtl" wire:model="search">
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{route('guaranties.index')}}" class="btn btn-danger text-white">
                            برگشت به لیست گارانتی ها
                        </a>
                    </div>
                </div>

                <h3>{{ $title }}</h3>

                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center text-primary">#</th>
                        <th class="text-center text-primary">عنوان</th>
                        <th class="text-center text-primary">بازیابی</th>
                        <th class="text-center text-primary">حذف کامل</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($guaranties as $guaranty)
                        <tr>
                            <td class="text-center align-middle">{{ $guaranty->id }}</td>
                            <td class="text-center align-middle">{{ $guaranty->title }}</td>
                            <td class="text-center align-middle">

                                {{-- Restore --}}
                                <form action="{{ route('guaranties.restore',$guaranty->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-info btn-sm">بازیابی</button>
                                </form>
                            </td>

                            <td class="text-center align-middle">
                                {{-- Force Delete --}}
                                <form action="{{ route('guaranties.forceDelete',$guaranty->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">حذف کامل</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $guaranties->links() }}


            </div>
        </div>
    </div>
@endsection
