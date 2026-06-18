@extends('admin.layouts.master')

@section('title','Chi tiết đơn thuê')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Chi tiết đơn thuê
            </h2>

            <p class="text-muted mb-0">
                {{ $rental->code }}
            </p>

        </div>

        <div>

            <a
                href="{{ route('admin.rentals.students.export', $rental) }}"
                class="btn btn-success"
            >
                <i class="fa fa-file-excel me-2"></i>
                Xuất Excel
            </a>

            <a
                href="{{ route('admin.rental-history.history') }}"
                class="btn btn-secondary"
            >
                <i class="fa fa-arrow-left me-2"></i>
                Quay lại
            </a>

        </div>

    </div>

    {{-- THÔNG TIN ĐƠN THUÊ --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Thông tin đơn thuê
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Mã đơn
                    </label>

                    <div>
                        {{ $rental->code }}
                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Studio
                    </label>

                    <div>
                        {{ $rental->studio->name ?? '---' }}
                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Concept
                    </label>

                    <div>
                        {{ $rental->concept->name ?? '---' }}
                    </div>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="fw-bold">
                        Trạng thái
                    </label>

                    <div>

                        <span
                            class="
                                badge
                                bg-success
                                px-3
                                py-2
                            "
                        >
                            Hoàn thành
                        </span>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Trường
                    </label>

                    <div>
                        {{ $rental->school_name }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Lớp
                    </label>

                    <div>
                        {{ $rental->class_name }}
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Sĩ số
                    </label>

                    <div>
                        {{ $rental->students->count() }} học sinh
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày chụp
                    </label>

                    <div>

                        {{ $rental->shooting_date
                            ? \Carbon\Carbon::parse($rental->shooting_date)->format('d/m/Y')
                            : '---'
                        }}

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày thuê
                    </label>

                    <div>

                        {{ $rental->rental_date
                            ? \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y')
                            : '---'
                        }}

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-bold">
                        Ngày trả
                    </label>

                    <div>

                        {{ $rental->return_date
                            ? \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y')
                            : '---'
                        }}

                    </div>

                </div>

                @if($rental->note)

                    <div class="col-12">

                        <label class="fw-bold">
                            Ghi chú
                        </label>

                        <div>

                            {{ $rental->note }}

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

    {{-- DANH SÁCH HỌC SINH --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">
                Danh sách học sinh
            </h5>

        </div>

        <div class="table-responsive">

            <table
                class="
                    table
                    table-bordered
                    table-hover
                    mb-0
                "
            >

                <thead>

                    <tr>

                        <th width="60">
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

                    @forelse($rental->students as $key => $student)

                        <tr>

                            <td>

                                {{ $key + 1 }}

                            </td>

                            <td>

                                {{ $student->full_name }}

                            </td>

                            <td>

                                {{ $student->gender }}

                            </td>

                            <td>

                                {{ $student->height }}

                            </td>

                            <td>

                                {{ $student->weight }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center"
                            >

                                Không có dữ liệu

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    

@endsection