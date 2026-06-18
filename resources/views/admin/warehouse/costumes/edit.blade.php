
@extends('admin.layouts.master')

@section('title', 'Cập nhật trang phục')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Cập nhật trang phục
            </h3>

            <p class="text-muted mb-0">
                Chỉnh sửa thông tin trang phục
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

    <form action="{{ route('admin.costumes.update', $costume->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

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
                                    value="{{ old('name', $costume->name) }}"
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
                                    Mã trang phục
                                </label>

                                <input
                                    type="text"
                                    name="code"
                                    value="{{ old('code', $costume->code) }}"
                                    class="form-control @error('code') is-invalid @enderror"
                                >

                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <div class="row">

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
                                            {{ old('category_id', $costume->category_id) == $category->id ? 'selected' : '' }}
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

                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Giới tính
                                </label>

                                <select
                                    name="gender"
                                    class="form-select @error('gender') is-invalid @enderror"
                                >

                                    <option
                                        value="male"
                                        {{ old('gender', $costume->gender) == 'male' ? 'selected' : '' }}
                                    >
                                        Nam
                                    </option>

                                    <option
                                        value="female"
                                        {{ old('gender', $costume->gender) == 'female' ? 'selected' : '' }}
                                    >
                                        Nữ
                                    </option>

                                    <option
                                        value="unisex"
                                        {{ old('gender', $costume->gender) == 'unisex' ? 'selected' : '' }}
                                    >
                                        Unisex
                                    </option>

                                </select>

                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

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
                                        {{ old('has_size', $costume->has_size) == 1 ? 'selected' : '' }}
                                    >
                                        Có chia size
                                    </option>

                                    <option
                                        value="0"
                                        {{ old('has_size', $costume->has_size) == 0 ? 'selected' : '' }}
                                    >
                                        Không chia size
                                    </option>

                                </select>

                                @error('has_size')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Giá thuê
                                </label>

                                <div class="input-group">

                                    <input
                                        type="number"
                                        name="rental_price"
                                        value="{{ old('rental_price', $costume->rental_price) }}"
                                        class="form-control @error('rental_price') is-invalid @enderror"
                                    >

                                    <span class="input-group-text">
                                        VNĐ
                                    </span>

                                </div>

                                @error('rental_price')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Mô tả
                            </label>

                            <textarea
                                rows="5"
                                name="description"
                                class="form-control"
                            >{{ old('description', $costume->description) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

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
                            class="form-control"
                        >

                        <div class="text-center mt-4">

                            <img
                                src="{{ $costume->image
                                    ? asset('storage/' . $costume->image)
                                    : 'https://placehold.co/250x250' }}"
                                class="img-fluid rounded border"
                            >

                        </div>

                    </div>

                </div>

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
                                {{ old('status', $costume->status) == 1 ? 'checked' : '' }}
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
                                {{ old('status', $costume->status) == 0 ? 'checked' : '' }}
                            >

                            <label class="form-check-label">
                                Ngừng sử dụng
                            </label>

                        </div>

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-warning w-100"
                >

                    <i class="fa fa-pen-to-square me-2"></i>

                    Cập nhật trang phục

                </button>

            </div>

        </div>

    </form>

</div>

@endsection
```
