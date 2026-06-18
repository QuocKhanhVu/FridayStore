@extends('admin.layouts.master')

@section('title', 'Cập nhật đơn thuê')

@section('content')

<div class="container-fluid">

    <form
        action="{{ route('admin.rentals.update',$rental->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0">
                    Cập nhật đơn thuê
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Studio
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="studio_id"
                            class="form-select"
                        >

                            @foreach($studios as $studio)

                                <option
                                    value="{{ $studio->id }}"
                                    @selected(old('studio_id',$rental->studio_id) == $studio->id)
                                >
                                    {{ $studio->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Concept
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="concept_id"
                            class="form-select"
                        >

                            @foreach($concepts as $concept)

                                <option
                                    value="{{ $concept->id }}"
                                    @selected(old('concept_id',$rental->concept_id) == $concept->id)
                                >
                                    {{ $concept->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Trường
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="school_name"
                            value="{{ old('school_name',$rental->school_name) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Lớp
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="class_name"
                            value="{{ old('class_name',$rental->class_name) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Ngày chụp
                        </label>

                        <input
                            type="date"
                            name="shooting_date"
                            value="{{ old('shooting_date',$rental->shooting_date) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Ngày thuê
                        </label>

                        <input
                            type="date"
                            name="rental_date"
                            value="{{ old('rental_date',$rental->rental_date) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Ngày trả
                        </label>

                        <input
                            type="date"
                            name="return_date"
                            value="{{ old('return_date',$rental->return_date) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-12">

                        <label class="form-label fw-bold">
                            Ghi chú
                        </label>

                        <textarea
                            name="note"
                            rows="4"
                            class="form-control"
                        >{{ old('note',$rental->note) }}</textarea>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <a
                    href="{{ route('admin.rentals.index') }}"
                    class="btn btn-secondary"
                >
                    Quay lại
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cập nhật
                </button>

            </div>

        </div>

    </form>

</div>

@endsection