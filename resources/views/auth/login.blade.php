<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            min-height: 100vh;
        }

        .login-card {
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
        }

        .login-card .card-body {
            padding: 36px 32px;
        }

        .graduate-illustration {
            width: 120px;
            height: 120px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-radius: 50%;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.15);
        }

        .login-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            border-radius: 12px;
            height: 46px;
            border: 1px solid #cbd5e1;
        }

        .form-control:focus {
            border-color: #64748b;
            box-shadow: 0 0 0 0.15rem rgba(100, 116, 139, 0.15);
        }

        .btn-login {
            height: 46px;
            border-radius: 12px;
            font-weight: 700;
            background: #1e293b;
            border: none;
        }

        .btn-login:hover {
            background: #0f172a;
        }

        .form-check-label {
            color: #475569;
            font-size: 14px;
        }

        .alert {
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 col-lg-4">

            <div class="card login-card">
                <div class="card-body">

                    <div class="graduate-illustration">
                        <svg width="88" height="88" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- mũ cử nhân -->
                            <polygon points="44,10 12,24 44,38 76,24" fill="#1e293b"/>
                            <rect x="35" y="35" width="18" height="8" rx="2" fill="#334155"/>
                            <line x1="76" y1="24" x2="76" y2="42" stroke="#1e293b" stroke-width="3"/>
                            <circle cx="76" cy="45" r="3" fill="#f59e0b"/>

                            <!-- đầu -->
                            <circle cx="44" cy="48" r="16" fill="#f2c9a0"/>

                            <!-- tóc -->
                            <path d="M29 48C29 39 36 33 44 33C52 33 59 39 59 48V50C56 45 52 43 44 43C36 43 32 45 29 50V48Z" fill="#2b2b2b"/>

                            <!-- mắt -->
                            <circle cx="38" cy="50" r="1.5" fill="#1f2937"/>
                            <circle cx="50" cy="50" r="1.5" fill="#1f2937"/>

                            <!-- miệng -->
                            <path d="M39 57C41 59 47 59 49 57" stroke="#b45309" stroke-width="2" stroke-linecap="round"/>

                            <!-- áo -->
                            <path d="M24 82C25 69 33 62 44 62C55 62 63 69 64 82" fill="#2563eb"/>
                            <path d="M38 62L44 68L50 62" fill="#ffffff"/>
                            <path d="M41 68H47L45 82H43L41 68Z" fill="#0f172a"/>
                        </svg>
                    </div>

                    <h4 class="login-title text-center mb-1">
                        Đăng nhập
                    </h4>

                    <p class="login-subtitle text-center mb-4">
                        Hệ thống quản lý kho trang phục kỷ yếu
                    </p>

                    

                    <form method="POST" action="{{ route('login.post') }}" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                autofocus
                            >

                            @error('email')
                                <div class="text-danger mt-1 small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Mật khẩu
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                            @error('password')
                                <div class="text-danger mt-1 small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                            >

                            <label class="form-check-label" for="remember">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-login w-100 text-white"
                        >
                            Đăng nhập
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>