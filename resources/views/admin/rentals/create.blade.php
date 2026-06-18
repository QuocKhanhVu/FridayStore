@extends('admin.layouts.master')

@section('title', 'Tạo đơn thuê')

@section('content')

<div class="container-fluid">

    <form
        action="{{ route('admin.rentals.store') }}"
        method="POST"
    >
        @csrf

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h4 class="mb-0 fw-bold">
                    Tạo đơn thuê
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <h5 class="fw-bold text-primary mb-3">
                        Thông tin lớp
                    </h5>

                    {{-- Studio --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Studio
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="studio_id"
                            class="form-select @error('studio_id') is-invalid @enderror"
                        >

                            <option value="">
                                -- Chọn Studio --
                            </option>

                            @foreach($studios as $studio)

                                <option
                                    value="{{ $studio->id }}"
                                    {{ old('studio_id') == $studio->id ? 'selected' : '' }}
                                >
                                    {{ $studio->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('studio_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Trường --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Tên trường
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="school_name"
                            value="{{ old('school_name') }}"
                            class="form-control @error('school_name') is-invalid @enderror"
                            placeholder="VD: THPT Mạc Đĩnh Chi"
                        >

                        @error('school_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Lớp --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Tên lớp
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="class_name"
                            value="{{ old('class_name') }}"
                            class="form-control @error('class_name') is-invalid @enderror"
                            placeholder="VD: 12A2"
                        >

                        @error('class_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Ngày chụp --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày chụp
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="shooting_date"
                            value="{{ old('shooting_date') }}"
                            class="form-control @error('shooting_date') is-invalid @enderror"
                        >

                        @error('shooting_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Ngày thuê --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày thuê
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="rental_date"
                            value="{{ old('rental_date') }}"
                            class="form-control @error('rental_date') is-invalid @enderror"
                        >

                        @error('rental_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Ngày trả --}}
                    <div class="col-md-2 mb-3">

                        <label class="form-label fw-bold">
                            Ngày trả
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="return_date"
                            value="{{ old('return_date') }}"
                            class="form-control @error('return_date') is-invalid @enderror"
                        >

                        @error('return_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-success mb-3">
                        Trang phục / Concept
                    </h5>

                    {{-- Concept 1 --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Concept 1
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="concept_id"
                            id="concept_id"
                            class="form-select @error('concept_id') is-invalid @enderror"
                        >

                            <option value="">
                                -- Chọn Concept 1 --
                            </option>

                            @foreach($concepts as $concept)

                                <option
                                    value="{{ $concept->id }}"
                                    {{ old('concept_id') == $concept->id ? 'selected' : '' }}
                                >
                                    {{ $concept->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('concept_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Concept 2 --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Concept 2
                        </label>

                        <select
                            name="second_concept_id"
                            id="second_concept_id"
                            class="form-select @error('second_concept_id') is-invalid @enderror"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            @foreach($concepts as $concept)

                                <option
                                    value="{{ $concept->id }}"
                                    {{ old('second_concept_id') == $concept->id ? 'selected' : '' }}
                                >
                                    {{ $concept->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('second_concept_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Trang phục thêm --}}
                    {{-- Trang phục thêm --}}
<div class="col-md-4 mb-3">

    <label class="form-label fw-bold">
        Trang phục thêm
    </label>

    <div
        class="border rounded p-3 @error('extra_costume_ids') border-danger @enderror"
        style="max-height: 180px; overflow-y: auto;"
    >

        @forelse($extraCostumes as $item)

            <div class="form-check mb-2">

                <input
                    class="form-check-input extra-costume-checkbox"
                    type="checkbox"
                    name="extra_costume_ids[]"
                    id="extra_costume_{{ $item->id }}"
                    value="{{ $item->id }}"
                    @checked(collect(old('extra_costume_ids', []))->contains($item->id))
                >

                <label
                    class="form-check-label"
                    for="extra_costume_{{ $item->id }}"
                >
                    {{ $item->name }}
                </label>

            </div>

        @empty

            <div class="text-muted">
                Không có trang phục thêm
            </div>

        @endforelse

    </div>

    <small class="text-muted">
        Có thể tích chọn nhiều trang phục thêm
    </small>

    @error('extra_costume_ids')
        <div class="text-danger small mt-1">
            {{ $message }}
        </div>
    @enderror

    @error('extra_costume_ids.*')
        <div class="text-danger small mt-1">
            {{ $message }}
        </div>
    @enderror

</div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-warning mb-3">
                        Trang phục không chia size
                    </h5>

                    {{-- Cử nhân --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Cử nhân
                        </label>

                        <select
                            name="graduation_costume_id"
                            id="graduation_id"
                            class="form-select @error('graduation_costume_id') is-invalid @enderror"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            @foreach($costumes_code_CN as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ old('graduation_costume_id') == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('graduation_costume_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Nơ nữ --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Nơ nữ
                        </label>

                        <select
                            name="female_accessory_id"
                            id="female_accessory_id"
                            class="form-select @error('female_accessory_id') is-invalid @enderror"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            @foreach($costumes_code_NO as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ old('female_accessory_id') == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('female_accessory_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Cà vạt nam --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Cà vạt nam
                        </label>

                        <select
                            name="male_accessory_id"
                            id="male_accessory_id"
                            class="form-select @error('male_accessory_id') is-invalid @enderror"
                        >

                            <option value="">
                                Không sử dụng
                            </option>

                            @foreach($costumes_code_CV as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ old('male_accessory_id') == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('male_accessory_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Ghi chú --}}
                    <div class="col-md-12 mt-2">

                        <label class="form-label fw-bold">
                            Ghi chú
                        </label>

                        <textarea
                            name="note"
                            rows="4"
                            class="form-control"
                            placeholder="Nhập ghi chú nếu có..."
                        >{{ old('note') }}</textarea>

                    </div>

                    {{-- Preview --}}
                    <div class="col-md-12 mt-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-header bg-primary text-white fw-bold">
                                Trang phục sẽ sử dụng
                            </div>

                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-3">

                                        <strong>Concept 1</strong>

                                        <div id="previewConcept">
                                            Chưa chọn
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Concept 2</strong>

                                        <div id="previewSecondConcept">
                                            Không sử dụng
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Trang phục thêm</strong>

                                        <div id="previewExtraCostume">
                                            Không sử dụng
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <strong>Không chia size</strong>

                                        <div id="previewNoSize">
                                            Không sử dụng
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

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
                    Lưu đơn thuê
                </button>

            </div>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function selectedText(id, emptyText = 'Không sử dụng') {
        const select = document.getElementById(id);

        if (!select || !select.value) {
            return emptyText;
        }

        return select.options[select.selectedIndex].text.trim();
    }

    function updatePreview() {
        document.getElementById('previewConcept').innerText =
            selectedText('concept_id', 'Chưa chọn');

        document.getElementById('previewSecondConcept').innerText =
            selectedText('second_concept_id', 'Không sử dụng');

        const extraSelect = document.getElementById('extra_costume_ids');

        let extraNames = [];

        if (extraSelect) {
            extraNames = Array.from(extraSelect.selectedOptions)
                .map(option => option.text.trim());
        }

        document.getElementById('previewExtraCostume').innerText =
            extraNames.length ? extraNames.join(', ') : 'Không sử dụng';

        let noSize = [];

        const graduation = selectedText('graduation_id', '');
        const femaleAccessory = selectedText('female_accessory_id', '');
        const maleAccessory = selectedText('male_accessory_id', '');

        if (graduation) {
            noSize.push(graduation);
        }

        if (femaleAccessory) {
            noSize.push(femaleAccessory);
        }

        if (maleAccessory) {
            noSize.push(maleAccessory);
        }

        let extraNames = [];

document
    .querySelectorAll('.extra-costume-checkbox:checked')
    .forEach(function (checkbox) {
        let label = document.querySelector(
            'label[for="' + checkbox.id + '"]'
        );

        if (label) {
            extraNames.push(label.innerText.trim());
        }
    });

    let extraNames = [];

        document
            .querySelectorAll('.extra-costume-checkbox:checked')
            .forEach(function (checkbox) {
                let label = document.querySelector(
                    'label[for="' + checkbox.id + '"]'
                );

                if (label) {
                    extraNames.push(label.innerText.trim());
                }
            });

        document.getElementById('previewExtraCostume').innerText =
            extraNames.length ? extraNames.join(', ') : 'Không sử dụng';
    }

    [
    'concept_id',
    'second_concept_id',
    'graduation_id',
    'female_accessory_id',
    'male_accessory_id'
].forEach(function (id) {
    const element = document.getElementById(id);

    if (element) {
        element.addEventListener('change', updatePreview);
    }
});

document
    .querySelectorAll('.extra-costume-checkbox')
    .forEach(function (checkbox) {
        checkbox.addEventListener('change', updatePreview);
    });

    updatePreview();

});
</script>

@endsection