<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>TTDFood - Đặt đồ ăn online</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}" style="color:white;text-decoration:none">
            TTDFood
        </a>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Tìm món ăn hoặc nhà hàng">
    </div>

    {{-- 🔐 LOGIN / LOGOUT --}}
    @auth
        <div class="user-box">
            <span>👋 Xin chào, {{ auth()->user()->name }}</span>

            <a href="{{ route('cart') }}" class="btn-login">🛒 Giỏ hàng</a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-login">Đăng xuất</button>
            </form>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn-login">
            Đăng nhập / Đăng ký
        </a>
    @endauth
</header>

<!-- ===== HERO ===== -->
<section class="hero">
    <h2>Địa chỉ bạn muốn giao món</h2>
    <div class="address-box">
        <input type="text" placeholder="Nhập địa chỉ của bạn">
        <button>📍</button>
    </div>
</section>

<!-- ===== CATEGORY ===== -->
<section class="menu">
    <h2>Bộ sưu tập món ăn</h2>

    <div class="menu-grid" style="grid-template-columns: repeat(4, 1fr);">
        <a href="{{ route('menu') }}" class="menu-item">
            <img src="https://source.unsplash.com/400x300/?drink">
            <p>Đồ uống</p>
        </a>

        <a href="{{ route('menu') }}" class="menu-item">
            <img src="https://source.unsplash.com/400x300/?fastfood">
            <p>Thức ăn nhanh</p>
        </a>

        <a href="{{ route('menu') }}" class="menu-item">
            <img src="https://source.unsplash.com/400x300/?rice">
            <p>Cơm</p>
        </a>

        <a href="{{ route('menu') }}" class="menu-item">
            <img src="https://source.unsplash.com/400x300/?european-food">
            <p>Món Á – Âu</p>
        </a>
    </div>
</section>

<!-- ===== FEATURED FOOD ===== -->
<section class="section">
    <h2 class="section-title">Quán ngon quanh đây</h2>

    <div class="food-grid">
        <div class="food-card">
            <img src="https://source.unsplash.com/400x300/?burger">
            <div class="food-info">
                <h3>Burger Bò Phô Mai</h3>
                <p class="food-desc">Bán chạy • Được yêu thích</p>
                <div class="food-bottom">
                    <span class="price">45.000 đ</span>
                    <a href="{{ route('menu') }}" class="btn-add">Đặt món</a>
                </div>
            </div>
        </div>

        <div class="food-card">
            <img src="https://source.unsplash.com/400x300/?pizza">
            <div class="food-info">
                <h3>Pizza Hải Sản</h3>
                <p class="food-desc">Món nổi bật hôm nay</p>
                <div class="food-bottom">
                    <span class="price">85.000 đ</span>
                    <a href="{{ route('menu') }}" class="btn-add">Đặt món</a>
                </div>
            </div>
        </div>

        <div class="food-card">
            <img src="https://source.unsplash.com/400x300/?fried-rice">
            <div class="food-info">
                <h3>Cơm Chiên Hải Sản</h3>
                <p class="food-desc">Giao nhanh • Nóng hổi</p>
                <div class="food-bottom">
                    <span class="price">40.000 đ</span>
                    <a href="{{ route('menu') }}" class="btn-add">Đặt món</a>
                </div>
            </div>
        </div>

        <div class="food-card">
            <img src="https://source.unsplash.com/400x300/?milk-tea">
            <div class="food-info">
                <h3>Trà Sữa Trân Châu</h3>
                <p class="food-desc">Yêu thích giới trẻ</p>
                <div class="food-bottom">
                    <span class="price">30.000 đ</span>
                    <a href="{{ route('menu') }}" class="btn-add">Đặt món</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== APP DOWNLOAD ===== -->
<section class="app-download">
    <div>
        <h2>Đặt đồ ăn nhanh chóng cùng TTDFood</h2>
        <p>Tải ứng dụng để nhận nhiều ưu đãi hấp dẫn mỗi ngày</p>
        <a href="{{ route('menu') }}" class="btn-login">🍽 Xem thực đơn</a>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-grid">
        <div>
            <h4>Về TTDFood</h4>
            <p>Giới thiệu</p>
            <p>Tuyển dụng</p>
            <p>Điều khoản sử dụng</p>
        </div>

        <div>
            <h4>Hỗ trợ</h4>
            <p>Trung tâm trợ giúp</p>
            <p>Hướng dẫn đặt món</p>
            <p>Chính sách bảo mật</p>
        </div>

        <div>
            <h4>Liên hệ</h4>
            <p>Hotline: 1900 9999</p>
            <p>Email: support@ttdfood.vn</p>
            <p>TP. Hồ Chí Minh</p>
        </div>

        <div>
            <h4>Kết nối</h4>
            <p>Facebook</p>
            <p>Instagram</p>
            <p>Zalo</p>
        </div>
    </div>
</footer>

</body>
</html>
