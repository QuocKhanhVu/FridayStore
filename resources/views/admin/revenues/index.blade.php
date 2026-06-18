@extends('admin.layouts.master')

@section('title','Doanh thu')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Doanh thu
            </h3>

            <p class="text-muted mb-0">
                Theo dõi doanh thu chi tiết theo từng concept
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Từ ngày
                        </label>

                        <input
                            type="date"
                            name="from"
                            value="{{ request('from') }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Đến ngày
                        </label>

                        <input
                            type="date"
                            name="to"
                            value="{{ request('to') }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Studio
                        </label>

                        <select
                            name="studio_id"
                            class="form-select"
                        >

                            <option value="">
                                Tất cả studio
                            </option>

                            @foreach($studios as $studio)

                                <option
                                    value="{{ $studio->id }}"
                                    {{ request('studio_id') == $studio->id ? 'selected' : '' }}
                                >
                                    {{ $studio->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="fa fa-filter me-1"></i>
                            Lọc
                        </button>

                        <a
                            href="{{ route('admin.revenues.index') }}"
                            class="btn btn-light border"
                        >
                            Xóa
                        </a>

                    </div>

                    <div class="col-md-3 d-flex align-items-end">

                        <a
                            href="{{ route(
                                'admin.revenues.export',
                                request()->query()
                            ) }}"
                            class="btn btn-success"
                        >
                            <i class="fa fa-file-excel me-2"></i>
                            Xuất Excel
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm h-100 revenue-card">

                <div class="card-body">

                    <div class="text-muted">
                        Tổng gốc
                    </div>

                    <h4 class="fw-bold mb-0">
                        {{ number_format($totalAmount ?? 0) }}đ
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm h-100 revenue-card">

                <div class="card-body">

                    <div class="text-muted">
                        Tổng chiết khấu
                    </div>

                    <h4 class="fw-bold text-danger mb-0">
                        {{ number_format($totalDiscount ?? 0) }}đ
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm h-100 revenue-card">

                <div class="card-body">

                    <div class="text-muted">
                        Thực nhận
                    </div>

                    <h4 class="fw-bold text-success mb-0">
                        {{ number_format($finalRevenue ?? 0) }}đ
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm h-100 revenue-card">

                <div class="card-body">

                    <div class="text-muted">
                        Số đơn / Học sinh
                    </div>

                    <h4 class="fw-bold text-primary mb-0">
                        {{ $totalOrders ?? 0 }}
                        /
                        {{ $totalStudents ?? 0 }}
                    </h4>

                </div>

            </div>

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
    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-0 fw-bold">
                    Chi tiết doanh thu theo concept
                </h5>

                <small class="text-muted">
                    Mỗi dòng tương ứng 1 concept trong đơn thuê
                </small>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle text-center mb-0">

                <thead class="table-light">

                    <tr>
                        <th rowspan="2">Mã đơn</th>
                        <th rowspan="2">Studio</th>
                        <th>Trường/lớp</th>
                        <th rowspan="2">Sĩ số</th>
                        <th>Concept</th>
                        <th>Giá/HS</th>
                        <th>Tổng gốc</th>
                        <th>CK</th>
                        <th>Thực nhận</th>
                        <th rowspan="2">Tổng thực nhận</th>
                        <th rowspan="2">Ngày chụp</th>
                        <th rowspan="2">Trạng thái</th>
                        <th rowspan="2" width="120">Thao tác</th>
                    </tr>

                    <tr>
                        <th>Tên lớp</th>
                        <th>Concept 2</th>
                        <th>Giá concept 2</th>
                        <th>Tiền</th>
                        <th>CK</th>
                        <th>Tiền nhận</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $rental)

                        @php
                            $revenues = $rental->revenues;

                            $revenue1 = $revenues->firstWhere(
                                'concept_id',
                                $rental->concept_id
                            );

                            $revenue2 = $revenues->firstWhere(
                                'concept_id',
                                $rental->second_concept_id
                            );

                            $totalFinal = $revenues->sum('final_amount');
                        @endphp

                        <tr>
                            <td rowspan="2" class="fw-bold text-primary">
                                {{ $rental->code }}
                            </td>

                            <td rowspan="2">
                                {{ $rental->studio->name ?? '---' }}
                            </td>

                            <td>
                                {{ $rental->school_name }}
                            </td>

                            <td rowspan="2">
                                {{ $rental->student_count }}
                            </td>

                            <td>
                                {{ $rental->concept->name ?? '---' }}
                            </td>

                            <td>
                                {{ number_format($revenue1->price ?? 0) }}đ
                            </td>

                            <td>
                                {{ number_format($revenue1->total_amount ?? 0) }}đ
                            </td>

                            <td>
                                {{ $revenue1->discount_percent ?? 0 }}%
                                <br>
                                <small class="text-danger">
                                    -{{ number_format($revenue1->discount_amount ?? 0) }}đ
                                </small>
                            </td>

                            <td class="text-success fw-bold">
                                {{ number_format($revenue1->final_amount ?? 0) }}đ
                            </td>

                            <td rowspan="2" class="text-success fw-bold">
                                {{ number_format($totalFinal) }}đ
                            </td>

                            <td rowspan="2">
                                {{ $rental->shooting_date
                                    ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                                    : '---'
                                }}
                            </td>

                            <td rowspan="2">
                                @if($rental->status == 'renting')
                                    <span class="badge bg-warning text-dark">
                                        Đang thuê
                                    </span>
                                @elseif($rental->status == 'processing')
                                    <span class="badge bg-danger">
                                        Đang xử lý
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Hoàn thành
                                    </span>
                                @endif
                            </td>
                            <td rowspan="2">
                                <form
                                    action="{{ route('admin.revenues.destroy', $rental->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn doanh thu này?')"
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
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {{ $rental->class_name }}
                            </td>

                            <td>
                                {{ $rental->secondConcept->name ?? 'Không có' }}
                            </td>

                            <td>
                                {{ number_format($revenue2->price ?? 0) }}đ
                            </td>

                            <td>
                                {{ number_format($revenue2->total_amount ?? 0) }}đ
                            </td>

                            <td>
                                {{ $revenue2->discount_percent ?? 0 }}%
                                <br>
                                <small class="text-danger">
                                    -{{ number_format($revenue2->discount_amount ?? 0) }}đ
                                </small>
                            </td>

                            <td class="text-success fw-bold">
                                {{ number_format($revenue2->final_amount ?? 0) }}đ
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="13" class="text-center py-5 text-muted">
                                Chưa có dữ liệu doanh thu
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

<style>

.revenue-card{
    border-radius:16px;
}

.table th{
    white-space:nowrap;
}

.table td{
    vertical-align:middle;
}

</style>

@endsection