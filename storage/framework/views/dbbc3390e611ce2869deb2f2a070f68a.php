

<?php $__env->startSection('title', 'Import danh sách học sinh'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h4 class="mb-0">
                        Import danh sách học sinh
                    </h4>

                </div>

                <form
                    action="<?php echo e(route('admin.rentals.students.store',$rental->id)); ?>"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <?php echo csrf_field(); ?>

                    <div class="card-body">

                        <div class="alert alert-info">

                            <strong>Thông tin đơn thuê:</strong>

                            <hr>

                            <p class="mb-1">
                                <strong>Mã đơn:</strong>
                                <?php echo e($rental->code); ?>

                            </p>

                            <p class="mb-1">
                                <strong>Trường:</strong>
                                <?php echo e($rental->school_name); ?>

                            </p>

                            <p class="mb-0">
                                <strong>Lớp:</strong>
                                <?php echo e($rental->class_name); ?>

                            </p>

                        </div>

                        

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                File Excel

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="file"
                                name="file"
                                class="form-control <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                accept=".xlsx,.xls"
                            >

                            <?php $__errorArgs = ['file'];
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

                        <hr>

                        <h5 class="mb-3">
                            Cấu hình cột dữ liệu
                        </h5>

                        <div class="row">

                            

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Dòng bắt đầu

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="start_row"
                                    value="<?php echo e(old('start_row',10)); ?>"
                                    class="form-control <?php $__errorArgs = ['start_row'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >

                                <?php $__errorArgs = ['start_row'];
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

                            

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Họ tên

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="name_column"
                                    value="<?php echo e(old('name_column','B')); ?>"
                                    class="form-control <?php $__errorArgs = ['name_column'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >

                                <?php $__errorArgs = ['name_column'];
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

                            

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Cột Giới tính

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="gender_column"
                                    value="<?php echo e(old('gender_column','C')); ?>"
                                    class="form-control <?php $__errorArgs = ['gender_column'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >

                                <?php $__errorArgs = ['gender_column'];
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

                                <label class="form-label fw-bold">

                                    Cột Chiều cao

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="height_column"
                                    value="<?php echo e(old('height_column','D')); ?>"
                                    class="form-control <?php $__errorArgs = ['height_column'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >

                                <?php $__errorArgs = ['height_column'];
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

                                <label class="form-label fw-bold">

                                    Cột Cân nặng

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="weight_column"
                                    value="<?php echo e(old('weight_column','E')); ?>"
                                    class="form-control <?php $__errorArgs = ['weight_column'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >

                                <?php $__errorArgs = ['weight_column'];
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

                        <div class="alert alert-warning">

                            <h6>
                                Ví dụ file Excel
                            </h6>

                            <ul class="mb-0">

                                <li>
                                    Họ tên ở cột B
                                </li>

                                <li>
                                    Giới tính ở cột C
                                </li>

                                <li>
                                    Chiều cao ở cột D
                                </li>

                                <li>
                                    Cân nặng ở cột E
                                </li>

                                <li>
                                    Dữ liệu bắt đầu từ dòng 10
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="card-footer bg-white text-end">

                        <a
                            href="<?php echo e(route('admin.rentals.index')); ?>"
                            class="btn btn-secondary"
                        >
                            Quay lại
                        </a>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fa fa-file-excel me-2"></i>
                            Import Excel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rentals/import_students.blade.php ENDPATH**/ ?>