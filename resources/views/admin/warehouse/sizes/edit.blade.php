@extends('admin.layouts.master')

@section('title','Cập nhật Size')

@section('content')

<div class="container-fluid">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

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
        action="{{ route('admin.sizes.update', $costumeSize->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0">

                    Cập nhật Size

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

                            <option
                                value="{{ $costume->id }}"
                                {{ old('costume_id', $costumeSize->costume_id) == $costume->id ? 'selected' : '' }}
                            >

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

                            @foreach($costumeSize->costume->sizes as $index => $size)

                            <tr>

                                <td>

                                    <input
                                        type="hidden"
                                        name="sizes[{{ $index }}][id]"
                                        value="{{ $size->id }}"
                                    >

                                    <input
                                        type="text"
                                        name="sizes[{{ $index }}][size_name]"
                                        value="{{ old("sizes.$index.size_name", $size->size_name) }}"
                                        class="form-control"
                                        required
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[{{ $index }}][height_from]"
                                        value="{{ old("sizes.$index.height_from", optional($size->rule)->height_from) }}"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[{{ $index }}][height_to]"
                                        value="{{ old("sizes.$index.height_to", optional($size->rule)->height_to) }}"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[{{ $index }}][weight_from]"
                                        value="{{ old("sizes.$index.weight_from", optional($size->rule)->weight_from) }}"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="sizes[{{ $index }}][weight_to]"
                                        value="{{ old("sizes.$index.weight_to", optional($size->rule)->weight_to) }}"
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

                            @endforeach

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
                    class="btn btn-warning"
                >

                    <i class="fa fa-pen-to-square me-2"></i>

                    Cập nhật

                </button>

                <a
                    href="{{ route('admin.sizes.index') }}"
                    class="btn btn-light border shadow-sm"
                >

                    <i class="fa fa-arrow-left me-2"></i>

                    Quay lại

                </a>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

let index = {{ $costumeSize->costume->sizes->count() }};

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