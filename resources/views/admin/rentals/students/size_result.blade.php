@extends('admin.layouts.master')

@section('title', 'Kết quả chia size')

@section('content')

<div class="container-fluid">

    @php
        $costumes = collect();

        if ($rental->concept) {
            $costumes = $costumes->merge(
                $rental->concept->costumes
            );
        }

        if ($rental->secondConcept) {
            $costumes = $costumes->merge(
                $rental->secondConcept->costumes
            );
        }

        if ($rental->extraCostumes && $rental->extraCostumes->count()) {
            $costumes = $costumes->merge(
                $rental->extraCostumes
            );
        }

        $costumes = $costumes
            ->unique('id')
            ->filter(function ($costume) {
                return (int) $costume->has_size === 1;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Chia bảng hiển thị
        |--------------------------------------------------------------------------
        | Mỗi bảng chỉ hiển thị tối đa 2 cột trang phục.
        */
        $costumePages = $costumes->chunk(2);
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Kết quả chia size tự động
            </h3>

            <p class="text-muted mb-0">
                {{ $rental->school_name }}
                -
                {{ $rental->class_name }}
            </p>

        </div>

        <div>

            <a
                href="{{ route('admin.rentals.index') }}"
                class="btn btn-secondary"
            >
                <i class="fa fa-arrow-left"></i>
                Quay lại
            </a>

            <a
                href="{{ route('admin.rentals.students.export', $rental) }}"
                class="btn btn-success"
            >
                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel
            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif

    {{-- THÔNG TIN TRANG PHỤC --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">
                Thông tin trang phục chia size
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Concept 1:</strong>

                    <div>
                        {{ $rental->concept->name ?? 'Không có' }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Concept 2:</strong>

                    <div>
                        {{ $rental->secondConcept->name ?? 'Không sử dụng' }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Trang phục thêm:</strong>

                    <div>
                       @if($rental->extraCostumes && $rental->extraCostumes->count())
                            {{ $rental->extraCostumes->pluck('name')->join(', ') }}
                        @else
                            Không sử dụng
                        @endif
                    </div>

                </div>

            </div>

            <div class="mt-2">

                <strong>Các cột size đang hiển thị:</strong>

                @forelse($costumes as $costume)

                    <span class="badge bg-primary me-1 mb-1">
                        {{ $costume->name }}
                    </span>

                @empty

                    <span class="text-danger">
                        Không có trang phục nào cần chia size
                    </span>

                @endforelse

            </div>

            @if($costumePages->count() > 1)

                <div class="mt-3 alert alert-info mb-0">

                    Có tổng cộng
                    <strong>{{ $costumes->count() }}</strong>
                    trang phục cần chia size.
                    Hệ thống đang chia thành
                    <strong>{{ $costumePages->count() }}</strong>
                    bảng, mỗi bảng tối đa 2 trang phục.

                </div>

            @endif

        </div>

    </div>

    {{-- DANH SÁCH SIZE ĐÃ CHIA --}}
@if($costumePages->count() > 0)

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-0 fw-bold">
                    Danh sách size đã chia
                </h5>

                <small class="text-muted">
                    Bấm số trang để xem từng nhóm trang phục
                </small>

            </div>

            <span class="badge bg-primary">
                {{ $costumePages->count() }} trang
            </span>

        </div>

        <div class="card-body">

            {{-- NÚT SỐ TRANG --}}
            <ul class="nav nav-pills mb-4" id="sizePageTab" role="tablist">

                @foreach($costumePages as $pageIndex => $costumeGroup)

                    <li class="nav-item me-2 mb-2" role="presentation">

                        <button
                            class="nav-link @if($pageIndex == 0) active @endif"
                            id="size-page-{{ $pageIndex }}-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#size-page-{{ $pageIndex }}"
                            type="button"
                            role="tab"
                        >
                            {{ $pageIndex + 1 }}
                        </button>

                    </li>

                @endforeach

            </ul>

            {{-- NỘI DUNG TỪNG TRANG --}}
            <div class="tab-content" id="sizePageTabContent">

                @foreach($costumePages as $pageIndex => $costumeGroup)

                    <div
                        class="tab-pane fade @if($pageIndex == 0) show active @endif"
                        id="size-page-{{ $pageIndex }}"
                        role="tabpanel"
                    >

                        <div class="mb-3 d-flex justify-content-between align-items-center">

                            <div>

                                <strong>
                                    Trang {{ $pageIndex + 1 }}
                                </strong>

                                <span class="text-muted">
                                    /
                                    {{ $costumePages->count() }}
                                </span>

                            </div>

                            <div>

                                @foreach($costumeGroup as $costume)

                                    <span class="badge bg-primary me-1">
                                        {{ $costume->name }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle mb-0 text-center">

                                <thead class="table-light">

                                    <tr>

                                        <th width="60">
                                            STT
                                        </th>

                                        <th class="text-start">
                                            Họ tên
                                        </th>

                                        <th width="100">
                                            Giới tính
                                        </th>

                                        <th width="100">
                                            Cao
                                        </th>

                                        <th width="100">
                                            Nặng
                                        </th>

                                        @foreach($costumeGroup as $costume)

                                            <th>
                                                {{ $costume->name }}
                                            </th>

                                        @endforeach

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($students as $student)

                                        <tr>

                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="text-start fw-semibold">
                                                {{ $student->full_name }}
                                            </td>

                                            <td>
                                                @if($student->gender == 'female')
                                                    <span class="badge bg-danger">
                                                        Nữ
                                                    </span>
                                                @else
                                                    <span class="badge bg-primary">
                                                        Nam
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $student->height }}
                                            </td>

                                            <td>
                                                {{ $student->weight }}
                                            </td>

                                            @foreach($costumeGroup as $costume)

                                                @php
                                                    $studentSize = $student
                                                        ->sizes
                                                        ->where('costume_id', $costume->id)
                                                        ->first();
                                                @endphp

                                                <td>

                                                    @if($studentSize)

                                                        <select
                                                            class="form-select form-select-sm size-select"
                                                            data-id="{{ $studentSize->id }}"
                                                        >

                                                            <option
                                                                value="0"
                                                                @selected(empty($studentSize->costume_size_id))
                                                            >
                                                                0 - Không thuê
                                                            </option>

                                                            @foreach($costume->sizes as $size)

                                                                <option
                                                                    value="{{ $size->id }}"
                                                                    @selected($studentSize->costume_size_id == $size->id)
                                                                >
                                                                    {{ $size->size_name }}
                                                                </option>

                                                            @endforeach

                                                        </select>

                                                    @else

                                                        @if($costume->gender !== 'unisex' && $costume->gender !== $student->gender)

                                                            <span class="badge bg-secondary">
                                                                Không thuê
                                                            </span>

                                                        @else

                                                            <span class="badge bg-danger">
                                                                Chưa chia
                                                            </span>

                                                        @endif

                                                    @endif

                                                </td>

                                            @endforeach

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="{{ 5 + $costumeGroup->count() }}"
                                                class="text-center text-muted py-4"
                                            >
                                                Chưa có dữ liệu học sinh
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@else

    <div class="card border-0 shadow-sm">

        <div class="card-body text-center text-muted py-5">
            Không có trang phục nào cần chia size
        </div>

    </div>

@endif

</div>

{{-- TOAST --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3">

    <div id="successToast" class="toast">

        <div class="toast-header">

            <strong class="me-auto">
                Thông báo
            </strong>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
            ></button>

        </div>

        <div class="toast-body">
            Cập nhật size thành công
        </div>

    </div>

</div>

<style>

.table th {
    white-space: nowrap;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.card {
    border-radius: 16px;
}

.size-select {
    min-width: 120px;
}
#sizePageTab .nav-link {
    min-width: 44px;
    font-weight: 600;
    border-radius: 10px;
}

#sizePageTab .nav-link.active {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}
</style>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.size-select').forEach(function (select) {

        select.addEventListener('change', function () {

            let id = this.dataset.id;
            let sizeId = this.value;

            fetch(`/admin/rental-student-sizes/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    costume_size_id: sizeId
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {

                    new bootstrap.Toast(
                        document.getElementById('successToast')
                    ).show();

                }

            });

        });

    });

});
</script>

@endpush