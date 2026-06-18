@extends('admin.layouts.master')

@section('title','Studio thuê đồ')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Studio thuê đồ
            </h3>

            <p class="text-muted mb-0">
                Quản lý đối tác thuê trang phục
            </p>

        </div>

        <a
            href="{{ route('admin.studios.create') }}"
            class="btn btn-primary"
        >
            <i class="fa fa-plus me-2"></i>
            Thêm Studio
        </a>

    </div>

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
                            placeholder="Tên studio hoặc SĐT"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary"
                        >
                            Tìm kiếm
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <table
                class="table table-hover mb-0"
            >

                <thead class="table-light">

                    <tr>

                        <th>#</th>

                        <th>Tên Studio</th>

                        <th>Người đại diện</th>

                        <th>SĐT</th>

                        <th>Địa chỉ</th>

                        <th>Trạng thái</th>

                        <th width="120">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                    <tr>

                        <td>
                            {{ $item->id }}
                        </td>

                        <td>
                            {{ $item->name }}
                        </td>

                        <td>
                            {{ $item->contact_person }}
                        </td>

                        <td>
                            {{ $item->phone }}
                        </td>

                        <td>
                            {{ $item->address }}
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
                                href="{{ route('admin.studios.edit',$item->id) }}"
                                class="btn btn-warning btn-sm"
                            >
                                <i class="fa fa-pen"></i>
                            </a>

                            <form
                                action="{{ route('admin.studios.destroy',$item->id) }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa studio này?')"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center"
                        >

                            Không có dữ liệu

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">

            {{ $data->links() }}

        </div>

    </div>

</div>

@endsection