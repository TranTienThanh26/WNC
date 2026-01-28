<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực đơn - TTDFood</title>
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
        <input type="text" placeholder="Tìm món ăn">
    </div>

    {{-- AUTH --}}
    @auth
        <a href="{{ route('cart') }}" class="btn-login">🛒 Giỏ hàng</a>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn-login">Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn-login">Đăng nhập</a>
    @endauth
</header>

<!-- ===== MENU ===== -->
<section class="menu">
    <h2>📋 Thực đơn hôm nay</h2>

    @if($foods->count() == 0)
        <p>Chưa có món ăn nào</p>
    @else
        <div class="food-grid">
            @foreach($foods as $food)
                <div class="food-card">
                    <!-- Ảnh món -->
                    <img 
                        src="{{ $food->image ?? 'https://source.unsplash.com/400x300/?food' }}" 
                        alt="{{ $food->name }}"
                    >

                    <!-- Thông tin -->
                    <div class="food-info">
                        <h3>{{ $food->name }}</h3>

                        <p class="food-desc">
                            Món ăn hấp dẫn – phục vụ nóng hổi
                        </p>

                        <div class="food-bottom">
                            <span class="price">
                                {{ number_format($food->price) }} đ
                            </span>

                            <a href="{{ route('cart.add', $food->id) }}" class="btn-add">
                                ➕ Đặt món
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <br>
    <a href="{{ route('home') }}" class="btn-back">⬅ Quay lại trang chủ</a>
</section>

</body>
</html>
