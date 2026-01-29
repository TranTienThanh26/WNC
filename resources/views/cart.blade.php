<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<h2 class="cart-title">🛒 Giỏ hàng của bạn</h2>

@if(empty($cart))
    <p class="empty-cart">Giỏ hàng trống</p>
@else
<table class="cart-table">
    <thead>
        <tr>
            <th>Món ăn</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp

        @foreach($cart as $id => $item)
            @php $sub = $item['price'] * $item['qty']; @endphp
            @php $total += $sub; @endphp

            <tr>
                <td>{{ $item['name'] }}</td>

                <td>{{ number_format($item['price']) }}đ</td>

                <!-- ✅ DẤU - 1 + Ở ĐÂY -->
                <td>
                    <div class="qty-control">
                        <a href="{{ route('cart.decrease', $id) }}" class="qty-btn">−</a>
                        <span class="qty-number">{{ $item['qty'] }}</span>
                        <a href="{{ route('cart.increase', $id) }}" class="qty-btn">+</a>
                    </div>
                </td>

                <td class="price">{{ number_format($sub) }}đ</td>

                <td>
                    <a href="{{ route('cart.remove', $id) }}" class="remove-btn">✖</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="cart-total">
    Tổng tiền: <span>{{ number_format($total) }}đ</span>
</div>

<div class="cart-actions">
    <a href="{{ route('menu') }}" class="btn-back">⬅ Tiếp tục đặt món</a>
    <a href="{{ route('checkout') }}" class="btn-checkout">➡ Thanh toán</a>
</div>
@endif

</body>
</html>
