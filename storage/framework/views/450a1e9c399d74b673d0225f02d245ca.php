<?php $__env->startSection('title', 'Quản lý Concept'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Quản lý Concept
            </h3>

            <p class="text-muted mb-0">
                Quản lý concept chụp kỷ yếu
            </p>

        </div>

        <a
            href="<?php echo e(route('admin.concepts.create')); ?>"
            class="btn btn-primary"
        >

            <i class="fa fa-plus me-2"></i>

            Thêm Concept

        </a>

    </div>

    <?php if(session('success')): ?>

        <div class="alert alert-success">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            value="<?php echo e(request('keyword')); ?>"
                            class="form-control"
                            placeholder="Tìm tên concept..."
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100"
                        >

                            <i class="fa fa-search me-2"></i>

                            Tìm kiếm

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                Danh sách Concept

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                >

                    <thead class="table-light">

                        <tr>

                            <th width="80">
                                #
                            </th>

                            <th width="120">
                                Ảnh
                            </th>

                            <th>
                                Tên Concept
                            </th>

                            <th>
                                Số trang phục
                            </th>
                            <th>
                                Giá thuê
                            </th>
                            <th>
                                Chiết khấu
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

                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <td>

                                    <?php echo e($loop->iteration); ?>


                                </td>

                                <td>

                                    <img
                                        src="<?php echo e($item->thumbnail
                                        ? asset('storage/'.$item->thumbnail)
                                        : 'https://placehold.co/80x80'); ?>"
                                        width="70"
                                        class="rounded border"
                                    >

                                </td>

                                <td>

                                    <strong>

                                        <?php echo e($item->name); ?>


                                    </strong>

                                    <?php if($item->description): ?>

                                        <div
                                            class="small text-muted"
                                        >

                                            <?php echo e(Str::limit(
                                                $item->description,
                                                60
                                            )); ?>


                                        </div>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <span
                                        class="badge bg-info"
                                    >

                                        <?php echo e($item->costumes_count); ?>


                                        trang phục

                                    </span>

                                </td>
                                <td>

                                    <?php echo e(number_format($item->price)); ?>


                                    VNĐ

                                </td>
                                <td>

                                    <?php echo e($item->discount_percent); ?>


                                    %

                                </td>
                                <td>

                                    <?php if($item->status): ?>

                                        <span
                                            class="badge bg-success"
                                        >

                                            Hoạt động

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge bg-danger"
                                        >

                                            Ngừng hoạt động

                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <a
                                        href="<?php echo e(route(
                                            'admin.concepts.edit',
                                            $item->id
                                        )); ?>"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i
                                            class="fa fa-pen"
                                        ></i>

                                    </a>

                                    <form
                                        action="<?php echo e(route(
                                            'admin.concepts.destroy',
                                            $item->id
                                        )); ?>"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Bạn có chắc chắn muốn xóa?'
                                        )"
                                    >

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >

                                            <i
                                                class="fa fa-trash"
                                            ></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4"
                                >

                                    Không có dữ liệu

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/concepts/index.blade.php ENDPATH**/ ?>