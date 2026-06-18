

<?php $__env->startSection('title','Đơn đang thuê'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

<div class="row mb-4">

    <div class="col-md-6">

        <h2 class="fw-bold">
            Theo Dõi Đơn Hàng
        </h2>

        <p class="text-muted mb-0">
            Theo dõi tình trạng thuê đồ
        </p>

    </div>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-3">

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            Tất cả
                        </option>

                        <option value="renting">
                            Đang thuê
                        </option>

                        <option value="processing">
                            Đang xử lý
                        </option>

                        <option value="completed">
                            Hoàn thành
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary"
                    >
                        Lọc
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="row">

    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <div class="col-lg-4 mb-4">

            <div
                class="card border-0 shadow-sm h-100 rental-card"
            >

                <div class="card-body">

                   
                    <div class="d-flex justify-content-between align-items-start flex-wrap">

                        <div class="flex-grow-1 me-2">

                            <h5 class="fw-bold text-primary mb-1 rental-code">
                               Mã đơn: <?php echo e($item->code); ?>

                            </h5>

                        </div>

                        <div class="status-wrapper">

                            <?php if($item->status == 'renting'): ?>

                                <span class="status-badge status-renting">
                                    Đang thuê
                                </span>

                            <?php elseif($item->status == 'processing'): ?>

                                <span class="status-badge status-processing">
                                    Đang xử lý
                                </span>

                            <?php elseif($item->status == 'completed'): ?>

                                <span class="status-badge status-completed">
                                    Hoàn thành
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                    <hr>



                    

                    <h6 class="fw-bold">

                        <?php echo e($item->school_name); ?>


                    </h6>

                    <p class="mb-2">

                        Lớp:

                        <strong>

                            <?php echo e($item->class_name); ?>


                        </strong>

                    </p>

                    <p class="mb-2">

                        Studio:

                        <strong>

                            <?php echo e($item->studio->name); ?>


                        </strong>

                    </p>

                    <p class="mb-2">

                        Concept:

                        <strong>

                            <?php echo e($item->concept->name); ?>


                        </strong>

                    </p>

                    <div
                        class="
                            d-flex
                            justify-content-between
                            mt-3
                        "
                    >

                        <span>

                            👨‍🎓

                            <?php echo e($item->students_count); ?>


                            HS

                        </span>

                        <span>

                            📸

                            <?php echo e(\Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y')); ?>


                        </span>

                    </div>

                    <?php if(
                        $item->status == 'processing'
                        &&
                        $item->processing_note
                    ): ?>

                        <div
                            class="
                                alert
                                alert-danger
                                mt-3
                                mb-0
                            "
                        >

                            <strong>

                                Lý do:

                            </strong>

                            <br>

                            <?php echo e($item->processing_note); ?>


                        </div>

                    <?php endif; ?>

                </div>

                <div
                    class="
                        card-footer
                        bg-white
                        border-0
                    "
                >

                    <button
                        class="
                            btn
                            btn-primary
                            btn-sm
                        "
                        data-bs-toggle="modal"
                        data-bs-target="#statusModal<?php echo e($item->id); ?>"
                    >

                        Cập nhật trạng thái

                    </button>

                </div>

            </div>

        </div>

        <?php echo $__env->make(
            'admin.rental-management.modal',
            ['item' => $item]
        , array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div
            class="
                col-12
                text-center
                py-5
            "
        >

            <h5
                class="text-muted"
            >
                Không có đơn thuê
            </h5>

        </div>

    <?php endif; ?>

</div>

<div class="mt-3">

    <?php echo e($data->links()); ?>


</div>

</div>

<style>

.rental-card{
    border-radius:18px;
    transition:.25s;
    overflow:hidden;
}

.rental-card:hover{
    transform:translateY(-5px);
    box-shadow:
        0 12px 25px
        rgba(0,0,0,.1)
        !important;
}

.rental-code{
    word-break:break-word;
    line-height:1.4;
}

.status-wrapper{
    flex-shrink:0;
}

.status-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:120px;

    padding:8px 14px;

    border-radius:30px;

    font-size:13px;
    font-weight:600;

    white-space:nowrap;
}

.status-renting{
    background:#fff3cd;
    color:#856404;
}

.status-processing{
    background:#f8d7da;
    color:#842029;
}

.status-completed{
    background:#d1e7dd;
    color:#0f5132;
}

.card-body{
    overflow:hidden;
}

@media(max-width:576px){

    .status-wrapper{
        width:100%;
        margin-top:10px;
    }

    .status-badge{
        width:100%;
    }

}


</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\khanh\Downloads\FridayStore_fixed\FridayStore\resources\views/admin/rental-management/index.blade.php ENDPATH**/ ?>