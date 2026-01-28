<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<header class="header">
    <div class="logo">TTDFood</div>
</header>

<section class="hero">
    <h2>Đăng nhập</h2>

    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="/login" style="max-width:360px;margin:0 auto;">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            style="width:100%;padding:12px;margin-bottom:12px;"
        >

        <input
            type="password"
            name="password"
            placeholder="Mật khẩu"
            required
            style="width:100%;padding:12px;margin-bottom:12px;"
        >

        <button class="btn-login" style="width:100%">
            Đăng nhập
        </button>
    </form>
</section>

</body>
</html>
