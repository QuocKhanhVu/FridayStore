

<?php $__env->startSection('title', 'Quản lý đơn thuê'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">


<div class="row mb-4 align-items-center">

    <div class="col-md-6">

        <h2 class="fw-bold mb-1 text-dark">
            Đơn cần xử lý
        </h2>

        <p class="text-muted mb-0">
            Theo dõi và quản lý các đơn thuê trang phục
        </p>

    </div>

    <div class="col-md-6 text-md-end mt-3 mt-md-0">

        <a
            href="<?php echo e(route('admin.rentals.create')); ?>"
            class="btn text-white shadow-sm"
            style="
                background:#4F46E5;
                border:none;
                border-radius:12px;
            "
        >
            <i class="fa fa-plus-circle me-1"></i>
            Tạo đơn thuê
        </a>

    </div>

</div>

<div
    class="card border-0 shadow-sm"
    style="
        border-radius:18px;
    "
>

    <div
        class="card-header bg-white border-0"
    >

        <div class="row align-items-center">

            <div class="col-md-4">

                <h5 class="mb-0 fw-bold">
                    Danh sách đơn thuê
                </h5>

            </div>

            <div class="col-md-8">

                <form method="GET">

                    <div class="row g-2">

                        <div class="col-md-5">

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Tìm trường hoặc lớp..."
                                value="<?php echo e(request('keyword')); ?>"
                            >

                        </div>

                        <div class="col-md-4">

                            <select
                                name="status"
                                class="form-select"
                            >

                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="draft">
                                    Nháp
                                </option>

                                <option value="sized">
                                    Đã chia size
                                </option>

                                <option value="approved">
                                    Đã duyệt
                                </option>

                                <option value="renting">
                                    Đang thuê
                                </option>

                                <option value="returned">
                                    Đã trả
                                </option>

                            </select>

                        </div>

                        <div class="col-md-3">

                            <button
                                class="btn w-100 text-white"
                                style="
                                    background:#4F46E5;
                                    border:none;
                                "
                            >
                                Lọc dữ liệu
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="
                    table
                    align-middle
                    table-hover
                "
            >

                <thead>

                    <tr
                        style="
                            background:#4F46E5;
                            color:white;
                        "
                    >

                        <th width="60">
                            STT
                        </th>

                        <th>
                            Mã đơn
                        </th>

                        <th>
                            Studio
                        </th>

                        <th>
                            Trường
                        </th>

                        <th>
                            Lớp
                        </th>

                        <th>
                            Concept
                        </th>

                        <th width="130">
                            Học sinh
                        </th>

                        <th>
                            Ngày chụp
                        </th>

                        <th>
                            Trạng thái
                        </th>

                        <th width="260">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td class="text-center">

                            <?php echo e($loop->iteration); ?>


                        </td>

                        <td>

                            <span
                                class="
                                    fw-bold
                                "
                                style="
                                    color:#4F46E5;
                                "
                            >
                                <?php echo e($item->code); ?>

                            </span>

                        </td>

                        <td>

                            <?php echo e($item->studio->name); ?>


                        </td>

                        <td>

                            <?php echo e($item->school_name); ?>


                        </td>

                        <td>

                            <span
                                class="badge"
                                style="
                                    background:#EEF2FF;
                                    color:#4F46E5;
                                "
                            >
                                <?php echo e($item->class_name); ?>

                            </span>

                        </td>

                        <td>

                            <?php echo e($item->concept->name); ?>


                        </td>

                        <td>

                            <?php if(
                                $item->students_count > 0
                            ): ?>

                                <span
                                    class="badge"
                                    style="
                                        background:#D1FAE5;
                                        color:#065F46;
                                        padding:8px 12px;
                                    "
                                >
                                    <?php echo e($item->students_count); ?>

                                    HS
                                </span>

                            <?php else: ?>

                                <span
                                    class="badge"
                                    style="
                                        background:#F3F4F6;
                                        color:#6B7280;
                                        padding:8px 12px;
                                    "
                                >
                                    Chưa import
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php echo e(\Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y')); ?>


                        </td>

                        <td>

                            <?php switch($item->status):

                                case ('draft'): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#E5E7EB;
                                            color:#374151;
                                        "
                                    >
                                        Nháp
                                    </span>

                                <?php break; ?>

                                <?php case ('sized'): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#CFFAFE;
                                            color:#155E75;
                                        "
                                    >
                                        Đã chia size
                                    </span>

                                <?php break; ?>

                                <?php case ('approved'): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#E0E7FF;
                                            color:#3730A3;
                                        "
                                    >
                                        Đã duyệt
                                    </span>

                                <?php break; ?>

                                <?php case ('renting'): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#FEF3C7;
                                            color:#92400E;
                                        "
                                    >
                                        Đang thuê
                                    </span>

                                <?php break; ?>

                                <?php case ('returned'): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#D1FAE5;
                                            color:#065F46;
                                        "
                                    >
                                        Đã trả
                                    </span>

                                <?php break; ?>

                            <?php endswitch; ?>

                        </td>

                        <td>

                            <div
                                class="
                                    d-flex
                                    gap-1
                                    flex-wrap
                                "
                            >

                                <?php if(
                                    $item->students_count == 0
                                ): ?>

                                    <a
                                        href="<?php echo e(route(
                                            'admin.rentals.students.create',
                                            $item->id
                                        )); ?>"
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#10B981;
                                        "
                                    >
                                        Import
                                    </a>

                                <?php else: ?>

                                    <a
                                        href="<?php echo e(route(
                                            'admin.rentals.students.export',
                                            $item->id
                                        )); ?>"
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#06B6D4;
                                        "
                                    >
                                        Xuất File
                                    </a>

                                <?php endif; ?>

                                <a
                                    href="<?php echo e(route(
                                        'admin.rentals.edit',
                                        $item->id
                                    )); ?>"
                                    class="btn btn-sm text-white"
                                    style="
                                        background:#F59E0B;
                                    "
                                >
                                    Sửa
                                </a>

                                <form
                                    action="<?php echo e(route(
                                        'admin.rentals.destroy',
                                        $item->id
                                    )); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Xóa đơn thuê này?')"
                                >

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#EF4444;
                                        "
                                    >
                                        Xóa
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="10"
                            class="text-center py-5 text-muted"
                        >
                            Chưa có đơn thuê nào
                        </td>

                    </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <?php if($data->hasPages()): ?>

    <div class="card-footer bg-white">

        <?php echo e($data->links()); ?>


    </div>

    <?php endif; ?>

</div>


</div>

<style>

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#F8FAFC;
}

.badge{
    border-radius:10px;
}

.btn{
    border-radius:10px;
}

</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rentals/index.blade.php ENDPATH**/ ?>