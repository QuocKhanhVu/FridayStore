

<?php $__env->startSection('title', 'Báo cáo'); ?>

<?php $__env->startSection('content'); ?>

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
                            value="<?php echo e(request('from')); ?>"
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
                            value="<?php echo e(request('to')); ?>"
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
                            href="<?php echo e(route('admin.reports.index')); ?>"
                            class="btn btn-light border w-100"
                        >
                            Xóa lọc
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    
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
                                <?php echo e(number_format($totalRentals ?? 0)); ?>

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
                                <?php echo e(number_format($rentingRentals ?? 0)); ?>

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
                                <?php echo e(number_format($processingRentals ?? 0)); ?>

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
                                <?php echo e(number_format($completedRentals ?? 0)); ?>

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
                        <?php echo e(number_format($totalStudents ?? 0)); ?>

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
                        <?php echo e(number_format($totalRevenue ?? 0)); ?>đ
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
                        <?php echo e(number_format($totalInventory ?? 0)); ?>

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
                        <?php echo e(number_format($totalBroken ?? 0)); ?>

                        /
                        <?php echo e(number_format($totalLost ?? 0)); ?>

                    </h3>

                </div>

            </div>

        </div>

    </div>

    
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
                            <?php echo e(number_format($totalInventory ?? 0)); ?>

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Đang cho thuê
                        </span>

                        <strong class="text-success">
                            <?php echo e(number_format($totalRentedInventory ?? 0)); ?>

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Bị hỏng
                        </span>

                        <strong class="text-warning">
                            <?php echo e(number_format($totalBroken ?? 0)); ?>

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Bị mất
                        </span>

                        <strong class="text-danger">
                            <?php echo e(number_format($totalLost ?? 0)); ?>

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

    
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

                            <?php $__currentLoopData = $statusReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td class="text-start fw-bold">
                                        <?php echo e($item['label']); ?>

                                    </td>

                                    <td>
                                        <?php echo e(number_format($item['count'])); ?>

                                    </td>

                                    <td class="fw-bold text-success">
                                        <?php echo e(number_format($item['amount'])); ?>đ
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

                            <?php $__empty_1 = true; $__currentLoopData = $studioReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <tr>
                                    <td class="text-start fw-bold">
                                        <?php echo e($item->studio->name ?? '---'); ?>

                                    </td>

                                    <td>
                                        <?php echo e(number_format($item->total_orders ?? 0)); ?>

                                    </td>

                                    <td>
                                        <?php echo e(number_format($item->total_students ?? 0)); ?>

                                    </td>

                                    <td class="fw-bold text-success">
                                        <?php echo e(number_format($item->total_amount ?? 0)); ?>đ
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>
                                    <td colspan="4" class="text-muted py-4">
                                        Chưa có dữ liệu
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    
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

                            <?php $__empty_1 = true; $__currentLoopData = $lowStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <?php
                                    $total = $item->{$quantityTotalColumn} ?? 0;
                                    $rented = $item->{$quantityRentedColumn} ?? 0;

                                    if ($quantityAvailableColumn) {
                                        $available = $item->{$quantityAvailableColumn} ?? 0;
                                    } else {
                                        $available = $total - $rented;
                                    }
                                ?>

                                <tr>
                                    <td class="fw-bold text-primary">
                                        <?php echo e($item->costume->code ?? '---'); ?>

                                    </td>

                                    <td class="text-start">
                                        <?php echo e($item->costume->name ?? '---'); ?>

                                    </td>

                                    <td>
                                        <?php echo e($item->size->size_name ?? 'Không size'); ?>

                                    </td>

                                    <td>
                                        <?php echo e(number_format($total)); ?>

                                    </td>

                                    <td>
                                        <?php echo e(number_format($rented)); ?>

                                    </td>

                                    <td>
                                        <?php if($available <= 0): ?>

                                            <span class="badge bg-dark">
                                                Hết hàng
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
                                    <td colspan="6" class="text-muted py-4">
                                        Không có trang phục tồn kho thấp
                                    </td>
                                </tr>

                            <?php endif; ?>

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

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>