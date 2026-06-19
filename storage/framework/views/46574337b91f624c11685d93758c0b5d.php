<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>

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

    
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card card-stat border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Tổng trang phục
                        </small>

                        <h3 class="fw-bold mb-0">
                            <?php echo e(number_format($totalCostumes ?? 0)); ?>

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
                            <?php echo e(number_format($totalRenting ?? 0)); ?>

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
                            <?php echo e(number_format($processingOrders ?? 0)); ?>

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
                            <?php echo e(number_format($monthlyRevenue ?? 0)); ?>đ
                        </h3>
                    </div>

                    <i class="fa fa-money-bill-wave stat-icon text-danger"></i>

                </div>

            </div>

        </div>

    </div>

    
    <div class="row g-4">

        <div class="col-lg-8">

            <div class="table-card card border-0 shadow-sm p-3 h-100">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Đơn cần xử lý
                    </h5>

                    <a
                        href="<?php echo e(route('admin.rentals.create')); ?>"
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

                            <?php $__empty_1 = true; $__currentLoopData = $pendingRentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <tr>
                                    <td class="fw-bold text-primary">
                                        <?php echo e($rental->code); ?>

                                    </td>

                                    <td>
                                        <div class="fw-bold">
                                            <?php echo e($rental->class_name); ?>

                                        </div>

                                        <small class="text-muted">
                                            <?php echo e($rental->school_name); ?>

                                        </small>
                                    </td>

                                    <td>
                                        <?php echo e($rental->studio->name ?? '---'); ?>

                                    </td>

                                    <td>
                                        <?php echo e($rental->shooting_date
                                            ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                                            : '---'); ?>

                                    </td>

                                    <td>
                                        <?php if($rental->status == 'draft'): ?>
                                            <span class="badge bg-warning text-dark">
                                                Chờ chia size
                                            </span>
                                        <?php elseif($rental->status == 'processing'): ?>
                                            <span class="badge bg-danger">
                                                Đang xử lý
                                            </span>
                                        <?php elseif($rental->status == 'renting'): ?>
                                            <span class="badge bg-info text-dark">
                                                Đang thuê
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                Hoàn thành
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Không có đơn cần xử lý
                                    </td>
                                </tr>

                            <?php endif; ?>

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

                            <?php $__empty_1 = true; $__currentLoopData = $lowStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <?php
                                    if ($quantityAvailableColumn) {
                                        $available = $item->{$quantityAvailableColumn};
                                    } else {
                                        $available = ($item->{$quantityTotalColumn} ?? 0)
                                            - ($item->{$quantityRentedColumn} ?? 0);
                                    }
                                ?>

                                <tr>
                                    <td>
                                        <?php echo e($item->costume->name ?? '---'); ?>

                                    </td>

                                    <td>
                                        <?php echo e($item->size->size_name ?? '---'); ?>

                                    </td>

                                    <td>
                                        <?php if($available <= 0): ?>
                                            <span class="badge bg-dark">
                                                Hết
                                            </span>
                                        <?php elseif($available <= 2): ?>
                                            <span class="badge bg-danger">
                                                <?php echo e($available); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <?php echo e($available); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Tồn kho ổn định
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueLabels = <?php echo json_encode($chartLabels, 15, 512) ?>;
    const revenueData = <?php echo json_encode($chartData, 15, 512) ?>;

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

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>