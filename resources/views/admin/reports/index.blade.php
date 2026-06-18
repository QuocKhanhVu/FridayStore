@extends('admin.layouts.master')

@section('title', 'Báo cáo')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Báo cáo tổng hợp
            </h3>

            <p class="text-muted mb-0">
                Thống kê đơn thuê, doanh thu, tồn kho và cảnh báo hàng hóa
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3 align-items-end">

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

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="fa fa-filter me-1"></i>
                            Lọc báo cáo
                        </button>

                    </div>

                    <div class="col-md-3">

                        <a
                            href="{{ route('admin.reports.index') }}"
                            class="btn btn-light border w-100"
                        >
                            Xóa lọc
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Tổng đơn thuê
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalRentals ?? 0) }}
                            </h3>
                        </div>

                        <i class="fa fa-file-lines report-icon text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Đang thuê
                            </small>

                            <h3 class="fw-bold text-success mb-0">
                                {{ number_format($rentingRentals ?? 0) }}
                            </h3>
                        </div>

                        <i class="fa fa-truck report-icon text-success"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Đang xử lý
                            </small>

                            <h3 class="fw-bold text-warning mb-0">
                                {{ number_format($processingRentals ?? 0) }}
                            </h3>
                        </div>

                        <i class="fa fa-triangle-exclamation report-icon text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Hoàn thành
                            </small>

                            <h3 class="fw-bold text-info mb-0">
                                {{ number_format($completedRentals ?? 0) }}
                            </h3>
                        </div>

                        <i class="fa fa-circle-check report-icon text-info"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Tổng học sinh
                    </small>

                    <h3 class="fw-bold mb-0">
                        {{ number_format($totalStudents ?? 0) }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Doanh thu
                    </small>

                    <h3 class="fw-bold text-danger mb-0">
                        {{ number_format($totalRevenue ?? 0) }}đ
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Tổng hàng trong kho
                    </small>

                    <h3 class="fw-bold text-primary mb-0">
                        {{ number_format($totalInventory ?? 0) }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card report-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Hỏng / Mất
                    </small>

                    <h3 class="fw-bold text-dark mb-0">
                        {{ number_format($totalBroken ?? 0) }}
                        /
                        {{ number_format($totalLost ?? 0) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm report-card h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Doanh thu 6 tháng gần nhất
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="revenueChart" height="120"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm report-card h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Tóm tắt tồn kho
                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Tổng hàng
                        </span>

                        <strong>
                            {{ number_format($totalInventory ?? 0) }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Đang cho thuê
                        </span>

                        <strong class="text-success">
                            {{ number_format($totalRentedInventory ?? 0) }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Bị hỏng
                        </span>

                        <strong class="text-warning">
                            {{ number_format($totalBroken ?? 0) }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Bị mất
                        </span>

                        <strong class="text-danger">
                            {{ number_format($totalLost ?? 0) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLES --}}
    <div class="row g-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm report-card h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Báo cáo theo trạng thái đơn
                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle text-center mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Trạng thái</th>
                                <th>Số đơn</th>
                                <th>Tổng tiền</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($statusReports as $item)

                                <tr>
                                    <td class="text-start fw-bold">
                                        {{ $item['label'] }}
                                    </td>

                                    <td>
                                        {{ number_format($item['count']) }}
                                    </td>

                                    <td class="fw-bold text-success">
                                        {{ number_format($item['amount']) }}đ
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm report-card h-100">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Top studio theo doanh thu
                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle text-center mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Studio</th>
                                <th>Số đơn</th>
                                <th>Học sinh</th>
                                <th>Doanh thu</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($studioReports as $item)

                                <tr>
                                    <td class="text-start fw-bold">
                                        {{ $item->studio->name ?? '---' }}
                                    </td>

                                    <td>
                                        {{ number_format($item->total_orders ?? 0) }}
                                    </td>

                                    <td>
                                        {{ number_format($item->total_students ?? 0) }}
                                    </td>

                                    <td class="fw-bold text-success">
                                        {{ number_format($item->total_amount ?? 0) }}đ
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-muted py-4">
                                        Chưa có dữ liệu
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- LOW STOCK --}}
    <div class="row g-4 mt-1">

        <div class="col-lg-12">

            <div class="card border-0 shadow-sm report-card">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Cảnh báo tồn kho thấp
                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle text-center mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Mã</th>
                                <th>Trang phục</th>
                                <th>Size</th>
                                <th>Tổng</th>
                                <th>Đang thuê</th>
                                <th>Còn lại</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($lowStocks as $item)

                                @php
                                    $total = $item->{$quantityTotalColumn} ?? 0;
                                    $rented = $item->{$quantityRentedColumn} ?? 0;

                                    if ($quantityAvailableColumn) {
                                        $available = $item->{$quantityAvailableColumn} ?? 0;
                                    } else {
                                        $available = $total - $rented;
                                    }
                                @endphp

                                <tr>
                                    <td class="fw-bold text-primary">
                                        {{ $item->costume->code ?? '---' }}
                                    </td>

                                    <td class="text-start">
                                        {{ $item->costume->name ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $item->size->size_name ?? 'Không size' }}
                                    </td>

                                    <td>
                                        {{ number_format($total) }}
                                    </td>

                                    <td>
                                        {{ number_format($rented) }}
                                    </td>

                                    <td>
                                        @if($available <= 0)

                                            <span class="badge bg-dark">
                                                Hết hàng
                                            </span>

                                        @elseif($available <= 2)

                                            <span class="badge bg-danger">
                                                {{ $available }}
                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">
                                                {{ $available }}
                                            </span>

                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-muted py-4">
                                        Không có trang phục tồn kho thấp
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.report-card {
    border-radius: 16px;
}

.report-icon {
    font-size: 34px;
    opacity: .85;
}

.table th {
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
}
</style>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueLabels = @json($chartLabels);
    const revenueData = @json($chartData);

    new Chart(
        document.getElementById('revenueChart'),
        {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [
                    {
                        label: 'Doanh thu',
                        data: revenueData
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;

                                return 'Doanh thu: '
                                    + new Intl.NumberFormat('vi-VN').format(value)
                                    + 'đ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                            }
                        }
                    }
                }
            }
        }
    );
</script>

@endpush