<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
</head>
<body>

<h2>📦 Đơn hàng của bạn</h2>

@if($orders->count() == 0)
    <p>Bạn chưa có đơn hàng nào.</p>
@else
    @foreach($orders as $order)
        <hr>
        <p><strong>Khách:</strong> {{ $order->customer_name }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }}đ</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at }}</p>
    @endforeach
@endif

<br>
<a href="{{ route('home') }}">🏠 Về trang chủ</a>

</body>
</html>
