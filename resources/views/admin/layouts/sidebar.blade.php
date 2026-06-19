@php
    /** @var \App\Models\User|null $currentUser */
    $currentUser = auth()->user();

    $warehouseName = $currentUser?->name ?? 'Kho kỷ yếu';
    $representative = $currentUser?->representative_name
        ?? $currentUser?->email
        ?? 'Chưa có người đại diện';

    $isActive = $currentUser?->is_active ?? false;
    $paidUntil = $currentUser?->paid_until;
    $isExpired = $paidUntil && now()->greaterThan($paidUntil);
@endphp

<div class="sidebar">

    <div class="sidebar-header">
        <div class="brand-title">
            KHO KỶ YẾU
        </div>

        <div class="warehouse-box">
            <div class="warehouse-name">
                {{ $warehouseName }}
            </div>

            <div class="warehouse-owner">
                {{ $representative }}
            </div>

            <div class="warehouse-status">
                @if (! $isActive)
                    <span class="badge-status danger">
                        Đã khóa
                    </span>
                @elseif ($isExpired)
                    <span class="badge-status warning">
                        Hết hạn
                    </span>
                @elseif ($paidUntil)
                    <span class="badge-status success">
                        Hạn: {{ $paidUntil->format('d/m/Y') }}
                    </span>
                @else
                    <span class="badge-status success">
                        Đang hoạt động
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="sidebar-menu">

        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <i class="fa fa-home me-2"></i>
            Dashboard
        </a>

        <div class="menu-title">
            Quản lý kho
        </div>

        <div class="menu-group">
            <button
                type="button"
                class="sidebar-toggle"
                data-target="warehouseMenu"
            >
                <span>
                    <i class="fa fa-shirt me-2"></i>
                    Kho trang phục
                </span>

                <i class="fa fa-chevron-down arrow"></i>
            </button>

            <div class="sidebar-submenu" id="warehouseMenu">

                <a href="{{ route('admin.inventory.index') }}" class="submenu">
                    Tổng quan
                </a>

                <a href="{{ route('admin.costumes.index') }}" class="submenu">
                    Danh mục trang phục
                </a>

                <a href="{{ route('admin.sizes.index') }}" class="submenu">
                    Quản lý Size
                </a>

                <a href="{{ route('admin.inventory.create') }}" class="submenu">
                    Nhập kho
                </a>

                <a href="{{ route('admin.inventory.damage.create') }}" class="submenu">
                    Báo hỏng / mất
                </a>

            </div>
        </div>

        <a href="{{ route('admin.concepts.index') }}" class="sidebar-link">
            <i class="fa fa-box me-2"></i>
            Quản lý Concept
        </a>

        <div class="menu-title">
            Thuê đồ
        </div>

        <div class="menu-group">
            <button
                type="button"
                class="sidebar-toggle"
                data-target="rentalMenu"
            >
                <span>
                    <i class="fa fa-bag-shopping me-2"></i>
                    Quản lý thuê đồ
                </span>

                <i class="fa fa-chevron-down arrow"></i>
            </button>

            <div class="sidebar-submenu" id="rentalMenu">

                <a href="{{ route('admin.studios.index') }}" class="submenu">
                    Khách thuê
                </a>

                <a href="{{ route('admin.rentals.index') }}" class="submenu">
                    Tạo đơn thuê
                </a>

                <a href="{{ route('admin.rental-management.index') }}" class="submenu">
                    Quản lý đơn thuê
                </a>

                <a href="{{ route('admin.rental-history.history') }}" class="submenu">
                    Lịch sử thuê
                </a>

            </div>
        </div>

        <div class="menu-title">
            Báo cáo
        </div>

        <a href="{{ route('admin.revenues.index') }}" class="sidebar-link">
            <i class="fa fa-money-bill me-2"></i>
            Doanh thu
        </a>

        <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
            <i class="fa fa-chart-column me-2"></i>
            Báo cáo
        </a>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf

            <button class="logout-btn">
                <i class="fa fa-right-from-bracket me-2"></i>
                Đăng xuất
            </button>
        </form>

    </div>
</div>

<style>
.sidebar {
    width: 260px;
    height: 100vh;
    background: #1e293b;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
    overflow-x: hidden;
    border-right: 1px solid rgba(255, 255, 255, .08);
}

/* Thanh lướt nhỏ gọn */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #1e293b;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #475569;
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}

.sidebar-header {
    padding: 22px 18px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, .08);
}

.brand-title {
    color: #ffffff;
    font-size: 21px;
    font-weight: 800;
    margin-bottom: 14px;
}

.warehouse-box {
    background: #263449;
    border-radius: 12px;
    padding: 12px;
}

.warehouse-name {
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.3;
    word-break: break-word;
}

.warehouse-owner {
    color: #cbd5e1;
    font-size: 12px;
    margin-top: 5px;
    word-break: break-word;
}

.warehouse-status {
    margin-top: 9px;
}

.badge-status {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 999px;
}

.badge-status.success {
    color: #bbf7d0;
    background: rgba(34, 197, 94, .15);
}

.badge-status.warning {
    color: #fde68a;
    background: rgba(245, 158, 11, .15);
}

.badge-status.danger {
    color: #fecaca;
    background: rgba(239, 68, 68, .15);
}

.sidebar-menu {
    padding: 12px 0 24px;
}

.menu-title {
    color: #94a3b8;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 16px 24px 6px;
    letter-spacing: .5px;
}

.sidebar-link,
.sidebar-toggle {
    color: #cbd5e1;
    text-decoration: none;
    width: calc(100% - 20px);
    margin: 3px 10px;
    padding: 12px 14px;
    border-radius: 9px;
    background: transparent;
    border: 0;
    display: flex;
    align-items: center;
    text-align: left;
    font-size: 14.5px;
    cursor: pointer;
}

.sidebar-link {
    display: block;
}

.sidebar-toggle {
    justify-content: space-between;
}

.sidebar-link:hover,
.sidebar-toggle:hover {
    background: #334155;
    color: #ffffff;
}

.sidebar-toggle .arrow {
    font-size: 12px;
    transition: transform .2s ease;
}

.sidebar-toggle.active .arrow {
    transform: rotate(180deg);
}

.sidebar-submenu {
    display: none;
    margin: 2px 10px 6px;
    padding: 5px 0;
    background: #16202f;
    border-radius: 9px;
}

.sidebar-submenu.show {
    display: block;
}

.submenu {
    display: block;
    color: #94a3b8 !important;
    text-decoration: none;
    padding: 10px 16px 10px 38px;
    font-size: 14px;
}

.submenu:hover {
    background: #243247;
    color: #ffffff !important;
}

.logout-form {
    padding: 18px 10px 0;
}

.logout-btn {
    width: 100%;
    border: 1px solid rgba(239, 68, 68, .35);
    background: transparent;
    color: #fecaca;
    border-radius: 9px;
    padding: 11px 14px;
    text-align: left;
    font-size: 14.5px;
    font-weight: 600;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, .12);
    color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.sidebar-toggle');

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const menu = document.getElementById(targetId);

            if (!menu) {
                return;
            }

            menu.classList.toggle('show');
            this.classList.toggle('active');
        });
    });
});
</script>