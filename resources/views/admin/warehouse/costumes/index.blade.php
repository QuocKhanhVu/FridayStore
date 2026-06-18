@extends('admin.layouts.master')

@section('title', 'Danh mục trang phục')

@section('content')

<div class="container-fluid">

    {{-- Header --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Danh mục trang phục
            </h3>

            <p class="text-muted mb-0">
                Quản lý toàn bộ trang phục trong kho
            </p>

        </div>

        <div>

            <a href="{{ route('admin.costumes.export', [
                    'keyword' => request('keyword'),
                    'gender' => request('gender'),
                    'status' => request('status'),
                ]) }}"
            class="btn btn-outline-success me-2">

                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel

            </a>

            <a href="{{ route('admin.costumes.create') }}"
               class="btn btn-primary">

                <i class="fa fa-plus me-2"></i>
                Thêm trang phục

            </a>

        </div>

    </div>

    {{-- Alert --}}

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- Search --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            class="form-control"
                            placeholder="Tìm kiếm tên trang phục..."
                        >

                    </div>

                    <div class="col-md-2">

                        <select
                            name="gender"
                            class="form-select"
                        >

                            <option value="">
                                Tất cả giới tính
                            </option>

                            <option value="male"
                                {{ request('gender') == 'male' ? 'selected' : '' }}>
                                Nam
                            </option>

                            <option value="female"
                                {{ request('gender') == 'female' ? 'selected' : '' }}>
                                Nữ
                            </option>

                            <option value="unisex"
                                {{ request('gender') == 'unisex' ? 'selected' : '' }}>
                                Unisex
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                Tất cả trạng thái
                            </option>

                            <option value="1"
                                {{ request('status') == '1' ? 'selected' : '' }}>
                                Hoạt động
                            </option>

                            <option value="0"
                                {{ request('status') == '0' ? 'selected' : '' }}>
                                Ngừng sử dụng
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100"
                        >

                            <i class="fa fa-search me-2"></i>
                            Tìm kiếm

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('admin.costumes.index') }}"
                           class="btn btn-secondary w-100">

                            Làm mới

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Table --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Danh sách trang phục
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="80">
                                Ảnh
                            </th>

                            <th>
                                Mã
                            </th>

                            <th>
                                Tên trang phục
                            </th>

                            <th>
                                Loại
                            </th>

                            <th>
                                Giới tính
                            </th>

                            <th>
                                Giá thuê
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th width="150">
                                Thao tác
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($costumes as $costume)

                            <tr>

                                <td>

                                    @if($costume->image)

                                        <img
                                            src="{{ asset('storage/' . $costume->image) }}"
                                            width="50"
                                            height="50"
                                            class="rounded border"
                                            style="object-fit:cover"
                                        >

                                    @else

                                        <img
                                            src="https://placehold.co/50x50"
                                            width="50"
                                            height="50"
                                            class="rounded border"
                                        >

                                    @endif

                                </td>

                                <td>

                                    {{ $costume->code }}

                                </td>

                                <td>

                                    <strong>

                                        {{ $costume->name }}

                                    </strong>

                                </td>

                                <td>

                                    {{ $costume->category?->name }}

                                </td>

                                <td>

                                    @switch($costume->gender)

                                        @case('male')
                                            Nam
                                            @break

                                        @case('female')
                                            Nữ
                                            @break

                                        @default
                                            Unisex

                                    @endswitch

                                </td>

                                <td>

                                    {{ number_format($costume->rental_price) }} đ

                                </td>

                                <td>

                                    @if($costume->status)

                                        <span class="badge bg-success">
                                            Hoạt động
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Ngừng sử dụng
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{route('admin.costumes.edit',$costume->id)}}"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i class="fa fa-pen"></i>

                                    </a>

                                    <form
                                        action="{{ route('admin.costumes.destroy', $costume->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa trang phục này?')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fa fa-box-open fa-3x mb-3"></i>

                                        <p class="mb-0">

                                            Chưa có trang phục nào

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($costumes->hasPages())

            <div class="card-footer bg-white">

                {{ $costumes->links() }}

            </div>

        @endif

    </div>

</div>

@endsection