@extends('admin.layouts.master')

@section('title', 'Nhập kho')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Nhập kho
            </h3>

            <p class="text-muted mb-0">
                Thêm số lượng trang phục vào kho
            </p>

        </div>

        <a
            href="{{ route('admin.inventory.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa fa-arrow-left me-2"></i>
            Quay lại
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

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
        action="{{ route('admin.inventory.store') }}"
        method="POST"
    >

        @csrf

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Thông tin nhập kho

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Trang phục --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Trang phục

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="costume_id"
                            id="costume_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Chọn trang phục
                            </option>

                            @foreach($costumes as $costume)

                                <option
                                    value="{{ $costume->id }}"
                                >
                                    {{ $costume->name }}
                                </option>

                            @endforeach

                        </select>
                        @error('costume_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Size --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Size

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="costume_size_id"
                            id="size_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Chọn size
                            </option>

                        </select>
                        @error('costume_size_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="row">

                    {{-- Số lượng --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Số lượng nhập

                        </label>

                        <input
                            type="number"
                            min="1"
                            name="quantity"
                            class="form-control"
                            placeholder="Nhập số lượng"
                            required
                        >
                        @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Ghi chú

                    </label>

                    <textarea
                        name="note"
                        rows="4"
                        class="form-control"
                        placeholder="Nhập ghi chú..."
                    ></textarea>
                        @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="fa fa-box me-2"></i>

                    Nhập kho

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

const costumes = @json($costumes);

$('#costume_id').change(function(){

    let costumeId = $(this).val();

    let sizeSelect = $('#size_id');

    sizeSelect.html(
        '<option value="">Chọn size</option>'
    );

    let costume = costumes.find(
        x => x.id == costumeId
    );

    if(costume){

        costume.sizes.forEach(size => {

            sizeSelect.append(`
                <option value="${size.id}">
                    ${size.size_name}
                </option>
            `);

        });

    }

});

</script>

@endpush