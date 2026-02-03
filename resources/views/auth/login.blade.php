<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTD.Signature | Đăng Nhập</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #fcfcfc;
            --color-main: #1a1a1a;
            --color-gold: #c5a059;
            --color-gray: #777777;
            --shadow-soft: 0 15px 40px rgba(0,0,0,0.05);
            --radius: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color: var(--bg-body); 
            color: var(--color-main); 
            font-family: 'Manrope', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* --- HEADER --- */
        .header {
            display: flex; justify-content: center; align-items: center;
            padding: 15px 6%; background: #fff;
            height: 80px; border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .logo a { 
            font-family: 'Playfair Display', serif; 
            font-size: 24px; font-weight: 700; color: var(--color-main); 
            text-decoration: none;
        }
        .logo i { color: var(--color-gold); margin-right: 5px; }

        /* --- LOGIN SECTION --- */
        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                        url('https://images.unsplash.com/photo-1514362545857-3bc16549766b?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .login-box {
            background: #fff;
            width: 100%;
            max-width: 400px;
            padding: 50px 40px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-soft);
            text-align: center;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .login-box h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--color-main);
            letter-spacing: -0.5px;
        }

        .login-box p {
            font-size: 14px;
            color: var(--color-gray);
            margin-bottom: 35px;
            font-style: italic;
        }

        .error-msg {
            background: #fff5f5;
            color: #e53e3e;
            padding: 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 25px;
            border-left: 3px solid #e53e3e;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            color: var(--color-main);
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #eee;
            border-radius: 4px;
            font-family: 'Manrope', sans-serif;
            font-size: 14px;
            outline: none;
            transition: 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus {
            background: #fff;
            border-color: var(--color-gold);
            box-shadow: 0 5px 15px rgba(197, 160, 89, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--color-main);
            color: var(--color-gold);
            border: none;
            border-radius: 4px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #000;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .back-home {
            display: inline-block;
            margin-top: 30px;
            font-size: 12px;
            color: var(--color-gray);
            text-decoration: none;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .back-home:hover {
            color: var(--color-gold);
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a>
    </div>
</header>

<main class="login-container">
    <div class="login-box">
        <h2>Chào mừng trở lại</h2>
        <p>Hành trình khám phá mỹ vị tiếp tục</p>

        @if ($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Tài khoản Email</label>
                <input type="email" name="email" placeholder="example@mail.com" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Mật khẩu mật định</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">
                Xác nhận đăng nhập
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-home">
            <i class="fas fa-arrow-left"></i> Quay lại trang chủ
        </a>
    </div>
</main>

</body>
</html>