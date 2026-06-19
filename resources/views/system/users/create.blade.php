<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cấp tài khoản kho</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        Cấp tài khoản kho
                    </h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('system.users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Tên kho / khách hàng
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Email đăng nhập
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Mật khẩu ban đầu
                            </label>

                            <input
                                type="text"
                                name="password"
                                value="{{ old('password') }}"
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
                                value="{{ old('paid_until') }}"
                                class="form-control"
                            >

                            <small class="text-muted">
                                Bỏ trống nếu không giới hạn thời gian.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a
                                href="{{ route('system.users.index') }}"
                                class="btn btn-secondary"
                            >
                                Quay lại
                            </a>

                            <button class="btn btn-primary">
                                Tạo tài khoản
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>