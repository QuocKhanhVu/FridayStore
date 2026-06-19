<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa tài khoản kho</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-7">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        Sửa tài khoản kho
                    </h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('system.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                Tên kho
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Hạn sử dụng
                            </label>

                            <input
                                type="date"
                                name="paid_until"
                                value="{{ old('paid_until', $user->paid_until?->format('Y-m-d')) }}"
                                class="form-control"
                            >
                        </div>

                        <div class="form-check mb-3">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                id="is_active"
                                class="form-check-input"
                                {{ $user->is_active ? 'checked' : '' }}
                            >

                            <label for="is_active" class="form-check-label">
                                Cho phép tài khoản hoạt động
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a
                                href="{{ route('system.users.index') }}"
                                class="btn btn-secondary"
                            >
                                Quay lại
                            </a>

                            <button class="btn btn-primary">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        Đặt lại mật khẩu
                    </h5>
                </div>

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('system.users.reset-password', $user) }}"
                    >
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">
                                Mật khẩu mới
                            </label>

                            <input
                                type="text"
                                name="password"
                                class="form-control"
                                required
                            >
                        </div>

                        <button class="btn btn-danger">
                            Đặt lại mật khẩu
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>