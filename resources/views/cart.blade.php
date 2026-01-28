<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
</head>
<body>
<h2>🛒 Giỏ hàng</h2>

@if(empty($cart))
    <p>Giỏ hàng trống</p>
@else
<table border="1" cellpadding="10">
    <tr>
        <th>Tên món</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
        <th></th>
    </tr>
    @php $total = 0; @endphp
    @foreach($cart as $id => $item)
        @php $total += $item['price'] * $item['qty']; @endphp
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ number_format($item['price']) }}đ</td>
            <td>{{ $item['qty'] }}</td>
            <td>{{ number_format($item['price'] * $item['qty']) }}đ</td>
            <td>
                <a href="{{ route('cart.remove', $id) }}">Xóa</a>
            </td>
        </tr>
    @endforeach
</table>

<h3>Tổng tiền: {{ number_format($total) }}đ</h3>

<a href="{{ route('checkout') }}">➡ Thanh toán</a>
@endif

</body>
</html>
