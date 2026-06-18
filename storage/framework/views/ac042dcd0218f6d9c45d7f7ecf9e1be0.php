

<?php $__env->startSection('title', 'Tạo đơn thuê'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <form
        action="<?php echo e(route('admin.rentals.store')); ?>"
        method="POST"
    >
        <?php echo csrf_field(); ?>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0 fw-bold">
                    Tạo đơn thuê
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <h5 class="fw-bold text-primary mb-3">
                        Thông tin lớp
                    </h5>

                    
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Studio
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="studio_id"
                            class="form-select <?php $__errorArgs = ['studio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                -- Chọn Studio --
                            </option>

                            <?php $__currentLoopData = $studios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($studio->id); ?>"
                                    <?php echo e(old('studio_id') == $studio->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($studio->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['studio_id'];
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
                            Tên trường
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="school_name"
                            value="<?php echo e(old('school_name')); ?>"
                            class="form-control <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="VD: THPT Mạc Đĩnh Chi"
                        >

                        <?php $__errorArgs = ['school_name'];
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
                            Tên lớp
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="class_name"
                            value="<?php echo e(old('class_name')); ?>"
                            class="form-control <?php $__errorArgs = ['class_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="VD: 12A2"
                        >

                        <?php $__errorArgs = ['class_name'];
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

                    
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày chụp
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="shooting_date"
                            value="<?php echo e(old('shooting_date')); ?>"
                            class="form-control <?php $__errorArgs = ['shooting_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                        <?php $__errorArgs = ['shooting_date'];
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

                    
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày thuê
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="rental_date"
                            value="<?php echo e(old('rental_date')); ?>"
                            class="form-control <?php $__errorArgs = ['rental_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                        <?php $__errorArgs = ['rental_date'];
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

                    
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày trả
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="return_date"
                            value="<?php echo e(old('return_date')); ?>"
                            class="form-control <?php $__errorArgs = ['return_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                        <?php $__errorArgs = ['return_date'];
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

                    <hr class="my-4">

                    <h5 class="fw-bold text-success mb-3">
                        Trang phục / Concept
                    </h5>

                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Concept 1
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="concept_id"
                            id="concept_id"
                            class="form-select <?php $__errorArgs = ['concept_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                -- Chọn Concept 1 --
                            </option>

                            <?php $__currentLoopData = $concepts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($concept->id); ?>"
                                    <?php echo e(old('concept_id') == $concept->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($concept->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['concept_id'];
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
                            Concept 2
                        </label>

                        <select
                            name="second_concept_id"
                            id="second_concept_id"
                            class="form-select <?php $__errorArgs = ['second_concept_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            <?php $__currentLoopData = $concepts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($concept->id); ?>"
                                    <?php echo e(old('second_concept_id') == $concept->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($concept->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['second_concept_id'];
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
        Trang phục thêm
    </label>

    <div
        class="border rounded p-3 <?php $__errorArgs = ['extra_costume_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        style="max-height: 180px; overflow-y: auto;"
    >

        <?php $__empty_1 = true; $__currentLoopData = $extraCostumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="form-check mb-2">

                <input
                    class="form-check-input extra-costume-checkbox"
                    type="checkbox"
                    name="extra_costume_ids[]"
                    id="extra_costume_<?php echo e($item->id); ?>"
                    value="<?php echo e($item->id); ?>"
                    <?php if(collect(old('extra_costume_ids', []))->contains($item->id)): echo 'checked'; endif; ?>
                >

                <label
                    class="form-check-label"
                    for="extra_costume_<?php echo e($item->id); ?>"
                >
                    <?php echo e($item->name); ?>

                </label>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <div class="text-muted">
                Không có trang phục thêm
            </div>

        <?php endif; ?>

    </div>

    <small class="text-muted">
        Có thể tích chọn nhiều trang phục thêm
    </small>

    <?php $__errorArgs = ['extra_costume_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger small mt-1">
            <?php echo e($message); ?>

        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <?php $__errorArgs = ['extra_costume_ids.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger small mt-1">
            <?php echo e($message); ?>

        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-warning mb-3">
                        Trang phục không chia size
                    </h5>

                    
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Cử nhân
                        </label>

                        <select
                            name="graduation_costume_id"
                            id="graduation_id"
                            class="form-select <?php $__errorArgs = ['graduation_costume_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            <?php $__currentLoopData = $costumes_code_CN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($item->id); ?>"
                                    <?php echo e(old('graduation_costume_id') == $item->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($item->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['graduation_costume_id'];
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
                            Nơ nữ
                        </label>

                        <select
                            name="female_accessory_id"
                            id="female_accessory_id"
                            class="form-select <?php $__errorArgs = ['female_accessory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            <?php $__currentLoopData = $costumes_code_NO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($item->id); ?>"
                                    <?php echo e(old('female_accessory_id') == $item->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($item->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['female_accessory_id'];
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
                            Cà vạt nam
                        </label>

                        <select
                            name="male_accessory_id"
                            id="male_accessory_id"
                            class="form-select <?php $__errorArgs = ['male_accessory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            <?php $__currentLoopData = $costumes_code_CV; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($item->id); ?>"
                                    <?php echo e(old('male_accessory_id') == $item->id ? 'selected' : ''); ?>

                                >
                                    <?php echo e($item->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['male_accessory_id'];
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

                    
                    <div class="col-md-12 mt-2">

                        <label class="form-label fw-bold">
                            Ghi chú
                        </label>

                        <textarea
                            name="note"
                            rows="4"
                            class="form-control"
                            placeholder="Nhập ghi chú nếu có..."
                        ><?php echo e(old('note')); ?></textarea>

                    </div>

                    
                    <div class="col-md-12 mt-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-header bg-primary text-white fw-bold">
                                Trang phục sẽ sử dụng
                            </div>

                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-3">

                                        <strong>Concept 1</strong>

                                        <div id="previewConcept">
                                            Chưa chọn
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Concept 2</strong>

                                        <div id="previewSecondConcept">
                                            Không sử dụng
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Trang phục thêm</strong>

                                        <div id="previewExtraCostume">
                                            Không sử dụng
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Không chia size</strong>

                                        <div id="previewNoSize">
                                            Không sử dụng
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

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
                    class="btn btn-primary"
                >
                    Lưu đơn thuê
                </button>

            </div>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function selectedText(id, emptyText = 'Không sử dụng') {
        const select = document.getElementById(id);

        if (!select || !select.value) {
            return emptyText;
        }

        return select.options[select.selectedIndex].text.trim();
    }

    function updatePreview() {
        document.getElementById('previewConcept').innerText =
            selectedText('concept_id', 'Chưa chọn');

        document.getElementById('previewSecondConcept').innerText =
            selectedText('second_concept_id', 'Không sử dụng');

        const extraSelect = document.getElementById('extra_costume_ids');

        let extraNames = [];

        if (extraSelect) {
            extraNames = Array.from(extraSelect.selectedOptions)
                .map(option => option.text.trim());
        }

        document.getElementById('previewExtraCostume').innerText =
            extraNames.length ? extraNames.join(', ') : 'Không sử dụng';

        let noSize = [];

        const graduation = selectedText('graduation_id', '');
        const femaleAccessory = selectedText('female_accessory_id', '');
        const maleAccessory = selectedText('male_accessory_id', '');

        if (graduation) {
            noSize.push(graduation);
        }

        if (femaleAccessory) {
            noSize.push(femaleAccessory);
        }

        if (maleAccessory) {
            noSize.push(maleAccessory);
        }

        let extraNames = [];

document
    .querySelectorAll('.extra-costume-checkbox:checked')
    .forEach(function (checkbox) {
        let label = document.querySelector(
            'label[for="' + checkbox.id + '"]'
        );

        if (label) {
            extraNames.push(label.innerText.trim());
        }
    });

    let extraNames = [];

        document
            .querySelectorAll('.extra-costume-checkbox:checked')
            .forEach(function (checkbox) {
                let label = document.querySelector(
                    'label[for="' + checkbox.id + '"]'
                );

                if (label) {
                    extraNames.push(label.innerText.trim());
                }
            });

        document.getElementById('previewExtraCostume').innerText =
            extraNames.length ? extraNames.join(', ') : 'Không sử dụng';
    }

    [
    'concept_id',
    'second_concept_id',
    'graduation_id',
    'female_accessory_id',
    'male_accessory_id'
].forEach(function (id) {
    const element = document.getElementById(id);

    if (element) {
        element.addEventListener('change', updatePreview);
    }
});

document
    .querySelectorAll('.extra-costume-checkbox')
    .forEach(function (checkbox) {
        checkbox.addEventListener('change', updatePreview);
    });

    updatePreview();

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rentals/create.blade.php ENDPATH**/ ?>