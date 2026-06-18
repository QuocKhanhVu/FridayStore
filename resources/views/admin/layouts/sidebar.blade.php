<div class="sidebar">

    <div class="logo">
        KHO KỶ YẾU
    </div>

    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home me-2"></i>
        Dashboard
    </a>

    <!-- QUẢN LÝ KHO -->
    <div class="menu-group">

        <button
            type="button"
            class="sidebar-toggle"
            data-target="warehouseMenu"
        >
            <span>
                <i class="fa fa-shirt me-2"></i>
                Quản lý kho
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

    <a href="{{ route('admin.concepts.index') }}">
        <i class="fa fa-box me-2"></i>
        Quản lý Concept
    </a>

    <!-- QUẢN LÝ THUÊ ĐỒ -->
    <div class="menu-group">

        <button
            type="button"
            class="sidebar-toggle"
            data-target="rentalMenu"
        >
            <span>
                <i class="fa fa-shirt me-2"></i>
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

    <a href="{{ route('admin.revenues.index') }}">
        <i class="fa fa-money-bill me-2"></i>
        Doanh thu
    </a>

    <a href="{{ route('admin.reports.index') }}">
        <i class="fa fa-chart-column me-2"></i>
        Báo cáo
    </a>

</div>

<style>
.sidebar {
    width: 260px;
    min-height: 100vh;
    background: #1e293b;
    position: fixed;
    left: 0;
    top: 0;
}

.logo {
    color: white;
    font-size: 22px;
    font-weight: 700;
    padding: 25px;
    border-bottom: 1px solid rgba(255, 255, 255, .1);
}

.sidebar a,
.sidebar-toggle {
    color: #cbd5e1;
    text-decoration: none;
    display: block;
    width: 100%;
    padding: 14px 25px;
    background: transparent;
    border: 0;
    text-align: left;
    cursor: pointer;
}

.sidebar a:hover,
.sidebar-toggle:hover {
    background: #334155;
    color: white;
}

.sidebar-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sidebar-toggle .arrow {
    transition: transform .2s ease;
}

.sidebar-toggle.active .arrow {
    transform: rotate(180deg);
}

.sidebar-submenu {
    display: none;
    background: #16202f;
}

.sidebar-submenu.show {
    display: block;
}

.submenu {
    padding-left: 55px !important;
    font-size: 14px;
    color: #94a3b8 !important;
}

.submenu:hover {
    color: white !important;
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