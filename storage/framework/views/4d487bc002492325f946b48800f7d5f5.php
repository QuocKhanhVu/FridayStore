

<?php $__env->startSection('title','Danh sách học sinh'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            Danh sách học sinh

        </h3>

        <p class="text-muted mb-0">

            <?php echo e($rental->school_name); ?>

            -
            <?php echo e($rental->class_name); ?>


        </p>

    </div>

    <form
        action="<?php echo e(route(
            'admin.rentals.students.auto-size',
            $rental->id
        )); ?>"
        method="POST"
    >
        <?php echo csrf_field(); ?>

        <button
            class="btn btn-success"
        >
            Chia size tự động
        </button>

    </form>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <table
            class="table table-hover align-middle mb-0"
        >

            <thead class="table-light">

                <tr>

                    <th width="70">
                        STT
                    </th>

                    <th>
                        Họ tên
                    </th>

                    <th>
                        Giới tính
                    </th>

                    <th>
                        Chiều cao
                    </th>

                    <th>
                        Cân nặng
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>
                            <?php echo e($students->firstItem() + $loop->index); ?>

                        </td>

                        <td>

                            <strong>

                                <?php echo e($student->full_name); ?>


                            </strong>

                        </td>

                        <td>

                            <?php if($student->gender == 'male'): ?>

                                Nam

                            <?php elseif($student->gender == 'female'): ?>

                                Nữ

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php echo e($student->height); ?>


                            cm

                        </td>

                        <td>

                            <?php echo e($student->weight); ?>


                            kg

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-4"
                        >

                            Chưa có dữ liệu

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        <?php echo e($students->links()); ?>


    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rentals/students/index.blade.php ENDPATH**/ ?>