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

    <!-- SEARCH -->
    <div class="search-box">
        <input
            type="text"
            id="searchFood"
            placeholder="🔍 Tìm món ăn..."
            autocomplete="off"
        >
    </div>

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

    <div class="menu-grid">
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

<!-- ===== FEATURED FOOD (DATABASE) ===== -->
<section class="section">
    <h2 class="section-title">Món ngon hôm nay</h2>

    @if($foods->count() == 0)
        <p>Chưa có món ăn nào trong hệ thống</p>
    @else
        <div class="food-grid">
            @foreach($foods as $food)
                <div class="food-card">

                    <a href="{{ route('food.show', $food->id) }}">
                        <img
                            src="{{ $food->image
                                ? asset('storage/'.$food->image)
                                : 'https://source.unsplash.com/400x300/?food'
                            }}"
                            alt="{{ $food->name }}"
                        >
                    </a>

                    <div class="food-info">
                        <h3>{{ $food->name }}</h3>

                        <p class="food-desc">
                            {{ $food->description ?? 'Món ăn hấp dẫn – phục vụ nóng hổi' }}
                        </p>

                        <div class="food-bottom">
                            <span class="price">
                                {{ number_format($food->price) }} đ
                            </span>

                            <form action="{{ route('cart.add', $food->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add">➕ Đặt món</button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- NÚT XEM THÊM --}}
        @if($totalFoods > $foods->count())
            <div style="text-align:center; margin-top:30px;">
                <a href="{{ route('menu') }}" class="btn-login">
                    👀 Xem thêm món ăn
                </a>
            </div>
        @endif
    @endif
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
