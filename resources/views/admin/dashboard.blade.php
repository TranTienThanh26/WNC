<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<header class="header">
    <div class="logo">ADMIN</div>

    <form method="POST" action="/logout">
        @csrf
        <button class="btn-login">Đăng xuất</button>
    </form>
</header>

<section class="section">
    <h2 class="section-title">
        Xin chào {{ auth()->user()->name }} 👑
    </h2>

    <p>Chào mừng bạn đến trang quản trị TTDFood</p>

    <ul style="margin-top:20px;">
        <li>✔ Quản lý món ăn</li>
        <li>✔ Quản lý người dùng</li>
        <li>✔ Xem đơn hàng</li>
    </ul>
</section>

</body>
</html>
