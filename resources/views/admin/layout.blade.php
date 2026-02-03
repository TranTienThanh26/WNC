<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TTDFood</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #FFCA40; /* Màu vàng từ user side */
            --dark: #1e293b;
            --light: #f3f4f6;
            --sidebar-width: 250px;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; }
        
        body { display: flex; background: var(--light); min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: #fff;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
        }

        .brand {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: var(--primary);
            border-bottom: 1px solid #334155;
            text-decoration: none;
        }

        .menu { list-style: none; padding: 20px 0; }
        .menu li a {
            display: block;
            padding: 15px 25px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }
        .menu li a:hover, .menu li a.active {
            background: #334155;
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }
        .menu li a i { width: 25px; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            height: 60px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .user-info span { font-weight: 600; margin-right: 15px; }
        .btn-logout {
            color: #ef4444;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        /* PAGE CONTENT */
        .page-content { padding: 30px; }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .page-title { font-size: 24px; color: var(--dark); }

        /* CARDS */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-right: 20px;
        }
        .bg-blue { background: #e0f2fe; color: #0284c7; }
        .bg-green { background: #dcfce7; color: #16a34a; }
        .bg-orange { background: #ffedd5; color: #ea580c; }
        .bg-red { background: #fee2e2; color: #dc2626; }

        .card-info h3 { font-size: 28px; margin-bottom: 5px; }
        .card-info p { color: #64748b; font-size: 14px; }

        /* TABLES */
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-top: 20px;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { font-weight: 600; color: #475569; background: #f8fafc; }
        tr:last-child td { border-bottom: none; }
        
        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            cursor: pointer;
            border: none;
        }
        .btn-primary { background: var(--primary); color: #000; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-success { background: #22c55e; color: #fff; }
        .btn-info { background: #3b82f6; color: #fff; }

        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-pending { background: #ffedd5; color: #c2410c; }
        .badge-shipping { background: #e0f2fe; color: #0369a1; }
        .badge-completed { background: #dcfce7; color: #15803d; }
        .badge-cancelled { background: #fee2e2; color: #b91c1c; }

        /* FORMS */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
        }
        .form-control:focus { border-color: var(--primary); }

        /* PAGINATION STYLING */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 5px;
            margin-top: 20px;
        }
        .pagination li {
            display: inline-block;
        }
        .pagination li a, .pagination li span {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            text-decoration: none;
            color: #334155;
            background: #fff;
            font-size: 14px;
        }
        .pagination li.active span {
            background: var(--primary);
            color: #000;
            border-color: var(--primary);
        }
        .pagination li.disabled span {
            color: #94a3b8;
            cursor: not-allowed;
        }
        .pagination li a:hover {
            background: #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">TTDFood Admin</a>
        <ul class="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Tổng quan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.foods.index') }}" class="{{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils"></i> Quản lý món ăn
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Xem Website
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <h3>@yield('title', 'Dashboard')</h3>
            
            <div class="user-info">
                <span>👤 {{ auth()->user()->name ?? 'Admin' }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; cursor:pointer;" class="btn-logout">
                        Đăng xuất <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            @if(session('success'))
                <div style="background:#dcfce7; color:#15803d; padding:15px; border-radius:8px; margin-bottom:20px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
