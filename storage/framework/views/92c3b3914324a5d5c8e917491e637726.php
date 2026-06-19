<?php $__env->startSection('title', 'Tồn kho'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Quản lý tồn kho</h3>
        <p class="text-muted mb-0">
            Theo dõi số lượng trang phục theo từng size
        </p>
    </div>

    <div>
        <a
            href="<?php echo e(route('admin.inventory.export')); ?>"
            class="btn btn-success shadow-sm"
        >
            <i class="fa fa-file-excel me-2"></i>
            Xuất Excel
        </a>
    </div>

</div>


<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-2">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="keyword"
                        value="<?php echo e(request('keyword')); ?>"
                        class="form-control"
                        placeholder="Tìm kiếm trang phục..."
                    >

                </div>

                <div class="col-md-3">

                    <select
                        name="category_id"
                        class="form-select"
                    >

                        <option value="">
                            Tất cả loại trang phục
                        </option>

                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($category->id); ?>"
                                <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($category->name); ?>

                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        name="size_id"
                        class="form-select"
                    >

                        <option value="">
                            Tất cả size
                        </option>

                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($size->id); ?>"
                                <?php echo e(request('size_id') == $size->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($size->size_name); ?>

                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary w-100"
                    >
                        <i class="fa fa-search me-2"></i>
                        Tìm kiếm
                    </button>

                </div>

                <div class="col-md-1">

                    <a
                        href="<?php echo e(route('admin.inventory.index')); ?>"
                        class="btn btn-outline-secondary w-100"
                    >
                        <i class="fa fa-rotate"></i>
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Tổng sản phẩm
                </h6>

                <h2 class="fw-bold">
                    <?php echo e(\App\Models\Inventory::sum('quantity')); ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Đang cho thuê
                </h6>

                <h2 class="fw-bold text-primary">
                    <?php echo e(\App\Models\Inventory::sum('rented_quantity')); ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Sắp hết hàng
                </h6>

                <h2 class="fw-bold text-warning">
                    <?php echo e(\App\Models\Inventory::get()
                        ->filter(function ($item) {

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                            return $available > 0
                                && $available <= 5;
                        })
                        ->count()); ?>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Hết hàng
                </h6>

                <h2 class="fw-bold text-danger">
                    <?php echo e(\App\Models\Inventory::get()
                        ->filter(function ($item) {

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                            return $available <= 0;
                        })
                        ->count()); ?>

                </h2>

            </div>

        </div>

    </div>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Danh sách tồn kho
        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>Trang phục</th>
                        <th>Size</th>
                        <th>Tồn kho</th>
                        <th>Đang thuê</th>
                        <th>Khả dụng</th>
                        <th>Trạng thái</th>
                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php

                            $available =
                                $item->quantity
                                - $item->rented_quantity
                                - $item->broken_quantity
                                - $item->lost_quantity;

                        ?>

                        <tr>

                            <td>
                                <?php echo e(($data->currentPage() - 1)
                                    * $data->perPage()
                                    + $loop->iteration); ?>

                            </td>

                            <td>
                                <strong>
                                    <?php echo e($item->costume?->name); ?>

                                </strong>
                            </td>

                            <td>
                                <?php echo e($item->size?->size_name); ?>

                            </td>

                            <td>
                                <?php echo e($item->quantity); ?>

                            </td>

                            <td>
                                <?php echo e($item->rented_quantity); ?>

                            </td>

                            <td>
                                <?php echo e($available); ?>

                            </td>

                            <td>

                                <?php if($available <= 0): ?>

                                    <span class="badge bg-danger">
                                        Hết hàng
                                    </span>

                                <?php elseif($available <= 5): ?>

                                    <span class="badge bg-warning text-dark">
                                        Sắp hết
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success">
                                        Còn hàng
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-4"
                            >
                                Chưa có dữ liệu tồn kho
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <?php if($data->hasPages()): ?>

        <div
            class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2"
        >

            <small class="text-muted">

                Hiển thị
                <?php echo e($data->firstItem() ?? 0); ?>

                -
                <?php echo e($data->lastItem() ?? 0); ?>

                /
                <?php echo e($data->total()); ?> bản ghi

            </small>

            <?php echo e($data->withQueryString()->links()); ?>


        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/inventory/index.blade.php ENDPATH**/ ?>