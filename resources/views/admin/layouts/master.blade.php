<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Kho Kỷ Yếu')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>

        body{
            background:#f5f7fb;
        }

        .content{
            margin-left:260px;
            padding:30px;
        }

        .card-stat{
            border:none;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

        .stat-icon{
            font-size:30px;
        }

        .table-card{
            background:white;
            border-radius:15px;
            padding:20px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

    </style>

    @stack('styles')

</head>
<body>

@include('admin.layouts.sidebar')

<div class="content">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>