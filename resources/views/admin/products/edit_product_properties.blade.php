@extends('admin.layouts.master')

@section('content')

    <div class="container-xxl py-4">

        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title mb-4">ویرایش ویژگی</h5>

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('property.update',$property->id) }}">
                            @csrf

                            <div class="mb-3">

                                <label class="form-label">نام ویژگی</label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ $property->title }}"
                                    required
                                >

                            </div>

                            <div class="mb-3">

                                <label class="form-label">گروه ویژگی</label>

                                <select name="property_group_id" class="form-select">

                                    @foreach($property_groups as $group)

                                        <option
                                            value="{{ $group->id }}"
                                            @if($group->id == $property->property_group_id) selected @endif
                                        >

                                            {{ $group->title }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <button class="btn btn-success w-100">
                                بروزرسانی ویژگی
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
