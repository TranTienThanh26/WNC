<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #{{ $order->id }} - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
    <style>
        .detail-box {
            background: #fff;
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .detail-header h3 {
            margin: 0;
            font-size: 22px;
        }

        .status {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .pending {
            background: #fde68a;
            color: #92400e;
        }

        .done {
            background: #22c55e;
            color: #fff;
        }

        .info p {
            margin: 6px 0;
            font-size: 14px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .items-table th {
            background: #facc15;
        }

        .total-box {
            text-align: right;
            margin-top: 16px;
            font-size: 18px;
            font-weight: 700;
        }

        .total-box span {
            color: #ff6a00;
        }

        .qr-box {
            margin-top: 24px;
            text-align: center;
            padding-top: 16px;
            border-top: 1px dashed #ddd;
        }

        .qr-box img {
            width: 220px;
            margin-bottom: 10px;
        }

        .actions {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back {
            background: #e5e7eb;
            color: #111;
        }

        .btn-home {
            background: #ff6a00;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="orders-container">

    <div class="detail-box">

        <!-- HEADER -->
        <div class="detail-header">
            <h3>📦 Đơn hàng #{{ $order->id }}</h3>

            <span class="status {{ $order->status == 'Chờ thanh toán' ? 'pending' : 'done' }}">
                {{ $order->status }}
            </span>
        </div>

        <!-- INFO -->
        <div class="info">
            <p><strong>👤 Khách:</strong> {{ $order->customer_name }}</p>
            <p><strong>📞 SĐT:</strong> {{ $order->phone ?? 'Không có' }}</p>
            <p><strong>📍 Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>🕒 Thời gian:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- ITEMS -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Món ăn</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->food->name ?? 'Món đã xóa' }}</td>
                        <td>{{ number_format($item->price) }} đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            {{ number_format($item->price * $item->quantity) }} đ
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTAL -->
        <div class="total-box">
            Tổng cộng:
            <span>{{ number_format($order->total_price) }} đ</span>
        </div>

        <!-- QR -->
        @if($order->status == 'Chờ thanh toán')
            <div class="qr-box">
                <h4>📱 Quét QR để thanh toán</h4>
                <img src="{{ asset('images/qr.png') }}" alt="QR thanh toán">
                <p>Ngân hàng: Vietcombank</p>
                <p>STK: 0123456789</p>
                <p>Tên: TTDFOOD</p>
            </div>
        @endif

        <!-- ACTION -->
        <div class="actions">
            <a href="{{ route('orders') }}" class="btn btn-back">⬅ Quay lại đơn hàng</a>
            <a href="{{ route('home') }}" class="btn btn-home">🏠 Trang chủ</a>
        </div>

    </div>

</div>

</body>
</html>
