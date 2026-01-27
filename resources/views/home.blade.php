<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>beFood - Đặt đồ ăn</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="logo">TTDFood</div>

    <div class="search-box">
        <input type="text" placeholder="Tìm món ăn hoặc nhà hàng">
    </div>

    <a href="#" class="btn-login">Đăng nhập / Đăng ký</a>
</header>

<!-- HERO -->
<section class="hero">
    <h2>Địa chỉ bạn muốn giao món</h2>
    <div class="address-box">
        <input type="text" placeholder="Nhập địa chỉ của bạn">
        <button>📍</button>
    </div>
</section>

<!-- MENU COLLECTION -->
<section class="menu">
    <h2>Bộ sưu tập món ăn</h2>

    <div class="menu-grid">
        @for ($i = 1; $i <= 8; $i++)
            <div class="menu-item">
                <img src="https://source.unsplash.com/300x200/?food&sig={{ $i }}" alt="">
                <p>Món ăn {{ $i }}</p>
            </div>
        @endfor
    </div>
</section>

</body>
</html>
