@extends('admin.layouts.master')

@section('title', 'Quản lý đơn thuê')

@section('content')

<div class="container-fluid">


<div class="row mb-4 align-items-center">

    <div class="col-md-6">

        <h2 class="fw-bold mb-1 text-dark">
            Đơn cần xử lý
        </h2>

        <p class="text-muted mb-0">
            Theo dõi và quản lý các đơn thuê trang phục
        </p>

    </div>

    <div class="col-md-6 text-md-end mt-3 mt-md-0">

        <a
            href="{{ route('admin.rentals.create') }}"
            class="btn text-white shadow-sm"
            style="
                background:#4F46E5;
                border:none;
                border-radius:12px;
            "
        >
            <i class="fa fa-plus-circle me-1"></i>
            Tạo đơn thuê
        </a>

    </div>

</div>

<div
    class="card border-0 shadow-sm"
    style="
        border-radius:18px;
    "
>

    <div
        class="card-header bg-white border-0"
    >

        <div class="row align-items-center">

            <div class="col-md-4">

                <h5 class="mb-0 fw-bold">
                    Danh sách đơn thuê
                </h5>

            </div>

            <div class="col-md-8">

                <form method="GET">

                    <div class="row g-2">

                        <div class="col-md-5">

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Tìm trường hoặc lớp..."
                                value="{{ request('keyword') }}"
                            >

                        </div>

                        <div class="col-md-4">

                            <select
                                name="status"
                                class="form-select"
                            >

                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option value="draft">
                                    Nháp
                                </option>

                                <option value="sized">
                                    Đã chia size
                                </option>

                                <option value="approved">
                                    Đã duyệt
                                </option>

                                <option value="renting">
                                    Đang thuê
                                </option>

                                <option value="returned">
                                    Đã trả
                                </option>

                            </select>

                        </div>

                        <div class="col-md-3">

                            <button
                                class="btn w-100 text-white"
                                style="
                                    background:#4F46E5;
                                    border:none;
                                "
                            >
                                Lọc dữ liệu
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="
                    table
                    align-middle
                    table-hover
                "
            >

                <thead>

                    <tr
                        style="
                            background:#4F46E5;
                            color:white;
                        "
                    >

                        <th width="60">
                            STT
                        </th>

                        <th>
                            Mã đơn
                        </th>

                        <th>
                            Studio
                        </th>

                        <th>
                            Trường
                        </th>

                        <th>
                            Lớp
                        </th>

                        <th>
                            Concept
                        </th>

                        <th width="130">
                            Học sinh
                        </th>

                        <th>
                            Ngày chụp
                        </th>

                        <th>
                            Trạng thái
                        </th>

                        <th width="260">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                    <tr>

                        <td class="text-center">

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            <span
                                class="
                                    fw-bold
                                "
                                style="
                                    color:#4F46E5;
                                "
                            >
                                {{ $item->code }}
                            </span>

                        </td>

                        <td>

                            {{ $item->studio->name }}

                        </td>

                        <td>

                            {{ $item->school_name }}

                        </td>

                        <td>

                            <span
                                class="badge"
                                style="
                                    background:#EEF2FF;
                                    color:#4F46E5;
                                "
                            >
                                {{ $item->class_name }}
                            </span>

                        </td>

                        <td>

                            {{ $item->concept->name }}

                        </td>

                        <td>

                            @if(
                                $item->students_count > 0
                            )

                                <span
                                    class="badge"
                                    style="
                                        background:#D1FAE5;
                                        color:#065F46;
                                        padding:8px 12px;
                                    "
                                >
                                    {{ $item->students_count }}
                                    HS
                                </span>

                            @else

                                <span
                                    class="badge"
                                    style="
                                        background:#F3F4F6;
                                        color:#6B7280;
                                        padding:8px 12px;
                                    "
                                >
                                    Chưa import
                                </span>

                            @endif

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y') }}

                        </td>

                        <td>

                            @switch($item->status)

                                @case('draft')

                                    <span
                                        class="badge"
                                        style="
                                            background:#E5E7EB;
                                            color:#374151;
                                        "
                                    >
                                        Nháp
                                    </span>

                                @break

                                @case('sized')

                                    <span
                                        class="badge"
                                        style="
                                            background:#CFFAFE;
                                            color:#155E75;
                                        "
                                    >
                                        Đã chia size
                                    </span>

                                @break

                                @case('approved')

                                    <span
                                        class="badge"
                                        style="
                                            background:#E0E7FF;
                                            color:#3730A3;
                                        "
                                    >
                                        Đã duyệt
                                    </span>

                                @break

                                @case('renting')

                                    <span
                                        class="badge"
                                        style="
                                            background:#FEF3C7;
                                            color:#92400E;
                                        "
                                    >
                                        Đang thuê
                                    </span>

                                @break

                                @case('returned')

                                    <span
                                        class="badge"
                                        style="
                                            background:#D1FAE5;
                                            color:#065F46;
                                        "
                                    >
                                        Đã trả
                                    </span>

                                @break

                            @endswitch

                        </td>

                        <td>

                            <div
                                class="
                                    d-flex
                                    gap-1
                                    flex-wrap
                                "
                            >

                                @if(
                                    $item->students_count == 0
                                )

                                    <a
                                        href="{{ route(
                                            'admin.rentals.students.create',
                                            $item->id
                                        ) }}"
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#10B981;
                                        "
                                    >
                                        Import
                                    </a>

                                @else

                                    <a
                                        href="{{ route(
                                            'admin.rentals.students.export',
                                            $item->id
                                        ) }}"
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#06B6D4;
                                        "
                                    >
                                        Xuất File
                                    </a>

                                @endif

                                <a
                                    href="{{ route(
                                        'admin.rentals.edit',
                                        $item->id
                                    ) }}"
                                    class="btn btn-sm text-white"
                                    style="
                                        background:#F59E0B;
                                    "
                                >
                                    Sửa
                                </a>

                                <form
                                    action="{{ route(
                                        'admin.rentals.destroy',
                                        $item->id
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xóa đơn thuê này?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm text-white"
                                        style="
                                            background:#EF4444;
                                        "
                                    >
                                        Xóa
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="10"
                            class="text-center py-5 text-muted"
                        >
                            Chưa có đơn thuê nào
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($data->hasPages())

    <div class="card-footer bg-white">

        {{ $data->links() }}

    </div>

    @endif

</div>


</div>

<style>

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#F8FAFC;
}

.badge{
    border-radius:10px;
}

.btn{
    border-radius:10px;
}

</style>

@endsection
