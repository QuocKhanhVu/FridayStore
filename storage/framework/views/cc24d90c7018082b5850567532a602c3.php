

<?php $__env->startSection('title','Cập nhật Size'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <?php if(session('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <?php echo e(session('success')); ?>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <?php if($errors->any()): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>
                <i class="fa fa-circle-exclamation me-2"></i>
                Có lỗi xảy ra:
            </strong>

            <ul class="mb-0 mt-2">

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><?php echo e($error); ?></li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <form
        action="<?php echo e(route('admin.sizes.update', $costumeSize->id)); ?>"
        method="POST"
    >

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0">

                    Cập nhật Size

                </h4>

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <label class="form-label">

                        Trang phục

                    </label>

                    <select
                        name="costume_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Chọn trang phục
                        </option>

                        <?php $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($costume->id); ?>"
                                <?php echo e(old('costume_id', $costumeSize->costume_id) == $costume->id ? 'selected' : ''); ?>

                            >

                                <?php echo e($costume->name); ?>


                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>

                <div class="table-responsive">

                    <table
                        class="table table-bordered"
                        id="sizeTable"
                    >

                        <thead>

                            <tr>

                                <th width="120">
                                    Size
                                </th>

                                <th>
                                    Cao từ
                                </th>

                                <th>
                                    Cao đến
                                </th>

                                <th>
                                    Nặng từ
                                </th>

                                <th>
                                    Nặng đến
                                </th>

                                <th width="80">

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $costumeSize->costume->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td>

                                    <input
                                        type="hidden"
                                        name="sizes[<?php echo e($index); ?>][id]"
                                        value="<?php echo e($size->id); ?>"
                                    >

                                    <input
                                        type="text"
                                        name="sizes[<?php echo e($index); ?>][size_name]"
                                        value="<?php echo e(old("sizes.$index.size_name", $size->size_name)); ?>"
                                        class="form-control"
                                        required
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[<?php echo e($index); ?>][height_from]"
                                        value="<?php echo e(old("sizes.$index.height_from", optional($size->rule)->height_from)); ?>"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[<?php echo e($index); ?>][height_to]"
                                        value="<?php echo e(old("sizes.$index.height_to", optional($size->rule)->height_to)); ?>"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[<?php echo e($index); ?>][weight_from]"
                                        value="<?php echo e(old("sizes.$index.weight_from", optional($size->rule)->weight_from)); ?>"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[<?php echo e($index); ?>][weight_to]"
                                        value="<?php echo e(old("sizes.$index.weight_to", optional($size->rule)->weight_to)); ?>"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="btn btn-danger removeRow"
                                    >

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </td>

                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>

                <button
                    type="button"
                    id="addRow"
                    class="btn btn-outline-primary"
                >

                    <i class="fa fa-plus me-2"></i>

                    Thêm dòng

                </button>

            </div>

            <div class="card-footer bg-white text-end">

                <button
                    type="submit"
                    class="btn btn-warning"
                >

                    <i class="fa fa-pen-to-square me-2"></i>

                    Cập nhật

                </button>

                <a
                    href="<?php echo e(route('admin.sizes.index')); ?>"
                    class="btn btn-light border shadow-sm"
                >

                    <i class="fa fa-arrow-left me-2"></i>

                    Quay lại

                </a>

            </div>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>

let index = <?php echo e($costumeSize->costume->sizes->count()); ?>;

$('#addRow').click(function(){

    $('#sizeTable tbody').append(`

        <tr>

            <td>

                <input
                    type="text"
                    name="sizes[${index}][size_name]"
                    class="form-control"
                    required
                >

            </td>

            <td>

                <input
                    type="number"
                    name="sizes[${index}][height_from]"
                    class="form-control"
                >

            </td>

            <td>

                <input
                    type="number"
                    name="sizes[${index}][height_to]"
                    class="form-control"
                >

            </td>

            <td>

                <input
                    type="number"
                    name="sizes[${index}][weight_from]"
                    class="form-control"
                >

            </td>

            <td>

                <input
                    type="number"
                    name="sizes[${index}][weight_to]"
                    class="form-control"
                >

            </td>

            <td>

                <button
                    type="button"
                    class="btn btn-danger removeRow"
                >

                    <i class="fa fa-trash"></i>

                </button>

            </td>

        </tr>

    `);

    index++;

});

$(document).on(
    'click',
    '.removeRow',
    function(){

        $(this).closest('tr').remove();

    }
);

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/sizes/edit.blade.php ENDPATH**/ ?>