<?php $__env->startSection('title', 'Kết quả chia size'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <?php
        $costumes = collect();

        if ($rental->concept) {
            $costumes = $costumes->merge(
                $rental->concept->costumes
            );
        }

        if ($rental->secondConcept) {
            $costumes = $costumes->merge(
                $rental->secondConcept->costumes
            );
        }

        if ($rental->extraCostumes && $rental->extraCostumes->count()) {
            $costumes = $costumes->merge(
                $rental->extraCostumes
            );
        }

        $costumes = $costumes
            ->unique('id')
            ->filter(function ($costume) {
                return (int) $costume->has_size === 1;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Chia bảng hiển thị
        |--------------------------------------------------------------------------
        | Mỗi bảng chỉ hiển thị tối đa 2 cột trang phục.
        */
        $costumePages = $costumes->chunk(2);
    ?>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Kết quả chia size tự động
            </h3>

            <p class="text-muted mb-0">
                <?php echo e($rental->school_name); ?>

                -
                <?php echo e($rental->class_name); ?>

            </p>

        </div>

        <div>

            <a
                href="<?php echo e(route('admin.rentals.index')); ?>"
                class="btn btn-secondary"
            >
                <i class="fa fa-arrow-left"></i>
                Quay lại
            </a>

            <a
                href="<?php echo e(route('admin.rentals.students.export', $rental)); ?>"
                class="btn btn-success"
            >
                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel
            </a>

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

    
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">
                Thông tin trang phục chia size
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Concept 1:</strong>

                    <div>
                        <?php echo e($rental->concept->name ?? 'Không có'); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Concept 2:</strong>

                    <div>
                        <?php echo e($rental->secondConcept->name ?? 'Không sử dụng'); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Trang phục thêm:</strong>

                    <div>
                       <?php if($rental->extraCostumes && $rental->extraCostumes->count()): ?>
                            <?php echo e($rental->extraCostumes->pluck('name')->join(', ')); ?>

                        <?php else: ?>
                            Không sử dụng
                        <?php endif; ?>
                    </div>

                </div>

            </div>

            <div class="mt-2">

                <strong>Các cột size đang hiển thị:</strong>

                <?php $__empty_1 = true; $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <span class="badge bg-primary me-1 mb-1">
                        <?php echo e($costume->name); ?>

                    </span>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <span class="text-danger">
                        Không có trang phục nào cần chia size
                    </span>

                <?php endif; ?>

            </div>

            <?php if($costumePages->count() > 1): ?>

                <div class="mt-3 alert alert-info mb-0">

                    Có tổng cộng
                    <strong><?php echo e($costumes->count()); ?></strong>
                    trang phục cần chia size.
                    Hệ thống đang chia thành
                    <strong><?php echo e($costumePages->count()); ?></strong>
                    bảng, mỗi bảng tối đa 2 trang phục.

                </div>

            <?php endif; ?>

        </div>

    </div>

    
<?php if($costumePages->count() > 0): ?>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-0 fw-bold">
                    Danh sách size đã chia
                </h5>

                <small class="text-muted">
                    Bấm số trang để xem từng nhóm trang phục
                </small>

            </div>

            <span class="badge bg-primary">
                <?php echo e($costumePages->count()); ?> trang
            </span>

        </div>

        <div class="card-body">

            
            <ul class="nav nav-pills mb-4" id="sizePageTab" role="tablist">

                <?php $__currentLoopData = $costumePages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageIndex => $costumeGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li class="nav-item me-2 mb-2" role="presentation">

                        <button
                            class="nav-link <?php if($pageIndex == 0): ?> active <?php endif; ?>"
                            id="size-page-<?php echo e($pageIndex); ?>-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#size-page-<?php echo e($pageIndex); ?>"
                            type="button"
                            role="tab"
                        >
                            <?php echo e($pageIndex + 1); ?>

                        </button>

                    </li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

            
            <div class="tab-content" id="sizePageTabContent">

                <?php $__currentLoopData = $costumePages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageIndex => $costumeGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div
                        class="tab-pane fade <?php if($pageIndex == 0): ?> show active <?php endif; ?>"
                        id="size-page-<?php echo e($pageIndex); ?>"
                        role="tabpanel"
                    >

                        <div class="mb-3 d-flex justify-content-between align-items-center">

                            <div>

                                <strong>
                                    Trang <?php echo e($pageIndex + 1); ?>

                                </strong>

                                <span class="text-muted">
                                    /
                                    <?php echo e($costumePages->count()); ?>

                                </span>

                            </div>

                            <div>

                                <?php $__currentLoopData = $costumeGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <span class="badge bg-primary me-1">
                                        <?php echo e($costume->name); ?>

                                    </span>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle mb-0 text-center">

                                <thead class="table-light">

                                    <tr>

                                        <th width="60">
                                            STT
                                        </th>

                                        <th class="text-start">
                                            Họ tên
                                        </th>

                                        <th width="100">
                                            Giới tính
                                        </th>

                                        <th width="100">
                                            Cao
                                        </th>

                                        <th width="100">
                                            Nặng
                                        </th>

                                        <?php $__currentLoopData = $costumeGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <th>
                                                <?php echo e($costume->name); ?>

                                            </th>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                        <tr>

                                            <td>
                                                <?php echo e($loop->iteration); ?>

                                            </td>

                                            <td class="text-start fw-semibold">
                                                <?php echo e($student->full_name); ?>

                                            </td>

                                            <td>
                                                <?php if($student->gender == 'female'): ?>
                                                    <span class="badge bg-danger">
                                                        Nữ
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary">
                                                        Nam
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php echo e($student->height); ?>

                                            </td>

                                            <td>
                                                <?php echo e($student->weight); ?>

                                            </td>

                                            <?php $__currentLoopData = $costumeGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php
                                                    $studentSize = $student
                                                        ->sizes
                                                        ->where('costume_id', $costume->id)
                                                        ->first();
                                                ?>

                                                <td>

                                                    <?php if($studentSize): ?>

                                                        <select
                                                            class="form-select form-select-sm size-select"
                                                            data-id="<?php echo e($studentSize->id); ?>"
                                                        >

                                                            <option
                                                                value="0"
                                                                <?php if(empty($studentSize->costume_size_id)): echo 'selected'; endif; ?>
                                                            >
                                                                0 - Không thuê
                                                            </option>

                                                            <?php $__currentLoopData = $costume->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <option
                                                                    value="<?php echo e($size->id); ?>"
                                                                    <?php if($studentSize->costume_size_id == $size->id): echo 'selected'; endif; ?>
                                                                >
                                                                    <?php echo e($size->size_name); ?>

                                                                </option>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </select>

                                                    <?php else: ?>

                                                        <?php if($costume->gender !== 'unisex' && $costume->gender !== $student->gender): ?>

                                                            <span class="badge bg-secondary">
                                                                Không thuê
                                                            </span>

                                                        <?php else: ?>

                                                            <span class="badge bg-danger">
                                                                Chưa chia
                                                            </span>

                                                        <?php endif; ?>

                                                    <?php endif; ?>

                                                </td>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <tr>

                                            <td
                                                colspan="<?php echo e(5 + $costumeGroup->count()); ?>"
                                                class="text-center text-muted py-4"
                                            >
                                                Chưa có dữ liệu học sinh
                                            </td>

                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

    </div>

<?php else: ?>

    <div class="card border-0 shadow-sm">

        <div class="card-body text-center text-muted py-5">
            Không có trang phục nào cần chia size
        </div>

    </div>

<?php endif; ?>

</div>


<div class="toast-container position-fixed bottom-0 end-0 p-3">

    <div id="successToast" class="toast">

        <div class="toast-header">

            <strong class="me-auto">
                Thông báo
            </strong>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
            ></button>

        </div>

        <div class="toast-body">
            Cập nhật size thành công
        </div>

    </div>

</div>

<style>

.table th {
    white-space: nowrap;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.card {
    border-radius: 16px;
}

.size-select {
    min-width: 120px;
}
#sizePageTab .nav-link {
    min-width: 44px;
    font-weight: 600;
    border-radius: 10px;
}

#sizePageTab .nav-link.active {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.size-select').forEach(function (select) {

        select.addEventListener('change', function () {

            let id = this.dataset.id;
            let sizeId = this.value;

            fetch(`/admin/rental-student-sizes/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    costume_size_id: sizeId
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {

                    new bootstrap.Toast(
                        document.getElementById('successToast')
                    ).show();

                }

            });

        });

    });

});
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rentals/students/size_result.blade.php ENDPATH**/ ?>