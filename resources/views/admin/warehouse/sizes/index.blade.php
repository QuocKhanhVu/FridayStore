@extends('admin.layouts.master')

@section('title', 'Quản lý Size')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Quản lý Size
            </h3>
            <p class="text-muted mb-0">
                Cấu hình size cho từng loại trang phục
            </p>
        </div>

        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>
            Thêm Size
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sizes.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            class="form-control"
                            placeholder="Tìm tên trang phục..."
                        >
                    </div>

                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search me-2"></i>
                            Tìm kiếm
                        </button>
                    </div>

                    @if(request('keyword'))
                        <div class="col-md-auto">
                            <a href="{{ route('admin.sizes.index') }}"
                               class="btn btn-secondary">
                                <i class="fa fa-rotate-left me-2"></i>
                                Làm mới
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Danh sách size
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Trang phục</th>
                            <th>Size</th>
                            <th>Chiều cao</th>
                            <th>Cân nặng</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th width="140">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $item)
                            <tr>

                                <td>
                                    {{
                                        ($data->currentPage() - 1)
                                        * $data->perPage()
                                        + $loop->iteration
                                    }}
                                </td>

                                <td>
                                    {{ $item->costume->name ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $item->size_name }}
                                    </span>
                                </td>

                                <td>
                                    @if($item->rule)
                                        {{ $item->rule->height_from }}
                                        -
                                        {{ $item->rule->height_to }} cm
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($item->rule)
                                        {{ $item->rule->weight_from }}
                                        -
                                        {{ $item->rule->weight_to }} kg
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ $item->display_order }}
                                </td>

                                <td>
                                    @if($item->status)
                                        <span class="badge bg-success">
                                            Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Ngừng hoạt động
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.sizes.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.sizes.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa size này?')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Không có dữ liệu
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($data->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

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

</div>
@endsection