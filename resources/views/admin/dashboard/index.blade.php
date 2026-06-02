@extends('admin.layouts.master')

@section('title','Dashboard')

@section('content')

<h3 class="fw-bold mb-4">
    Dashboard
</h3>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between">

                <div>
                    <small>Tổng trang phục</small>
                    <h3>12,450</h3>
                </div>

                <i class="fa fa-shirt stat-icon text-primary"></i>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between">

                <div>
                    <small>Đang cho thuê</small>
                    <h3>4,230</h3>
                </div>

                <i class="fa fa-truck stat-icon text-success"></i>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between">

                <div>
                    <small>Đơn xử lý</small>
                    <h3>18</h3>
                </div>

                <i class="fa fa-file-lines stat-icon text-warning"></i>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between">

                <div>
                    <small>Doanh thu tháng</small>
                    <h3>125M</h3>
                </div>

                <i class="fa fa-money-bill-wave stat-icon text-danger"></i>

            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-lg-8">

        <div class="table-card">

            <div class="d-flex justify-content-between mb-3">

                <h5>Đơn cần xử lý</h5>

                <a href="#" class="btn btn-primary">
                    + Tạo đơn thuê
                </a>

            </div>

            <table class="table">

                <thead>
                    <tr>
                        <th>Lớp</th>
                        <th>Studio</th>
                        <th>Ngày chụp</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>12A1</td>
                        <td>Kho Mơ Studio</td>
                        <td>05/06/2026</td>
                        <td>
                            <span class="badge bg-warning">
                                Chờ chia size
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="table-card">

            <h5 class="mb-3">
                Cảnh báo tồn kho
            </h5>

            <table class="table">

                <tr>
                    <td>Vest Size 5</td>
                    <td>
                        <span class="badge bg-danger">
                            1
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Quần Be Size 4</td>
                    <td>
                        <span class="badge bg-danger">
                            2
                        </span>
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-8">

        <div class="table-card">

            <h5>Doanh thu 6 tháng gần nhất</h5>

            <canvas id="revenueChart"></canvas>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

new Chart(
    document.getElementById('revenueChart'),
    {
        type:'bar',
        data:{
            labels:['T1','T2','T3','T4','T5','T6'],
            datasets:[{
                label:'Doanh thu',
                data:[30,45,50,70,90,125]
            }]
        }
    }
);

</script>

@endpush