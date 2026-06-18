@extends('admin.layouts.master')

@section('title', 'Quản lý Concept')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Quản lý Concept
            </h3>

            <p class="text-muted mb-0">
                Quản lý concept chụp kỷ yếu
            </p>

        </div>

        <a
            href="{{ route('admin.concepts.create') }}"
            class="btn btn-primary"
        >

            <i class="fa fa-plus me-2"></i>

            Thêm Concept

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            class="form-control"
                            placeholder="Tìm tên concept..."
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100"
                        >

                            <i class="fa fa-search me-2"></i>

                            Tìm kiếm

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                Danh sách Concept

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                >

                    <thead class="table-light">

                        <tr>

                            <th width="80">
                                #
                            </th>

                            <th width="120">
                                Ảnh
                            </th>

                            <th>
                                Tên Concept
                            </th>

                            <th>
                                Số trang phục
                            </th>
                            <th>
                                Giá thuê
                            </th>
                            <th>
                                Chiết khấu
                            </th>
                            <th>
                                Trạng thái
                            </th>

                            <th width="150">
                                Thao tác
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $item)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    <img
                                        src="{{ $item->thumbnail
                                        ? asset('storage/'.$item->thumbnail)
                                        : 'https://placehold.co/80x80' }}"
                                        width="70"
                                        class="rounded border"
                                    >

                                </td>

                                <td>

                                    <strong>

                                        {{ $item->name }}

                                    </strong>

                                    @if($item->description)

                                        <div
                                            class="small text-muted"
                                        >

                                            {{ Str::limit(
                                                $item->description,
                                                60
                                            ) }}

                                        </div>

                                    @endif

                                </td>

                                <td>

                                    <span
                                        class="badge bg-info"
                                    >

                                        {{ $item->costumes_count }}

                                        trang phục

                                    </span>

                                </td>
                                <td>

                                    {{ number_format($item->price) }}

                                    VNĐ

                                </td>
                                <td>

                                    {{ $item->discount_percent}}

                                    %

                                </td>
                                <td>

                                    @if($item->status)

                                        <span
                                            class="badge bg-success"
                                        >

                                            Hoạt động

                                        </span>

                                    @else

                                        <span
                                            class="badge bg-danger"
                                        >

                                            Ngừng hoạt động

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.concepts.edit',
                                            $item->id
                                        ) }}"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i
                                            class="fa fa-pen"
                                        ></i>

                                    </a>

                                    <form
                                        action="{{ route(
                                            'admin.concepts.destroy',
                                            $item->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Bạn có chắc chắn muốn xóa?'
                                        )"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >

                                            <i
                                                class="fa fa-trash"
                                            ></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4"
                                >

                                    Không có dữ liệu

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

@endsection