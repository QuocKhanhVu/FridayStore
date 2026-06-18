@extends('admin.layouts.master')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Dashboard
            </h3>

            <p class="text-muted mb-0">
                Tổng quan hệ thống quản lý kho kỷ yếu
            </p>
        </div>

    </div>

    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card card-stat border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Tổng trang phục
                        </small>

                        <h3 class="fw-bold mb-0">
                            {{ number_format($totalCostumes ?? 0) }}
                        </h3>
                    </div>

                    <i class="fa fa-shirt stat-icon text-primary"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card card-stat border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Đang cho thuê
                        </small>

                        <h3 class="fw-bold mb-0 text-success">
                            {{ number_format($totalRenting ?? 0) }}
                        </h3>
                    </div>

                    <i class="fa fa-truck stat-icon text-success"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card card-stat border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Đơn cần xử lý
                        </small>

                        <h3 class="fw-bold mb-0 text-warning">
                            {{ number_format($processingOrders ?? 0) }}
                        </h3>
                    </div>

                    <i class="fa fa-file-lines stat-icon text-warning"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card card-stat border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Doanh thu tháng trước
                        </small>

                        <h3 class="fw-bold mb-0 text-danger">
                            {{ number_format($monthlyRevenue ?? 0) }}đ
                        </h3>
                    </div>

                    <i class="fa fa-money-bill-wave stat-icon text-danger"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLES --}}
    <div class="row g-4">

        <div class="col-lg-8">

            <div class="table-card card border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Đơn cần xử lý
                    </h5>

                    <a
                        href="{{ route('admin.rentals.create') }}"
                        class="btn btn-primary"
                    >
                        + Tạo đơn thuê
                    </a>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Lớp</th>
                                <th>Studio</th>
                                <th>Ngày chụp</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pendingRentals as $rental)

                                <tr>
                                    <td class="fw-bold text-primary">
                                        {{ $rental->code }}
                                    </td>

                                    <td>
                                        <div class="fw-bold">
                                            {{ $rental->class_name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $rental->school_name }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $rental->studio->name ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $rental->shooting_date
                                            ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                                            : '---'
                                        }}
                                    </td>

                                    <td>
                                        @if($rental->status == 'draft')
                                            <span class="badge bg-warning text-dark">
                                                Chờ chia size
                                            </span>
                                        @elseif($rental->status == 'processing')
                                            <span class="badge bg-danger">
                                                Đang xử lý
                                            </span>
                                        @elseif($rental->status == 'renting')
                                            <span class="badge bg-info text-dark">
                                                Đang thuê
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                Hoàn thành
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Không có đơn cần xử lý
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="table-card card border-0 shadow-sm p-3 h-100">

                <h5 class="fw-bold mb-3">
                    Cảnh báo tồn kho
                </h5>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Trang phục</th>
                                <th>Size</th>
                                <th>Còn</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($lowStocks as $item)

                                @php
                                    if ($quantityAvailableColumn) {
                                        $available = $item->{$quantityAvailableColumn};
                                    } else {
                                        $available = ($item->{$quantityTotalColumn} ?? 0)
                                            - ($item->{$quantityRentedColumn} ?? 0);
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        {{ $item->costume->name ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $item->size->size_name ?? '---' }}
                                    </td>

                                    <td>
                                        @if($available <= 0)
                                            <span class="badge bg-dark">
                                                Hết
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
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Tồn kho ổn định
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART --}}
    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="table-card card border-0 shadow-sm p-3">

                <h5 class="fw-bold mb-3">
                    Doanh thu 6 tháng gần nhất
                </h5>

                <canvas id="revenueChart" height="120"></canvas>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="table-card card border-0 shadow-sm p-3 h-100">

                <h5 class="fw-bold mb-3">
                    Ghi chú
                </h5>

                <div class="text-muted">
                    <p class="mb-2">
                        <span class="badge bg-warning text-dark">Chờ chia size</span>
                        là đơn mới tạo, chưa xử lý size.
                    </p>

                    <p class="mb-2">
                        <span class="badge bg-danger">Đang xử lý</span>
                        là đơn có vấn đề cần xử lý.
                    </p>

                    <p class="mb-0">
                        Cảnh báo tồn kho hiển thị các trang phục còn từ 5 sản phẩm trở xuống.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

<style>

.card-stat {
    border-radius: 16px;
}

.stat-icon {
    font-size: 34px;
    opacity: .85;
}

.table-card {
    border-radius: 16px;
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
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;

                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(value) + 'đ';
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