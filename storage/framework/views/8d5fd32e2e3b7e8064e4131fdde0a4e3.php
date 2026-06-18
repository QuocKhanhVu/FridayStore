

<?php $__env->startSection('title', 'Thêm Concept'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Thêm Concept
            </h3>

            <p class="text-muted mb-0">
                Tạo concept và gán trang phục
            </p>

        </div>

        <a
            href="<?php echo e(route('admin.concepts.index')); ?>"
            class="btn btn-light border"
        >

            <i class="fa fa-arrow-left me-2"></i>

            Quay lại

        </a>

    </div>

    <?php if($errors->any()): ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><?php echo e($error); ?></li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

        </div>

    <?php endif; ?>

    <form
        action="<?php echo e(route('admin.concepts.store')); ?>"
        method="POST"
        enctype="multipart/form-data"
    >

        <?php echo csrf_field(); ?>

        <div class="row">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Thông tin Concept
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Tên Concept

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="name"
                                value="<?php echo e(old('name')); ?>"
                                class="form-control"
                            >

                        </div>
                        <div class="mb-3">

                            <label class="form-label fw-semibold">

                                Giá Concept

                                <span class="text-danger">*</span>

                            </label>

                             <div class="input-group">

                            <input
                                type="number"
                                name="price"
                                value="<?php echo e(old('price')); ?>"
                                class="form-control"
                                placeholder="Ví dụ: 2500000"
                            >

                            <span class="input-group-text">

                                VNĐ

                            </span>

                        </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    Chiết khấu (%)
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    name="discount_percent"
                                    value="<?php echo e(old('discount_percent', $concept->discount_percent ?? 0)); ?>"
                                    class="form-control"
                                    placeholder="VD: 10"
                                >
                            </div>
                        </div>
                        
                        <div class="mb-3">

                            <label class="form-label">

                                Mô tả

                            </label>

                            <textarea
                                rows="5"
                                name="description"
                                class="form-control"
                            ><?php echo e(old('description')); ?></textarea>

                        </div>

                    </div>

                </div>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Trang phục thuộc Concept
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <?php $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-md-4 mb-3">

                                    <div
                                        class="border rounded p-3 h-100"
                                    >

                                        <div
                                            class="form-check"
                                        >

                                            <input
                                                type="checkbox"
                                                name="costumes[]"
                                                value="<?php echo e($costume->id); ?>"
                                                class="form-check-input"
                                            >

                                            <label
                                                class="form-check-label fw-semibold"
                                            >

                                                <?php echo e($costume->name); ?>


                                            </label>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Hình ảnh

                        </h5>

                    </div>

                    <div class="card-body">

                        <input
                            type="file"
                            name="thumbnail"
                            class="form-control"
                        >

                    </div>

                </div>

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Trạng thái

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="form-check mb-2">

                            <input
                                type="radio"
                                name="status"
                                value="1"
                                checked
                                class="form-check-input"
                            >

                            <label
                                class="form-check-label"
                            >

                                Hoạt động

                            </label>

                        </div>

                        <div class="form-check">

                            <input
                                type="radio"
                                name="status"
                                value="0"
                                class="form-check-input"
                            >

                            <label
                                class="form-check-label"
                            >

                                Ngừng hoạt động

                            </label>

                        </div>

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >

                    <i class="fa fa-save me-2"></i>

                    Lưu Concept

                </button>

            </div>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/concepts/create.blade.php ENDPATH**/ ?>