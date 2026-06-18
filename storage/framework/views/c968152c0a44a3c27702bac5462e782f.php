

<?php $__env->startSection('title','Chi tiết đơn thuê'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Chi tiết đơn thuê
            </h2>

            <p class="text-muted mb-0">
                <?php echo e($rental->code); ?>

            </p>

        </div>

        <div>

            <a
                href="<?php echo e(route('admin.rentals.students.export', $rental)); ?>"
                class="btn btn-success"
            >
                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel
            </a>

            <a
                href="<?php echo e(route('admin.rental-history.history')); ?>"
                class="btn btn-secondary"
            >
                <i class="fa fa-arrow-left me-2"></i>
                Quay lại
            </a>

        </div>

    </div>

    
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Thông tin đơn thuê
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Mã đơn
                    </label>

                    <div>
                        <?php echo e($rental->code); ?>

                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Studio
                    </label>

                    <div>
                        <?php echo e($rental->studio->name ?? '---'); ?>

                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Concept
                    </label>

                    <div>
                        <?php echo e($rental->concept->name ?? '---'); ?>

                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Trạng thái
                    </label>

                    <div>

                        <span
                            class="
                                badge
                                bg-success
                                px-3
                                py-2
                            "
                        >
                            Hoàn thành
                        </span>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Trường
                    </label>

                    <div>
                        <?php echo e($rental->school_name); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Lớp
                    </label>

                    <div>
                        <?php echo e($rental->class_name); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Sĩ số
                    </label>

                    <div>
                        <?php echo e($rental->students->count()); ?> học sinh
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày chụp
                    </label>

                    <div>

                        <?php echo e($rental->shooting_date
                            ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                            : '---'); ?>


                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày thuê
                    </label>

                    <div>

                        <?php echo e($rental->rental_date
                            ? \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y')
                            : '---'); ?>


                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày trả
                    </label>

                    <div>

                        <?php echo e($rental->return_date
                            ? \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y')
                            : '---'); ?>


                    </div>

                </div>

                <?php if($rental->note): ?>

                    <div class="col-12">

                        <label class="fw-bold">
                            Ghi chú
                        </label>

                        <div>

                            <?php echo e($rental->note); ?>


                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">
                Danh sách học sinh
            </h5>

        </div>

        <div class="table-responsive">

            <table
                class="
                    table
                    table-bordered
                    table-hover
                    mb-0
                "
            >

                <thead>

                    <tr>

                        <th width="60">
                            STT
                        </th>

                        <th>
                            Họ tên
                        </th>

                        <th>
                            Giới tính
                        </th>

                        <th>
                            Chiều cao
                        </th>

                        <th>
                            Cân nặng
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $rental->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            <td>

                                <?php echo e($key + 1); ?>


                            </td>

                            <td>

                                <?php echo e($student->full_name); ?>


                            </td>

                            <td>

                                <?php echo e($student->gender); ?>


                            </td>

                            <td>

                                <?php echo e($student->height); ?>


                            </td>

                            <td>

                                <?php echo e($student->weight); ?>


                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="5"
                                class="text-center"
                            >

                                Không có dữ liệu

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rental-history/show.blade.php ENDPATH**/ ?>