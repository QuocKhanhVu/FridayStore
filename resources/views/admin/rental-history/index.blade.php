@extends('admin.layouts.master')

@section('title','Lịch sử thuê đồ')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Lịch sử thuê đồ
            </h2>

            <p class="text-muted mb-0">
                Danh sách đơn đã hoàn thành
            </p>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Tìm mã đơn, trường, lớp..."
                            value="{{ request('keyword') }}"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary"
                        >
                            <i class="fa fa-search me-2"></i>
                            Tìm kiếm
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif
    <div class="card border-0 shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Mã đơn</th>

                        <th>Trường</th>

                        <th>Lớp</th>

                        <th>Concept</th>

                        <th>Sĩ số</th>

                        <th>Ngày chụp</th>

                        <th width="120">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                        <tr>

                            <td>

                                <span
                                    class="
                                        fw-bold
                                        text-primary
                                    "
                                >
                                    {{ $item->code }}
                                </span>

                            </td>

                            <td>
                                {{ $item->school_name }}
                            </td>

                            <td>
                                {{ $item->class_name }}
                            </td>

                            <td>

                                <span
                                    class="
                                        badge
                                        bg-info
                                    "
                                >
                                    {{ $item->concept->name ?? '---' }}
                                </span>

                            </td>

                            <td>

                                {{ $item->students_count }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y') }}

                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    <a
                                        href="{{ route('admin.rental-history.show', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Xem chi tiết"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.rental-history.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn này khỏi lịch sử?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Xóa"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="
                                    text-center
                                    py-5
                                "
                            >

                                Không có dữ liệu

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        {{ $data->links() }}

    </div>

</div>

@endsection