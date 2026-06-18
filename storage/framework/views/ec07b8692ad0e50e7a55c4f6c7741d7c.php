

<?php $__env->startSection('title', 'Nhập kho'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Nhập kho
            </h3>

            <p class="text-muted mb-0">
                Thêm số lượng trang phục vào kho
            </p>

        </div>

        <a
            href="<?php echo e(route('admin.inventory.index')); ?>"
            class="btn btn-outline-secondary"
        >
            <i class="fa fa-arrow-left me-2"></i>
            Quay lại
        </a>

    </div>

    <?php if(session('success')): ?>

        <div class="alert alert-success">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>

    <?php if($errors->any()): ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><?php echo e($error); ?></li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

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
        action="<?php echo e(route('admin.inventory.store')); ?>"
        method="POST"
    >

        <?php echo csrf_field(); ?>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Thông tin nhập kho

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Trang phục

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="costume_id"
                            id="costume_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Chọn trang phục
                            </option>

                            <?php $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($costume->id); ?>"
                                >
                                    <?php echo e($costume->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                        <?php $__errorArgs = ['costume_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Size

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="costume_size_id"
                            id="size_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Chọn size
                            </option>

                        </select>
                        <?php $__errorArgs = ['costume_size_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>

                <div class="row">

                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Số lượng nhập

                        </label>

                        <input
                            type="number"
                            min="1"
                            name="quantity"
                            class="form-control"
                            placeholder="Nhập số lượng"
                            required
                        >
                        <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Ghi chú

                    </label>

                    <textarea
                        name="note"
                        rows="4"
                        class="form-control"
                        placeholder="Nhập ghi chú..."
                    ></textarea>
                        <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="fa fa-box me-2"></i>

                    Nhập kho

                </button>

            </div>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>

const costumes = <?php echo json_encode($costumes, 15, 512) ?>;

$('#costume_id').change(function(){

    let costumeId = $(this).val();

    let sizeSelect = $('#size_id');

    sizeSelect.html(
        '<option value="">Chọn size</option>'
    );

    let costume = costumes.find(
        x => x.id == costumeId
    );

    if(costume){

        costume.sizes.forEach(size => {

            sizeSelect.append(`
                <option value="${size.id}">
                    ${size.size_name}
                </option>
            `);

        });

    }

});

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/inventory/create.blade.php ENDPATH**/ ?>