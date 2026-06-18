

<?php $__env->startSection('title','Studio thuê đồ'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Studio thuê đồ
            </h3>

            <p class="text-muted mb-0">
                Quản lý đối tác thuê trang phục
            </p>

        </div>

        <a
            href="<?php echo e(route('admin.studios.create')); ?>"
            class="btn btn-primary"
        >
            <i class="fa fa-plus me-2"></i>
            Thêm Studio
        </a>

    </div>

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
                            placeholder="Tên studio hoặc SĐT"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary"
                        >
                            Tìm kiếm
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <table
                class="table table-hover mb-0"
            >

                <thead class="table-light">

                    <tr>

                        <th>#</th>

                        <th>Tên Studio</th>

                        <th>Người đại diện</th>

                        <th>SĐT</th>

                        <th>Địa chỉ</th>

                        <th>Trạng thái</th>

                        <th width="120">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>
                            <?php echo e($item->id); ?>

                        </td>

                        <td>
                            <?php echo e($item->name); ?>

                        </td>

                        <td>
                            <?php echo e($item->contact_person); ?>

                        </td>

                        <td>
                            <?php echo e($item->phone); ?>

                        </td>

                        <td>
                            <?php echo e($item->address); ?>

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
                                href="<?php echo e(route('admin.studios.edit',$item->id)); ?>"
                                class="btn btn-warning btn-sm"
                            >
                                <i class="fa fa-pen"></i>
                            </a>

                            <form
                                action="<?php echo e(route('admin.studios.destroy',$item->id)); ?>"
                                method="POST"
                                class="d-inline"
                            >

                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa studio này?')"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="7"
                            class="text-center"
                        >

                            Không có dữ liệu

                        </td>

                    </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <div class="card-footer">

            <?php echo e($data->links()); ?>


        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/studios/index.blade.php ENDPATH**/ ?>