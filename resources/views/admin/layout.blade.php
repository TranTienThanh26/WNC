<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - TTD.Signature')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #c5a059;
            --dark: #121212;
            --light: #f8f9fa;
            --sidebar-width: 260px;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Montserrat', sans-serif; }
        
        body { background: var(--light); min-height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: #fff;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000; /* Sidebar thấp hơn Backdrop */
            transition: all 0.3s;
        }

        .brand {
            height: 70px; display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: bold; color: var(--primary);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-decoration: none; font-family: 'Cormorant Garamond', serif; letter-spacing: 2px;
        }

        .menu { list-style: none; padding: 20px 0; }
        .menu li a {
            display: block; padding: 12px 25px; color: #94a3b8;
            text-decoration: none; font-size: 14px; transition: 0.3s;
            margin: 4px 15px; border-radius: 8px;
        }
        .menu li a:hover, .menu li a.active {
            background: rgba(197, 160, 89, 0.15); color: var(--primary);
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 70px; background: #fff;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 30px; position: sticky; top: 0;
            z-index: 999; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        /* --- PHẦN QUAN TRỌNG NHẤT: FIX LỖI MỜ --- */
        .page-content { 
            padding: 20px;
            /* Không đặt z-index ở đây để tránh tạo Stacking Context mới cho nội dung */
        }

        /* Ép lớp nền đen của Bootstrap xuống dưới */
        .modal-backdrop {
            z-index: 1040 !important;
        }
        
        /* Ép cửa sổ Modal lên trên cùng tuyệt đối so với tất cả thành phần khác */
        .modal {
            z-index: 1060 !important;
        }

        /* Fix lỗi cuộn trang khi mở modal */
        body.modal-open {
            overflow: hidden;
        }

        .btn-logout {
            background: #fff1f2; color: #e11d48;
            padding: 8px 15px; border-radius: 8px;
            text-decoration: none; font-size: 12px; font-weight: 600;
            border: 1px solid #fee2e2;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">TTD.SIGNATURE</a>
        <ul class="menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line me-2"></i> Tổng quan</a></li>
            <li><a href="{{ route('admin.foods.index') }}" class="{{ request()->routeIs('admin.foods.*') ? 'active' : '' }}"><i class="fa-solid fa-utensils me-2"></i> Quản lý món ăn</a></li>
            <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-receipt me-2"></i> Đơn hàng</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <h3 class="m-0">@yield('page_title', 'Hệ thống Quản trị')</h3>
            <div class="user-info d-flex align-items-center">
                <span class="me-3 fw-bold">👤 {{ auth()->user()->name ?? 'Administrator' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout border-0 shadow-sm">Đăng xuất</button>
                </form>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 12px;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>