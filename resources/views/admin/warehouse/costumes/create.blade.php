@extends('admin.layouts.master')

@section('title', 'Thêm trang phục')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Thêm trang phục
            </h3>

            <p class="text-muted mb-0">
                Thêm sản phẩm mới vào danh mục kho
            </p>
        </div>

        <a href="{{ route('admin.costumes.index') }}"
           class="btn btn-outline-secondary">

            <i class="fa fa-arrow-left me-2"></i>
            Quay lại

        </a>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Vui lòng kiểm tra lại dữ liệu:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('admin.costumes.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Thông tin trang phục
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tên trang phục
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ví dụ: Áo cử nhân"
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Mã trang phục
                                </label>

                                <input
                                    type="text"
                                    name="code"
                                    value="{{ old('code') }}"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="VD: AO001"
                                >

                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <div class="row">

                            <!-- CATEGORY -->

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Loại trang phục
                                </label>

                                <select
                                    name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        Chọn loại
                                    </option>

                                    @foreach($categories as $category)

                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- GENDER -->

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Giới tính
                                </label>

                                <select
                                    name="gender"
                                    class="form-select @error('gender') is-invalid @enderror"
                                >

                                    <option value="male"
                                        {{ old('gender') == 'male' ? 'selected' : '' }}>
                                        Nam
                                    </option>

                                    <option value="female"
                                        {{ old('gender') == 'female' ? 'selected' : '' }}>
                                        Nữ
                                    </option>

                                    <option value="unisex"
                                        {{ old('gender') == 'unisex' ? 'selected' : '' }}>
                                        Unisex
                                    </option>

                                </select>

                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            {{-- HAS SIZE --}}

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Chia size
                                </label>

                                <select
                                    name="has_size"
                                    class="form-select @error('has_size') is-invalid @enderror"
                                >

                                    <option
                                        value="1"
                                        {{ old('has_size', 1) == 1 ? 'selected' : '' }}
                                    >
                                        Có chia size
                                    </option>

                                    <option
                                        value="0"
                                        {{ old('has_size') == 0 ? 'selected' : '' }}
                                    >
                                        Không chia size
                                    </option>

                                </select>

                                @error('has_size')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small class="text-muted">
                                    Chọn "Không chia" cho các sản phẩm vd:nơ, cavat,...
                                </small>

                            </div>

                            <!-- PRICE -->

                            <div class="col-md-8 mb-3">

                                <label class="form-label">
                                    Giá thuê
                                </label>

                                <div class="input-group">

                                    <input
                                        type="number"
                                        name="rental_price"
                                        value="{{ old('rental_price') }}"
                                        class="form-control"
                                        placeholder="Nhập giá thuê..."
                                    >

                                    <span class="input-group-text">
                                        VNĐ
                                    </span>
                                    @error('rental_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <!-- DESCRIPTION -->

                        <div class="mb-3">

                            <label class="form-label">
                                Mô tả
                            </label>

                            <textarea
                                rows="5"
                                name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Mô tả sản phẩm"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- IMAGE -->

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Hình ảnh
                        </h5>

                    </div>

                    <div class="card-body">

                        <input
                            type="file"
                            name="image"
                            class="form-control @error('image') is-invalid @enderror"
                        >

                        @error('image')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="text-center mt-4">

                            <img
                                src="https://placehold.co/250x250"
                                class="img-fluid rounded border"
                            >

                        </div>

                    </div>

                </div>

                <!-- STATUS -->

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Trạng thái
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="status"
                                value="1"
                                {{ old('status',1) == 1 ? 'checked' : '' }}
                            >

                            <label class="form-check-label">
                                Hoạt động
                            </label>

                        </div>

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="status"
                                value="0"
                                {{ old('status') == 0 ? 'checked' : '' }}
                            >

                            <label class="form-check-label">
                                Ngừng sử dụng
                            </label>

                        </div>

                    </div>

                </div>

                <!-- INFO -->

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="alert alert-info mb-0">

                            <i class="fa fa-circle-info me-2"></i>

                            Size của trang phục sẽ được cấu hình
                            tại mục <strong>Quản lý Size</strong>
                            sau khi lưu sản phẩm.

                        </div>

                    </div>

                </div>

                <!-- BUTTON -->

                <button
                    type="submit"
                    class="btn btn-primary w-100 mt-4"
                >

                    <i class="fa fa-save me-2"></i>

                    Lưu trang phục

                </button>

            </div>

        </div>

    </form>

</div>

@endsection