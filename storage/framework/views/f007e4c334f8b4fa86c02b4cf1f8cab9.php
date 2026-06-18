<?php $__env->startSection('title','Doanh thu'); ?>

<?php $__env->startSection('content'); ?>

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

                            <?php $__currentLoopData = $studios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($studio->id); ?>"
                                    <?php echo e(request('studio_id') == $studio->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($studio->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                            href="<?php echo e(route('admin.revenues.index')); ?>"
                            class="btn btn-light border"
                        >
                            Xóa
                        </a>

                    </div>

                    <div class="col-md-3 d-flex align-items-end">

                        <a
                            href="<?php echo e(route(
                                'admin.revenues.export',
                                request()->query()
                            )); ?>"
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

    
    <div class="row mb-4">

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm h-100 revenue-card">

                <div class="card-body">

                    <div class="text-muted">
                        Tổng gốc
                    </div>

                    <h4 class="fw-bold mb-0">
                        <?php echo e(number_format($totalAmount ?? 0)); ?>đ
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
                        <?php echo e(number_format($totalDiscount ?? 0)); ?>đ
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
                        <?php echo e(number_format($finalRevenue ?? 0)); ?>đ
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
                        <?php echo e($totalOrders ?? 0); ?>

                        /
                        <?php echo e($totalStudents ?? 0); ?>

                    </h4>

                </div>

            </div>

        </div>

    </div>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo e(session('error')); ?>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>
    
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

                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php
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
                        ?>

                        <tr>
                            <td rowspan="2" class="fw-bold text-primary">
                                <?php echo e($rental->code); ?>

                            </td>

                            <td rowspan="2">
                                <?php echo e($rental->studio->name ?? '---'); ?>

                            </td>

                            <td>
                                <?php echo e($rental->school_name); ?>

                            </td>

                            <td rowspan="2">
                                <?php echo e($rental->student_count); ?>

                            </td>

                            <td>
                                <?php echo e($rental->concept->name ?? '---'); ?>

                            </td>

                            <td>
                                <?php echo e(number_format($revenue1->price ?? 0)); ?>đ
                            </td>

                            <td>
                                <?php echo e(number_format($revenue1->total_amount ?? 0)); ?>đ
                            </td>

                            <td>
                                <?php echo e($revenue1->discount_percent ?? 0); ?>%
                                <br>
                                <small class="text-danger">
                                    -<?php echo e(number_format($revenue1->discount_amount ?? 0)); ?>đ
                                </small>
                            </td>

                            <td class="text-success fw-bold">
                                <?php echo e(number_format($revenue1->final_amount ?? 0)); ?>đ
                            </td>

                            <td rowspan="2" class="text-success fw-bold">
                                <?php echo e(number_format($totalFinal)); ?>đ
                            </td>

                            <td rowspan="2">
                                <?php echo e($rental->shooting_date
                                    ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                                    : '---'); ?>

                            </td>

                            <td rowspan="2">
                                <?php if($rental->status == 'renting'): ?>
                                    <span class="badge bg-warning text-dark">
                                        Đang thuê
                                    </span>
                                <?php elseif($rental->status == 'processing'): ?>
                                    <span class="badge bg-danger">
                                        Đang xử lý
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success">
                                        Hoàn thành
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td rowspan="2">
                                <form
                                    action="<?php echo e(route('admin.revenues.destroy', $rental->id)); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn doanh thu này?')"
                                >
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

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
                                <?php echo e($rental->class_name); ?>

                            </td>

                            <td>
                                <?php echo e($rental->secondConcept->name ?? 'Không có'); ?>

                            </td>

                            <td>
                                <?php echo e(number_format($revenue2->price ?? 0)); ?>đ
                            </td>

                            <td>
                                <?php echo e(number_format($revenue2->total_amount ?? 0)); ?>đ
                            </td>

                            <td>
                                <?php echo e($revenue2->discount_percent ?? 0); ?>%
                                <br>
                                <small class="text-danger">
                                    -<?php echo e(number_format($revenue2->discount_amount ?? 0)); ?>đ
                                </small>
                            </td>

                            <td class="text-success fw-bold">
                                <?php echo e(number_format($revenue2->final_amount ?? 0)); ?>đ
                            </td>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="13" class="text-center py-5 text-muted">
                                Chưa có dữ liệu doanh thu
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        <?php echo e($data->links()); ?>


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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/revenues/index.blade.php ENDPATH**/ ?>