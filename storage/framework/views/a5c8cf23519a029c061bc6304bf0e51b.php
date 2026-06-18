

<?php $__env->startSection('title', 'Danh mục trang phục'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Danh mục trang phục
            </h3>

            <p class="text-muted mb-0">
                Quản lý toàn bộ trang phục trong kho
            </p>

        </div>

        <div>

            <a href="<?php echo e(route('admin.costumes.export', [
                    'keyword' => request('keyword'),
                    'gender' => request('gender'),
                    'status' => request('status'),
                ])); ?>"
            class="btn btn-outline-success me-2">

                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel

            </a>

            <a href="<?php echo e(route('admin.costumes.create')); ?>"
               class="btn btn-primary">

                <i class="fa fa-plus me-2"></i>
                Thêm trang phục

            </a>

        </div>

    </div>

    

    <?php if(session('success')): ?>

        <div class="alert alert-success">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>

    

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            value="<?php echo e(request('keyword')); ?>"
                            class="form-control"
                            placeholder="Tìm kiếm tên trang phục..."
                        >

                    </div>

                    <div class="col-md-2">

                        <select
                            name="gender"
                            class="form-select"
                        >

                            <option value="">
                                Tất cả giới tính
                            </option>

                            <option value="male"
                                <?php echo e(request('gender') == 'male' ? 'selected' : ''); ?>>
                                Nam
                            </option>

                            <option value="female"
                                <?php echo e(request('gender') == 'female' ? 'selected' : ''); ?>>
                                Nữ
                            </option>

                            <option value="unisex"
                                <?php echo e(request('gender') == 'unisex' ? 'selected' : ''); ?>>
                                Unisex
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                Tất cả trạng thái
                            </option>

                            <option value="1"
                                <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>
                                Hoạt động
                            </option>

                            <option value="0"
                                <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>
                                Ngừng sử dụng
                            </option>

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

                    <div class="col-md-2">

                        <a href="<?php echo e(route('admin.costumes.index')); ?>"
                           class="btn btn-secondary w-100">

                            Làm mới

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Danh sách trang phục
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="80">
                                Ảnh
                            </th>

                            <th>
                                Mã
                            </th>

                            <th>
                                Tên trang phục
                            </th>

                            <th>
                                Loại
                            </th>

                            <th>
                                Giới tính
                            </th>

                            <th>
                                Giá thuê
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th width="150">
                                Thao tác
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <td>

                                    <?php if($costume->image): ?>

                                        <img
                                            src="<?php echo e(asset('storage/' . $costume->image)); ?>"
                                            width="50"
                                            height="50"
                                            class="rounded border"
                                            style="object-fit:cover"
                                        >

                                    <?php else: ?>

                                        <img
                                            src="https://placehold.co/50x50"
                                            width="50"
                                            height="50"
                                            class="rounded border"
                                        >

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?php echo e($costume->code); ?>


                                </td>

                                <td>

                                    <strong>

                                        <?php echo e($costume->name); ?>


                                    </strong>

                                </td>

                                <td>

                                    <?php echo e($costume->category?->name); ?>


                                </td>

                                <td>

                                    <?php switch($costume->gender):

                                        case ('male'): ?>
                                            Nam
                                            <?php break; ?>

                                        <?php case ('female'): ?>
                                            Nữ
                                            <?php break; ?>

                                        <?php default: ?>
                                            Unisex

                                    <?php endswitch; ?>

                                </td>

                                <td>

                                    <?php echo e(number_format($costume->rental_price)); ?> đ

                                </td>

                                <td>

                                    <?php if($costume->status): ?>

                                        <span class="badge bg-success">
                                            Hoạt động
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            Ngừng sử dụng
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <a
                                        href="<?php echo e(route('admin.costumes.edit',$costume->id)); ?>"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i class="fa fa-pen"></i>

                                    </a>

                                    <form
                                        action="<?php echo e(route('admin.costumes.destroy', $costume->id)); ?>"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa trang phục này?')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fa fa-box-open fa-3x mb-3"></i>

                                        <p class="mb-0">

                                            Chưa có trang phục nào

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <?php if($costumes->hasPages()): ?>

            <div class="card-footer bg-white">

                <?php echo e($costumes->links()); ?>


            </div>

        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/costumes/index.blade.php ENDPATH**/ ?>