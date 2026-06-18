@extends('admin.layouts.master')

@section('title','Cập nhật Studio')

@section('content')

<div class="container-fluid">

```
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            Cập nhật Studio
        </h3>

        <p class="text-muted mb-0">
            Chỉnh sửa thông tin đối tác thuê đồ
        </p>

    </div>

    <a
        href="{{ route('admin.studios.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="fa fa-arrow-left me-2"></i>
        Quay lại
    </a>

</div>

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Vui lòng kiểm tra lại dữ liệu:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form
    action="{{ route('admin.studios.update',$studio->id) }}"
    method="POST"
>

    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Thông tin Studio
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tên Studio
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name',$studio->name) }}"
                                class="form-control"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Người đại diện
                            </label>

                            <input
                                type="text"
                                name="contact_person"
                                value="{{ old('contact_person',$studio->contact_person) }}"
                                class="form-control"
                            >

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Số điện thoại
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone',$studio->phone) }}"
                                class="form-control"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email',$studio->email) }}"
                                class="form-control"
                            >

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Địa chỉ
                        </label>

                        <input
                            type="text"
                            name="address"
                            value="{{ old('address',$studio->address) }}"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Ghi chú
                        </label>

                        <textarea
                            name="note"
                            rows="5"
                            class="form-control"
                        >{{ old('note',$studio->note) }}</textarea>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Trạng thái
                    </h5>

                </div>

                <div class="card-body">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            class="form-check-input"
                            {{ old('status',$studio->status) ? 'checked' : '' }}
                        >

                        <label class="form-check-label">

                            Hoạt động

                        </label>

                    </div>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-warning w-100 py-3"
            >

                <i class="fa fa-pen-to-square me-2"></i>

                Cập nhật Studio

            </button>

        </div>

    </div>

</form>
```

</div>

@endsection
