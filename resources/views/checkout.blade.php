<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán - TTDFood</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }
        .checkout-box {
            width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
        }
        button {
            background: #ff6b00;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            opacity: 0.9;
        }
        a {
            display: block;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="checkout-box">
    <h2>💳 Thanh toán</h2>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <!-- TÊN KHÁCH (QUAN TRỌNG) -->
        <label>Họ tên</label>
        <input type="text" name="customer_name" required>

        <!-- SỐ ĐIỆN THOẠI (nếu có cột thì dùng, không có thì vẫn ok) -->
        <label>Số điện thoại</label>
        <input type="text" name="phone">

        <!-- ĐỊA CHỈ -->
        <label>Địa chỉ giao hàng</label>
        <textarea name="address" rows="3" required></textarea>

        <button type="submit">✅ Xác nhận đặt hàng</button>
    </form>

    <a href="{{ route('cart') }}">⬅ Quay lại giỏ hàng</a>
</div>

</body>
</html>
