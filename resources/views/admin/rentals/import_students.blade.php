@extends('admin.layouts.master')

@section('title', 'Import danh sách học sinh')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h4 class="mb-0">
                        Import danh sách học sinh
                    </h4>

                </div>

                <form
                    action="{{ route('admin.rentals.students.store',$rental->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    <div class="card-body">

                        <div class="alert alert-info">

                            <strong>Thông tin đơn thuê:</strong>

                            <hr>

                            <p class="mb-1">
                                <strong>Mã đơn:</strong>
                                {{ $rental->code }}
                            </p>

                            <p class="mb-1">
                                <strong>Trường:</strong>
                                {{ $rental->school_name }}
                            </p>

                            <p class="mb-0">
                                <strong>Lớp:</strong>
                                {{ $rental->class_name }}
                            </p>

                        </div>

                        {{-- FILE EXCEL --}}

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                File Excel

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="file"
                                name="file"
                                class="form-control @error('file') is-invalid @enderror"
                                accept=".xlsx,.xls"
                            >

                            @error('file')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <hr>

                        <h5 class="mb-3">
                            Cấu hình cột dữ liệu
                        </h5>

                        <div class="row">

                            {{-- START ROW --}}

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Dòng bắt đầu

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="start_row"
                                    value="{{ old('start_row',10) }}"
                                    class="form-control @error('start_row') is-invalid @enderror"
                                >

                                @error('start_row')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- NAME COLUMN --}}

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Họ tên

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="name_column"
                                    value="{{ old('name_column','B') }}"
                                    class="form-control @error('name_column') is-invalid @enderror"
                                >

                                @error('name_column')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- GENDER COLUMN --}}

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Giới tính

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="gender_column"
                                    value="{{ old('gender_column','C') }}"
                                    class="form-control @error('gender_column') is-invalid @enderror"
                                >

                                @error('gender_column')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- HEIGHT COLUMN --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Chiều cao

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="height_column"
                                    value="{{ old('height_column','D') }}"
                                    class="form-control @error('height_column') is-invalid @enderror"
                                >

                                @error('height_column')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- WEIGHT COLUMN --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Cân nặng

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="weight_column"
                                    value="{{ old('weight_column','E') }}"
                                    class="form-control @error('weight_column') is-invalid @enderror"
                                >

                                @error('weight_column')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <div class="alert alert-warning">

                            <h6>
                                Ví dụ file Excel
                            </h6>

                            <ul class="mb-0">

                                <li>
                                    Họ tên ở cột B
                                </li>

                                <li>
                                    Giới tính ở cột C
                                </li>

                                <li>
                                    Chiều cao ở cột D
                                </li>

                                <li>
                                    Cân nặng ở cột E
                                </li>

                                <li>
                                    Dữ liệu bắt đầu từ dòng 10
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="card-footer bg-white text-end">

                        <a
                            href="{{ route('admin.rentals.index') }}"
                            class="btn btn-secondary"
                        >
                            Quay lại
                        </a>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fa fa-file-excel me-2"></i>
                            Import Excel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection