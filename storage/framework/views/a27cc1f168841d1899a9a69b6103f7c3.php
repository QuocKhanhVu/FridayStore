

<?php $__env->startSection('title', 'Quản lý Size'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Quản lý Size
            </h3>
            <p class="text-muted mb-0">
                Cấu hình size cho từng loại trang phục
            </p>
        </div>

        <a href="<?php echo e(route('admin.sizes.create')); ?>" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>
            Thêm Size
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('admin.sizes.index')); ?>" method="GET">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="keyword"
                            value="<?php echo e(request('keyword')); ?>"
                            class="form-control"
                            placeholder="Tìm tên trang phục..."
                        >
                    </div>

                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search me-2"></i>
                            Tìm kiếm
                        </button>
                    </div>

                    <?php if(request('keyword')): ?>
                        <div class="col-md-auto">
                            <a href="<?php echo e(route('admin.sizes.index')); ?>"
                               class="btn btn-secondary">
                                <i class="fa fa-rotate-left me-2"></i>
                                Làm mới
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Danh sách size
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Trang phục</th>
                            <th>Size</th>
                            <th>Chiều cao</th>
                            <th>Cân nặng</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th width="140">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                <td>
                                    <?php echo e(($data->currentPage() - 1)
                                        * $data->perPage()
                                        + $loop->iteration); ?>

                                </td>

                                <td>
                                    <?php echo e($item->costume->name ?? '-'); ?>

                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        <?php echo e($item->size_name); ?>

                                    </span>
                                </td>

                                <td>
                                    <?php if($item->rule): ?>
                                        <?php echo e($item->rule->height_from); ?>

                                        -
                                        <?php echo e($item->rule->height_to); ?> cm
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($item->rule): ?>
                                        <?php echo e($item->rule->weight_from); ?>

                                        -
                                        <?php echo e($item->rule->weight_to); ?> kg
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php echo e($item->display_order); ?>

                                </td>

                                <td>
                                    <?php if($item->status): ?>
                                        <span class="badge bg-success">
                                            Hoạt động
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">
                                            Ngừng hoạt động
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a
                                        href="<?php echo e(route('admin.sizes.edit', $item->id)); ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <form
                                        action="<?php echo e(route('admin.sizes.destroy', $item->id)); ?>"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa size này?')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Không có dữ liệu
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

        
        <?php if($data->hasPages()): ?>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

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

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/sizes/index.blade.php ENDPATH**/ ?>