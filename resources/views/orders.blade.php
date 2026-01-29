<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
</head>
<body>

<div class="orders-container">

    <h2 class="page-title">📦 Đơn hàng của bạn</h2>

    {{-- TRƯỜNG HỢP CHƯA CÓ ĐƠN --}}
    @if($orders->count() == 0)
        <div class="empty-box">
            <p>😢 Bạn chưa có đơn hàng nào</p>
            <a href="{{ route('menu') }}" class="btn-go-menu">
                🍜 Đặt món ngay
            </a>
        </div>
    @else

        {{-- DANH SÁCH ĐƠN --}}
        <div class="orders-list">
            @foreach($orders as $order)

                <a href="{{ route('orders.show', $order->id) }}" class="order-link">

                    <div class="order-card">

                        {{-- HEADER --}}
                        <div class="order-header">
                            <span class="order-id">
                                Đơn #{{ $order->id }}
                            </span>

                            @php
                                $isPending = $order->status === 'Chờ thanh toán' || $order->status === 'pending';
                            @endphp

                            <span class="order-status {{ $isPending ? 'pending' : 'done' }}">
                                {{ $isPending ? '⏳ Đang xử lý' : '✅ Hoàn thành' }}
                            </span>
                        </div>

                        {{-- BODY --}}
                        <div class="order-body">
                            <p><strong>👤 Khách:</strong> {{ $order->customer_name }}</p>
                            <p><strong>📍 Địa chỉ:</strong> {{ $order->address }}</p>

                            <p class="order-total">
                                💰 Tổng tiền:
                                <span>{{ number_format($order->total_price) }} đ</span>
                            </p>
                        </div>

                        {{-- FOOTER --}}
                        <div class="order-footer">
                            🕒 {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>

                    </div>
                </a>

            @endforeach
        </div>
    @endif

    <a href="{{ route('home') }}" class="btn-home">
        🏠 Về trang chủ
    </a>

</div>

</body>
</html>
