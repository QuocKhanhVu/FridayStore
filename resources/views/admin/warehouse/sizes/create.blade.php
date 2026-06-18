@extends('admin.layouts.master')

@section('title','Cấu hình Size')

@section('content')

<div class="container-fluid">
@if ($errors->any())

<div class="alert alert-danger alert-dismissible fade show">

    <strong>
        <i class="fa fa-circle-exclamation me-2"></i>
        Có lỗi xảy ra:
    </strong>

    <ul class="mb-0 mt-2">

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif
    <form
        action="{{ route('admin.sizes.store') }}"
        method="POST"
    >

        @csrf

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0">

                    Cấu hình Size

                </h4>

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <label class="form-label">

                        Trang phục

                    </label>

                    <select
                        name="costume_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Chọn trang phục
                        </option>

                        @foreach($costumes as $costume)

                            <option value="{{ $costume->id }}">

                                {{ $costume->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="table-responsive">

                    <table
                        class="table table-bordered"
                        id="sizeTable"
                    >

                        <thead>

                            <tr>

                                <th width="120">
                                    Size
                                </th>

                                <th>
                                    Cao từ
                                </th>

                                <th>
                                    Cao đến
                                </th>

                                <th>
                                    Nặng từ
                                </th>

                                <th>
                                    Nặng đến
                                </th>

                                <th width="80">

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="sizes[0][size_name]"
                                        class="form-control"
                                        required
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[0][height_from]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[0][height_to]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[0][weight_from]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[0][weight_to]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="btn btn-danger removeRow"
                                    >

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <button
                    type="button"
                    id="addRow"
                    class="btn btn-outline-primary"
                >

                    <i class="fa fa-plus me-2"></i>

                    Thêm dòng

                </button>

            </div>

            <div class="card-footer bg-white text-end">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fa fa-save me-2"></i>

                    Lưu tất cả

                </button>
                <a
                    href="{{ route('admin.sizes.index') }}"
                    class="btn btn-light border shadow-sm"
                >
                    <i class="fa fa-arrow-left me-2"></i>
                    Quay lại danh sách
                </a>
            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

let index = 1;

$('#addRow').click(function(){

    $('#sizeTable tbody').append(`

        <tr>

            <td>
                <input
                    type="text"
                    name="sizes[${index}][size_name]"
                    class="form-control"
                    required
                >
            </td>

            <td>
                <input
                    type="number"
                    name="sizes[${index}][height_from]"
                    class="form-control"
                >
            </td>

            <td>
                <input
                    type="number"
                    name="sizes[${index}][height_to]"
                    class="form-control"
                >
            </td>

            <td>
                <input
                    type="number"
                    name="sizes[${index}][weight_from]"
                    class="form-control"
                >
            </td>

            <td>
                <input
                    type="number"
                    name="sizes[${index}][weight_to]"
                    class="form-control"
                >
            </td>

            <td>
                <button
                    type="button"
                    class="btn btn-danger removeRow"
                >
                    <i class="fa fa-trash"></i>
                </button>
            </td>

        </tr>

    `);

    index++;

});

$(document).on(
    'click',
    '.removeRow',
    function(){

        $(this).closest('tr').remove();

    }
);

</script>

@endpush