<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<div class="checkout-wrapper">
    <div class="checkout-box">

        <h2 class="checkout-title">💳 Thanh toán đơn hàng</h2>

        {{-- FORM ĐẶT HÀNG --}}
        <form action="{{ route('order.store') }}" method="POST" class="checkout-form">
            @csrf

            <label>Họ tên</label>
            <input type="text" name="customer_name" placeholder="Nhập họ tên" required>

            <label>Số điện thoại</label>
            <input type="text" name="phone" placeholder="Nhập số điện thoại">

            <label>Địa chỉ giao hàng</label>
            <textarea name="address" rows="3" placeholder="Nhập địa chỉ giao hàng" required></textarea>

            {{-- TỔNG TIỀN --}}
            <div class="total-box">
                <span>Tổng thanh toán:</span>
                <strong>
                    {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['qty'])) }} đ
                </strong>
            </div>

            <button type="submit" class="btn-order">
                ✅ Xác nhận đặt hàng
            </button>
        </form>

        {{-- QR THANH TOÁN --}}
        <div class="qr-box">
            <h3>📱 Quét QR để thanh toán</h3>

            <img src="{{ asset('images/qr.png') }}" alt="QR thanh toán">

            <p><strong>Ngân hàng:</strong> Vietcombank</p>
            <p><strong>STK:</strong> 0123456789</p>
            <p><strong>Chủ TK:</strong> TTDFOOD</p>
            <p class="qr-note">
                💡 Nội dung CK: <b>TTDFOOD + SĐT</b>
            </p>
        </div>

        <a href="{{ route('cart') }}" class="back-link">
            ⬅ Quay lại giỏ hàng
        </a>

    </div>
</div>

</body>
</html>
