@extends('admin.layouts.master')

@section('title', 'Tồn kho')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Quản lý tồn kho</h3>
        <p class="text-muted mb-0">
            Theo dõi số lượng trang phục theo từng size
        </p>
    </div>

    <div>
        <a
            href="{{ route('admin.inventory.export') }}"
            class="btn btn-success shadow-sm"
        >
            <i class="fa fa-file-excel me-2"></i>
            Xuất Excel
        </a>
    </div>

</div>

{{-- Bộ lọc --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-2">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        class="form-control"
                        placeholder="Tìm kiếm trang phục..."
                    >

                </div>

                <div class="col-md-3">

                    <select
                        name="category_id"
                        class="form-select"
                    >

                        <option value="">
                            Tất cả loại trang phục
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        name="size_id"
                        class="form-select"
                    >

                        <option value="">
                            Tất cả size
                        </option>

                        @foreach($sizes as $size)

                            <option
                                value="{{ $size->id }}"
                                {{ request('size_id') == $size->id ? 'selected' : '' }}
                            >
                                {{ $size->size_name }}
                            </option>

                        @endforeach

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

                <div class="col-md-1">

                    <a
                        href="{{ route('admin.inventory.index') }}"
                        class="btn btn-outline-secondary w-100"
                    >
                        <i class="fa fa-rotate"></i>
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- Thống kê --}}
<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Tổng sản phẩm
                </h6>

                <h2 class="fw-bold">
                    {{ \App\Models\Inventory::sum('quantity') }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Đang cho thuê
                </h6>

                <h2 class="fw-bold text-primary">
                    {{ \App\Models\Inventory::sum('rented_quantity') }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Sắp hết hàng
                </h6>

                <h2 class="fw-bold text-warning">
                    {{
                        \App\Models\Inventory::get()
                        ->filter(function ($item) {

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                            return $available > 0
                                && $available <= 5;
                        })
                        ->count()
                    }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Hết hàng
                </h6>

                <h2 class="fw-bold text-danger">
                    {{
                        \App\Models\Inventory::get()
                        ->filter(function ($item) {

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                            return $available <= 0;
                        })
                        ->count()
                    }}
                </h2>

            </div>

        </div>

    </div>

</div>

{{-- Danh sách tồn kho --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Danh sách tồn kho
        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>Trang phục</th>
                        <th>Size</th>
                        <th>Tồn kho</th>
                        <th>Đang thuê</th>
                        <th>Khả dụng</th>
                        <th>Trạng thái</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                        @php

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                        @endphp

                        <tr>

                            <td>
                                {{
                                    ($data->currentPage() - 1)
                                    * $data->perPage()
                                    + $loop->iteration
                                }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->costume?->name }}
                                </strong>
                            </td>

                            <td>
                                {{ $item->size?->size_name }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                {{ $item->rented_quantity }}
                            </td>

                            <td>
                                {{ $available }}
                            </td>

                            <td>

                                @if($available <= 0)

                                    <span class="badge bg-danger">
                                        Hết hàng
                                    </span>

                                @elseif($available <= 5)

                                    <span class="badge bg-warning text-dark">
                                        Sắp hết
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Còn hàng
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-4"
                            >
                                Chưa có dữ liệu tồn kho
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($data->hasPages())

        <div
            class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2"
        >

            <small class="text-muted">

                Hiển thị
                {{ $data->firstItem() ?? 0 }}
                -
                {{ $data->lastItem() ?? 0 }}
                /
                {{ $data->total() }} bản ghi

            </small>

            {{ $data->withQueryString()->links() }}

        </div>

    @endif

</div>

@endsection