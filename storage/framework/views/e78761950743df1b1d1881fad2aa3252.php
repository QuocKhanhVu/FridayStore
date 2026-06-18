

<?php $__env->startSection('title', 'Báo hỏng / Báo mất'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Báo hỏng / Báo mất trang phục
            </h3>

            <p class="text-muted mb-0">
                Trừ số lượng hàng trong kho khi trang phục bị lỗi, hỏng hoặc lớp làm mất
            </p>
        </div>

        <a
            href="<?php echo e(route('admin.inventory.index')); ?>"
            class="btn btn-secondary"
        >
            <i class="fa fa-arrow-left me-1"></i>
            Quay lại tồn kho
        </a>

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

    <?php if($errors->any()): ?>

        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li>
                        <?php echo e($error); ?>

                    </li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

    <?php endif; ?>

    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Thông tin báo hỏng / mất
                    </h5>

                </div>

                <div class="card-body">

                    <form
                        action="<?php echo e(route('admin.inventory.damage.store')); ?>"
                        method="POST"
                    >

                        <?php echo csrf_field(); ?>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
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
                                        -- Chọn trang phục --
                                    </option>

                                    <?php $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option
                                            value="<?php echo e($costume->id); ?>"
                                            data-sizes='<?php echo json_encode($costume->sizes, 15, 512) ?>'
                                            <?php echo e(old('costume_id') == $costume->id ? 'selected' : ''); ?>

                                        >
                                            <?php echo e($costume->code); ?>

                                            -
                                            <?php echo e($costume->name); ?>

                                        </option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Size
                                </label>

                                <select
                                    name="costume_size_id"
                                    id="costume_size_id"
                                    class="form-select"
                                >
                                    <option value="">
                                        -- Không chia size --
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Loại xử lý
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="type"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        -- Chọn loại --
                                    </option>

                                    <option
                                        value="broken"
                                        <?php echo e(old('type') == 'broken' ? 'selected' : ''); ?>

                                    >
                                        Trang phục bị hỏng / lỗi
                                    </option>

                                    <option
                                        value="lost"
                                        <?php echo e(old('type') == 'lost' ? 'selected' : ''); ?>

                                    >
                                        Lớp làm mất
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Số lượng
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="quantity"
                                    value="<?php echo e(old('quantity', 1)); ?>"
                                    min="1"
                                    class="form-control"
                                    required
                                >

                            </div>

                            <div class="col-md-12">

                                <label class="form-label fw-bold">
                                    Đơn thuê / lớp liên quan
                                </label>

                                <select
                                    name="rental_id"
                                    class="form-select"
                                >
                                    <option value="">
                                        -- Không chọn --
                                    </option>

                                    <?php $__currentLoopData = $rentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option
                                            value="<?php echo e($rental->id); ?>"
                                            <?php echo e(old('rental_id') == $rental->id ? 'selected' : ''); ?>

                                        >
                                            <?php echo e($rental->code); ?>

                                            -
                                            <?php echo e($rental->class_name); ?>

                                            -
                                            <?php echo e($rental->school_name); ?>

                                            -
                                            <?php echo e($rental->studio->name ?? '---'); ?>

                                        </option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                            </div>

                            <div class="col-md-12">

                                <label class="form-label fw-bold">
                                    Ghi chú
                                </label>

                                <textarea
                                    name="note"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Ví dụ: Lớp làm mất 1 áo vest size 5, đã báo studio..."
                                ><?php echo e(old('note')); ?></textarea>

                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">

                            <button
                                type="reset"
                                class="btn btn-light border"
                            >
                                Nhập lại
                            </button>

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bạn chắc chắn muốn trừ số lượng trong kho?')"
                            >
                                <i class="fa fa-minus-circle me-1"></i>
                                Trừ kho
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Ghi chú chức năng
                    </h5>

                </div>

                <div class="card-body text-muted">

                    <p>
                        Khi báo hỏng hoặc mất, hệ thống sẽ tự động trừ số lượng khỏi tồn kho.
                    </p>

                    <p>
                        Số lượng trừ không được lớn hơn số lượng còn khả dụng.
                    </p>

                    <p class="mb-0">
                        Nên chọn đơn thuê/lớp liên quan để dễ đối soát sau này.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
    const costumeSelect = document.getElementById('costume_id');
    const sizeSelect = document.getElementById('costume_size_id');

    function loadSizes() {
        const selected = costumeSelect.options[costumeSelect.selectedIndex];

        sizeSelect.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Không chia size --';

        sizeSelect.appendChild(defaultOption);

        if (!selected || !selected.dataset.sizes) {
            return;
        }

        const sizes = JSON.parse(selected.dataset.sizes);

        sizes.forEach(function(size) {
            const option = document.createElement('option');

            option.value = size.id;
            option.textContent = size.size_name;

            if ("<?php echo e(old('costume_size_id')); ?>" == size.id) {
                option.selected = true;
            }

            sizeSelect.appendChild(option);
        });
    }

    costumeSelect.addEventListener('change', loadSizes);

    loadSizes();
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/warehouse/inventory/damage/create.blade.php ENDPATH**/ ?>