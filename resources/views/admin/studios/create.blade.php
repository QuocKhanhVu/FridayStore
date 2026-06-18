@extends('admin.layouts.master')

@section('title','Thêm Studio')

@section('content')

<div class="container-fluid">


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            Thêm Studio
        </h3>

        <p class="text-muted mb-0">
            Thêm mới đối tác thuê đồ
        </p>

    </div>

    <a
        href="{{ route('admin.studios.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="fa fa-arrow-left me-2"></i>
        Quay lại
    </a>

</div>

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Vui lòng kiểm tra lại dữ liệu:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form
    action="{{ route('admin.studios.store') }}"
    method="POST"
>

    @csrf

    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Thông tin Studio
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tên Studio
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Người đại diện
                            </label>

                            <input
                                type="text"
                                name="contact_person"
                                value="{{ old('contact_person') }}"
                                class="form-control @error('contact_person') is-invalid @enderror"
                            >

                            @error('contact_person')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Số điện thoại
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror"
                            >

                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Địa chỉ
                        </label>

                        <input
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            class="form-control @error('address') is-invalid @enderror"
                        >

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Ghi chú
                        </label>

                        <textarea
                            name="note"
                            rows="5"
                            class="form-control @error('note') is-invalid @enderror"
                        >{{ old('note') }}</textarea>

                        @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Trạng thái
                    </h5>

                </div>

                <div class="card-body">

                    <div class="form-check mb-2">

                        <input
                            type="radio"
                            name="status"
                            value="1"
                            checked
                            class="form-check-input"
                        >

                        <label class="form-check-label">
                            Hoạt động
                        </label>

                    </div>

                    <div class="form-check">

                        <input
                            type="radio"
                            name="status"
                            value="0"
                            class="form-check-input"
                        >

                        <label class="form-check-label">
                            Ngừng hoạt động
                        </label>

                    </div>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-primary w-100 py-3"
            >

                <i class="fa fa-save me-2"></i>

                Lưu Studio

            </button>

        </div>

    </div>

</form>
```

</div>

@endsection
