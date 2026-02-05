<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Trải Nghiệm #{{ $order->id }} | TTD.Signature</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- 1. SETUP THEME SANG TRỌNG --- */
        :root {
            --bg-body: #fcfcfc;
            --bg-card: #ffffff;
            --text-main: #1a1a1a;
            --text-light: #777777;
            --gold: #c5a059;
            --border: rgba(0,0,0,0.06);
            --shadow: 0 15px 40px rgba(0,0,0,0.05);
            --radius: 4px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color: var(--bg-body); 
            color: var(--text-main); 
            font-family: 'Manrope', sans-serif; 
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        .serif { font-family: 'Playfair Display', serif; }

        /* --- 2. HEADER --- */
        .header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 6%; background: var(--bg-card);
            position: sticky; top: 0; z-index: 1000; height: 80px;
            border-bottom: 1px solid var(--border);
        }
        .logo a { 
            font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; 
            color: var(--text-main); letter-spacing: -0.5px;
        }
        .logo i { color: var(--gold); }

        /* --- 3. CONTAINER & BREADCRUMB --- */
        .container { max-width: 1100px; margin: 40px auto; padding: 0 5%; }
        .breadcrumb { margin-bottom: 30px; color: var(--text-light); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; }
        .breadcrumb a:hover { color: var(--gold); }

        /* ORDER BOX */
        .order-box { background: var(--bg-card); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); border: 1px solid var(--border); }
        
        /* STATUS STRIP */
        .status-strip { 
            padding: 25px 40px; border-bottom: 1px solid #f0f0f0; 
            display: flex; justify-content: space-between; align-items: center;
            background: #fafafa;
        }
        .status-info { display: flex; align-items: center; gap: 15px; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; }
        
        .bg-pending { background-color: #f1c40f; box-shadow: 0 0 10px rgba(241, 196, 15, 0.4); }
        .bg-shipping { background-color: #3498db; box-shadow: 0 0 10px rgba(52, 152, 219, 0.4); }
        .bg-success { background-color: #2ecc71; box-shadow: 0 0 10px rgba(46, 204, 113, 0.4); }
        .bg-cancel { background-color: #e74c3c; box-shadow: 0 0 10px rgba(231, 76, 60, 0.4); }

        .status-text { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; text-transform: capitalize; }
        .order-id-tag { font-size: 12px; color: var(--text-light); letter-spacing: 1px; }

        /* CONTENT GRID */
        .order-content { display: grid; grid-template-columns: 1.5fr 1fr; }
        .col-items { padding: 40px; border-right: 1px solid #f0f0f0; }
        .col-info { padding: 40px; background: #fdfdfd; }

        /* ITEMS LIST */
        .item-row { display: flex; gap: 20px; margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #f8f8f8; align-items: center; }
        .item-row:last-child { border-bottom: none; margin-bottom: 0; }
        .item-img { width: 85px; height: 85px; border-radius: 2px; object-fit: cover; background: #f9f9f9; border: 1px solid #eee; }
        .item-details h4 { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 5px; color: var(--text-main); }
        .item-details p { font-size: 13px; color: var(--text-light); }
        .item-price { margin-left: auto; font-weight: 700; color: var(--gold); font-size: 16px; }

        /* INFO SECTION */
        .info-group { margin-bottom: 35px; }
        .info-title { 
            font-size: 11px; font-weight: 700; margin-bottom: 20px; 
            display: flex; align-items: center; gap: 10px; color: var(--text-main);
            text-transform: uppercase; letter-spacing: 2px; border-left: 3px solid var(--gold); padding-left: 15px;
        }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--text-light); }
        .info-row strong { color: var(--text-main); font-weight: 600; }
        
        .total-box { border-top: 1px solid var(--text-main); margin-top: 20px; padding-top: 20px; }
        .total-row { display: flex; justify-content: space-between; align-items: center; }
        .total-row span:first-child { font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        .total-row span:last-child { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: var(--text-main); }

        /* --- KHỐI THANH TOÁN --- */
        .payment-action-box { margin-top: 30px; }

        .btn-pay-now {
            display: block; width: 100%; padding: 16px; background: var(--text-main); color: var(--gold);
            text-align: center; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
            font-size: 12px; border-radius: var(--radius); border: 1px solid var(--gold);
            transition: 0.4s; cursor: pointer;
        }
        .btn-pay-now:hover { background: #000; color: #fff; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }

        .payment-notice { font-size: 11px; color: var(--text-light); font-style: italic; margin-top: 12px; display: block; text-align: center; }

        .qr-card { background: white; padding: 25px; border-radius: 4px; text-align: center; border: 1px solid #eee; }
        .qr-card img { width: 130px; margin-bottom: 15px; filter: contrast(1.1); }
        .qr-card p { font-size: 12px; color: var(--text-light); line-height: 1.6; }

        /* ACTIONS */
        .actions-footer { padding: 25px 40px; background: #fafafa; text-align: left; border-top: 1px solid #f0f0f0; }
        .btn-return { 
            font-size: 11px; font-weight: 700; color: var(--text-main); 
            text-transform: uppercase; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-return:hover { color: var(--gold); }

        @media (max-width: 900px) {
            .order-content { grid-template-columns: 1fr; }
            .col-items { border-right: none; border-bottom: 1px solid #f0f0f0; }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo"><a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a></div>
    <div>
        @auth
            <span style="font-weight: 700; font-size: 13px; color: var(--gold);">{{ Auth::user()->name }}</span>
        @endauth
    </div>
</header>

<div class="container">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Khởi đầu</a> / 
        <a href="{{ route('orders') }}">Lịch sử</a> / 
        <span>Chi tiết đơn #{{ $order->id }}</span>
    </div>

    @php
        $st = strtolower($order->status);
        if(in_array($st, ['đang giao', 'shipping', 'đang chuẩn bị'])) {
            $dotClass = 'bg-shipping'; 
        } elseif(in_array($st, ['hoàn thành', 'completed', 'đã giao hàng'])) {
            $dotClass = 'bg-success';
        } elseif(in_array($st, ['đã hủy', 'cancelled', 'từ chối'])) {
            $dotClass = 'bg-cancel';
        } else {
            $dotClass = 'bg-pending';
        }
    @endphp

    <div class="order-box">
        <div class="status-strip">
            <div class="status-info">
                <div class="status-dot {{ $dotClass }}"></div>
                <div class="status-text">{{ $order->status }}</div>
            </div>
            <div class="order-id-tag">
                MÃ ĐƠN: #{{ $order->id }} <span style="margin:0 10px">|</span> {{ $order->created_at->format('d.m.Y H:i') }}
            </div>
        </div>

        <div class="order-content">
            <div class="col-items">
                <h4 class="serif" style="font-size: 22px; margin-bottom: 30px;">Thực Đơn Đã Chọn</h4>
                
                @foreach($order->items as $item)
                <div class="item-row">
                    @php
                        // ĐỒNG BỘ LOGIC ẢNH: Trỏ vào public/foods
                        $img = $item->food->image ?? '';
                        if ($img && Str::startsWith($img, 'http')) {
                            $dImg = $img;
                        } elseif ($img) {
                            $cleanName = str_replace('foods/', '', $img);
                            $dImg = asset('foods/' . $cleanName);
                        } else {
                            $dImg = asset('foods/default.jpg');
                        }
                    @endphp
                    <img src="{{ $dImg }}" class="item-img" onerror="this.src='https://placehold.co/150x150?text=Signature'">
                    
                    <div class="item-details">
                        <h4>{{ $item->food->name ?? 'Món Signature' }}</h4>
                        <p>Số lượng: <strong>{{ $item->quantity }}</strong></p>
                    </div>
                    
                    <div class="item-price">
                        {{ number_format($item->price * $item->quantity) }} đ
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-info">
                <div class="info-group">
                    <div class="info-title">Địa điểm giao dịch</div>
                    <div class="info-row">
                        <span>Quý khách:</span> <strong>{{ $order->customer_name ?: 'Khách hàng TTD' }}</strong>
                    </div>
                    <div class="info-row">
                        <span>Liên hệ:</span> <strong>{{ $order->phone ?: '---' }}</strong>
                    </div>
                    <div class="info-row" style="flex-direction: column; gap: 5px;">
                        <span>Địa chỉ:</span>
                        <strong style="font-size: 13px; line-height: 1.5;">{{ $order->address ?: 'Vui lòng bổ sung địa chỉ' }}</strong>
                    </div>
                </div>

                <div class="info-group">
                    <div class="info-title">Giá trị đơn hàng</div>
                    <div class="info-row">
                        <span>Giá trị thực đơn:</span> <span>{{ number_format($order->total_price) }} đ</span>
                    </div>
                    <div class="total-box">
                        <div class="total-row">
                            <span>Tổng cộng</span>
                            <span>{{ number_format($order->total_price) }} đ</span>
                        </div>
                    </div>
                </div>

                {{-- KHỐI HÀNH ĐỘNG THANH TOÁN --}}
                <div class="payment-action-box">
                    @if($order->status == 'Chưa thanh toán')
                        <a href="{{ route('checkout.show', $order->id) }}" class="btn-pay-now">
                            <i class="fas fa-credit-card"></i> Thanh toán & Xác nhận ngay
                        </a>
                        <span class="payment-notice serif">Hoàn tất thông tin để chúng tôi phục vụ bạn tốt nhất.</span>
                    @elseif($dotClass == 'bg-pending')
                        <div class="qr-card">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TTDSIGNATURE_{{ $order->id }}" alt="QR Payment">
                            <p>Quét mã để hoàn tất <br> <b>chuyển khoản thanh toán</b></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="actions-footer">
            <a href="{{ route('orders') }}" class="btn-return">
                <i class="fas fa-chevron-left"></i> Quay lại lịch sử
            </a>
        </div>
    </div>
</div>

</body>
</html>