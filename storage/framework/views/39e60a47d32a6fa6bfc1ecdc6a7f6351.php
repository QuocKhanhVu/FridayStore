

<?php $__env->startSection('title','Lịch sử thuê đồ'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Lịch sử thuê đồ
            </h2>

            <p class="text-muted mb-0">
                Danh sách đơn đã hoàn thành
            </p>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Tìm mã đơn, trường, lớp..."
                            value="<?php echo e(request('keyword')); ?>"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary"
                        >
                            <i class="fa fa-search me-2"></i>
                            Tìm kiếm
                        </button>

                    </div>

                </div>

            </form>

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

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Mã đơn</th>

                        <th>Trường</th>

                        <th>Lớp</th>

                        <th>Concept</th>

                        <th>Sĩ số</th>

                        <th>Ngày chụp</th>

                        <th width="120">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            <td>

                                <span
                                    class="
                                        fw-bold
                                        text-primary
                                    "
                                >
                                    <?php echo e($item->code); ?>

                                </span>

                            </td>

                            <td>
                                <?php echo e($item->school_name); ?>

                            </td>

                            <td>
                                <?php echo e($item->class_name); ?>

                            </td>

                            <td>

                                <span
                                    class="
                                        badge
                                        bg-info
                                    "
                                >
                                    <?php echo e($item->concept->name ?? '---'); ?>

                                </span>

                            </td>

                            <td>

                                <?php echo e($item->students_count); ?>


                            </td>

                            <td>

                                <?php echo e(\Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y')); ?>


                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    <a
                                        href="<?php echo e(route('admin.rental-history.show', $item->id)); ?>"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Xem chi tiết"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <form
                                        action="<?php echo e(route('admin.rental-history.destroy', $item->id)); ?>"
                                        method="POST"
                                        onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn này khỏi lịch sử?')"
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

                                </div>
                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="8"
                                class="
                                    text-center
                                    py-5
                                "
                            >

                                Không có dữ liệu

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rental-history/index.blade.php ENDPATH**/ ?>