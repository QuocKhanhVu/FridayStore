<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản kho</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Quản lý tài khoản kho</h3>
            <p class="text-muted mb-0">
                Admin chỉ cấp tài khoản, khóa tài khoản và đặt lại mật khẩu.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('system.users.create') }}" class="btn btn-primary">
                + Cấp tài khoản kho
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên kho</th>
                        <th>Email</th>
                        <th>Hạn sử dụng</th>
                        <th>Trạng thái</th>
                        <th width="250">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ $user->paid_until ? $user->paid_until->format('d/m/Y') : 'Không giới hạn' }}
                            </td>
                            <td>
                                @if ($user->is_active)
                                    <span class="badge bg-success">Đang hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Đã khóa</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a
                                        href="{{ route('system.users.edit', $user) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Sửa
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('system.users.toggle', $user) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-sm btn-secondary">
                                            {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Chưa có tài khoản kho nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>

</div>

</body>
</html>