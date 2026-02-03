@extends('admin.layout')

@section('title', 'TTD.Signature | Bảng điều khiển thượng hạng')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&display=swap" rel="stylesheet">

<style>
    :root {
        --sig-gold: #c5a059;
        --sig-dark: #111111;
        --sig-light-gold: #e2c285;
        --glass-bg: rgba(255, 255, 255, 0.8);
    }

    body { background: #f4f4f2; color: var(--sig-dark); }
    .serif { font-family: 'Playfair Display', serif; }
    .luxury-font { font-family: 'Cormorant Garamond', serif; }

    /* --- Animation mượt mà --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeInUp 0.8s ease forwards; }

    /* --- Tiêu đề nghệ thuật --- */
    .dashboard-title {
        position: relative;
        display: inline-block;
        margin-bottom: 50px;
    }
    .dashboard-title::after {
        content: 'Management';
        position: absolute;
        bottom: -20px;
        right: 0;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 24px;
        color: var(--sig-gold);
        opacity: 0.6;
    }

    /* --- Thống kê hàng ngang Glassmorphism --- */
    .stat-luxury-bar {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 50px 20px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 20px 60px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        margin-bottom: 60px;
    }

    .stat-item {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .stat-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: linear-gradient(to bottom, transparent, var(--sig-gold), transparent);
        opacity: 0.3;
    }

    .stat-icon-wrap {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--sig-gold);
        font-weight: 700;
        margin-bottom: 15px;
        display: block;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 600;
        letter-spacing: -1px;
        margin-bottom: 5px;
        display: block;
        background: linear-gradient(135deg, #111, var(--sig-gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-desc {
        font-family: 'Cormorant Garamond', serif;
        font-size: 16px;
        font-style: italic;
        color: #888;
    }

    /* --- Table Card Nghệ Thuật --- */
    .table-luxury-card {
        background: white;
        border-radius: 30px;
        border: none;
        overflow: hidden;
        box-shadow: 0 30px 70px rgba(0,0,0,0.03);
    }

    .table-header-box {
        padding: 35px 40px;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .food-img-circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        object-fit: cover;
        padding: 4px;
        background: linear-gradient(45deg, var(--sig-gold), transparent);
        transition: 0.5s;
    }
    tr:hover .food-img-circle { transform: rotate(10deg) scale(1.1); }

    .table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        color: #bbb;
        padding: 20px 40px;
        border: none;
        background: #fafafa;
    }

    .table tbody td {
        padding: 25px 40px;
        border-bottom: 1px solid #f2f2f2;
    }

    /* --- Nút bấm xịn xò --- */
    .btn-signature {
        background: var(--sig-dark);
        color: var(--sig-gold);
        border: 1px solid var(--sig-gold);
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 12px;
        letter-spacing: 2px;
        font-weight: 700;
        transition: 0.4s;
    }
    .btn-signature:hover {
        background: var(--sig-gold);
        color: white;
        box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3);
    }

    .badge-status {
        font-size: 9px;
        letter-spacing: 1px;
        padding: 4px 12px;
        border-radius: 50px;
        border: 1px solid #28a745;
        color: #28a745;
    }
</style>

<div class="container-fluid py-5 px-lg-5 animate-in">
    
    <div class="dashboard-title">
        <h1 class="serif fw-bold" style="font-size: 50px; letter-spacing: -1px;">
            TTD.<span style="color: var(--sig-gold)">Signature</span>
        </h1>
    </div>

    <div class="stat-luxury-bar">
        <div class="stat-item">
            <span class="stat-icon-wrap"><i class="fas fa-receipt me-1"></i> Orders</span>
            <span class="stat-value serif">{{ number_format($totalOrders) }}</span>
            <span class="stat-desc">Đơn hàng thượng hạng</span>
        </div>
        
        <div class="stat-item">
            <span class="stat-icon-wrap"><i class="fas fa-gem me-1"></i> Revenue</span>
            <span class="stat-value serif">{{ number_format($revenue) }}<small style="font-size: 18px">đ</small></span>
            <span class="stat-desc">Giá trị doanh thu</span>
        </div>

        <div class="stat-item">
            <span class="stat-icon-wrap"><i class="fas fa-utensils me-1"></i> Menu</span>
            <span class="stat-value serif">{{ number_format($totalFoods) }}</span>
            <span class="stat-desc">Tuyển tập mỹ thực</span>
        </div>

        <div class="stat-item">
            <span class="stat-icon-wrap"><i class="fas fa-crown me-1"></i> Members</span>
            <span class="stat-value serif">{{ number_format($totalUsers) }}</span>
            <span class="stat-desc">Quý tộc Signature</span>
        </div>
    </div>

    <div class="table-luxury-card animate-in" style="animation-delay: 0.3s;">
        <div class="table-header-box">
            <div>
                <h2 class="serif fw-bold mb-1">Mới Cập Nhật</h2>
                <p class="luxury-font mb-0" style="color: var(--sig-gold); font-size: 20px;">The latest culinary masterpieces</p>
            </div>
            <a href="{{ route('admin.foods.index') }}" class="btn btn-signature">QUẢN TRỊ THỰC ĐƠN</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-5">Thực đơn</th>
                        <th>Phân loại</th>
                        <th>Địa điểm</th>
                        <th>Giá trị</th>
                        <th class="pe-5 text-end">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newFoods as $food)
                    <tr>
                        <td class="ps-5">
                            <div class="d-flex align-items-center">
                                <img src="{{ $food->image ? asset($food->image) : 'https://images.unsplash.com/photo-1550966841-3ee2cc1b1511?w=200' }}" class="food-img-circle me-4">
                                <div>
                                    <div class="fw-bold serif" style="font-size: 18px; color: var(--sig-dark);">{{ $food->name }}</div>
                                    <div class="text-muted" style="font-size: 11px; letter-spacing: 1px;">#{{ str_pad($food->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="luxury-font" style="font-size: 18px;">{{ $food->category->name ?? 'Fine Dining' }}</span>
                        </td>
                        <td>
                            <div class="small text-muted"><i class="fas fa-map-marker-alt me-2" style="color: var(--sig-gold);"></i>{{ $food->address ?? 'Toàn hệ thống' }}</div>
                        </td>
                        <td>
                            <span class="serif fw-bold" style="color: var(--sig-gold); font-size: 18px;">{{ number_format($food->price) }} <small>đ</small></span>
                        </td>
                        <td class="pe-5 text-end">
                            <span class="badge-status text-uppercase">Active</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-5 text-center" style="background: #fafafa;">
            <p class="luxury-font text-muted mb-0" style="font-size: 18px;">“Đẳng cấp không chỉ nằm ở hương vị, mà còn ở cách quản trị tinh tế.”</p>
        </div>
    </div>
</div>
@endsection