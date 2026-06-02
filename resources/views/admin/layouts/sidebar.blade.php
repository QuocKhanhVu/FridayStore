<div class="sidebar">

    <div class="logo">
        KHO KỶ YẾU
    </div>

    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home me-2"></i>
        Dashboard
    </a>

    <div class="menu-group">

        <a
            data-bs-toggle="collapse"
            href="#warehouseMenu"
            role="button"
            aria-expanded="false"
        >
            <i class="fa fa-shirt me-2"></i>
            Quản lý kho
            <i class="fa fa-chevron-down float-end mt-1"></i>
        </a>

        <div class="collapse" id="warehouseMenu">

            <a
                href="#"
                class="submenu"
            >
                Danh mục trang phục
            </a>

            <a
                href="#"
                class="submenu"
            >
                Quản lý Size
            </a>

            <a
                href="#"
                class="submenu"
            >
                Tồn kho
            </a>

            <a
                href="#"
                class="submenu"
            >
                Nhập kho
            </a>

        </div>

    </div>

    <a href="#">
        <i class="fa fa-box me-2"></i>
        Quản lý Concept
    </a>

    <a href="#">
        <i class="fa fa-file-circle-plus me-2"></i>
        Quản lý thuê đồ
    </a>

    <a href="#">
        <i class="fa fa-money-bill me-2"></i>
        Doanh thu
    </a>

    <a href="#">
        <i class="fa fa-chart-column me-2"></i>
        Báo cáo
    </a>

</div>

<style>

.sidebar{
    width:260px;
    min-height:100vh;
    background:#1e293b;
    position:fixed;
    left:0;
    top:0;
}

.logo{
    color:white;
    font-size:22px;
    font-weight:700;
    padding:25px;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.sidebar a{
    color:#cbd5e1;
    text-decoration:none;
    display:block;
    padding:14px 25px;
}

.sidebar a:hover{
    background:#334155;
    color:white;
}
.submenu{
    padding-left:55px !important;
    font-size:14px;
    color:#94a3b8 !important;
}

.submenu:hover{
    color:white !important;
}

.menu-group .collapse{
    background:#16202f;
}
</style>