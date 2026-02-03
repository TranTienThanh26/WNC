<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Trải Nghiệm | TTD.Signature</title>
    
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
            --shadow: 0 10px 30px rgba(0,0,0,0.04);
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

        /* --- 3. CONTAINER --- */
        .container { max-width: 1000px; margin: 60px auto; padding: 0 5%; }
        .page-title { 
            font-size: 32px; margin-bottom: 40px; font-family: 'Playfair Display', serif; 
            font-weight: 500; text-align: center; color: var(--text-main); 
        }
        .page-title span { color: var(--gold); font-style: italic; }
        
        /* EMPTY STATE */
        .empty-box { 
            text-align: center; padding: 80px 40px; background: var(--bg-card); 
            border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border);
        }
        .empty-box i { font-size: 50px; color: #eee; margin-bottom: 25px; }
        .empty-box p { font-size: 16px; color: var(--text-light); margin-bottom: 30px; letter-spacing: 0.5px; }
        .btn-go-menu { 
            padding: 12px 35px; background: var(--text-main); color: var(--gold); 
            border-radius: var(--radius); font-weight: 600; text-transform: uppercase; font-size: 12px; 
            letter-spacing: 1px; transition: 0.3s; display: inline-block;
        }
        .btn-go-menu:hover { background: #000; box-shadow: 0 5px 15px rgba(0,0,0,0.15); }

        /* ORDER LIST */
        .orders-list { display: flex; flex-direction: column; gap: 25px; }
        
        /* ORDER CARD */
        .order-card { 
            background: var(--bg-card); border-radius: var(--radius); 
            overflow: hidden; box-shadow: var(--shadow); transition: 0.4s; 
            border: 1px solid var(--border); 
        }
        .order-card:hover { transform: translateY(-5px); border-color: var(--gold); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
        
        .card-header { 
            padding: 20px 25px; background: #fafafa; border-bottom: 1px solid #f0f0f0; 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .order-id { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--text-main); font-size: 18px; }
        .order-date { font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        .card-body { padding: 25px; display: grid; grid-template-columns: 1fr 1.5fr 1fr auto; align-items: center; gap: 20px; }
        
        .info-label { font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 6px; }
        .info-value { font-size: 14px; color: var(--text-main); font-weight: 500; }
        .total-price { color: var(--gold); font-weight: 700; font-size: 18px; font-family: 'Manrope', sans-serif; }

        /* STATUS BADGE SANG TRỌNG */
        .status-badge { 
            padding: 5px 12px; border-radius: 2px; font-size: 11px; font-weight: 700; 
            text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px; 
        }
        .status-pending { background: #fffcf0; color: #b7791f; border: 1px solid #fef3c7; }
        .status-shipping { background: #f0f7ff; color: #2b6cb0; border: 1px solid #ebf4ff; }
        .status-success { background: #f0fff4; color: #276749; border: 1px solid #f0fff4; }
        .status-cancel { background: #fff5f5; color: #c53030; border: 1px solid #fff5f5; }

        /* BUTTON */
        .btn-detail { 
            padding: 10px 20px; border: 1px solid var(--text-main); color: var(--text-main); 
            border-radius: var(--radius); font-weight: 700; font-size: 12px; 
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; 
        }
        .btn-detail:hover { background: var(--text-main); color: var(--gold); }

        .btn-home { 
            display: block; width: fit-content; margin: 50px auto 0; color: var(--text-light); 
            font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;
        }
        .btn-home:hover { color: var(--gold); }

        @media (max-width: 850px) {
            .card-body { grid-template-columns: 1fr 1fr; }
            .btn-detail { grid-column: span 2; text-align: center; }
        }
        @media (max-width: 500px) {
            .card-body { grid-template-columns: 1fr; text-align: center; }
            .info-group, .btn-detail { grid-column: span 1; }
            .card-header { flex-direction: column; text-align: center; gap: 15px; }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a>
    </div>
    <div style="display: flex; align-items: center; gap: 20px;">
        @auth
            <a href="{{ route('cart') }}" style="font-size: 18px; color: var(--text-main);"><i class="fas fa-shopping-bag"></i></a>
            <span style="font-weight: 700; font-size: 13px;">{{ Auth::user()->name }}</span>
        @endauth
    </div>
</header>

<div class="container">
    <h2 class="page-title">Lịch sử <span>đặt món</span></h2>

    {{-- TRƯỜNG HỢP CHƯA CÓ ĐƠN --}}
    @if($orders->count() == 0)
        <div class="empty-box">
            <i class="fas fa-concierge-bell"></i>
            <p>Quý khách chưa thực hiện đơn đặt hàng nào.</p>
            <a href="{{ route('menu') }}" class="btn-go-menu">
                Khám phá thực đơn
            </a>
        </div>
    @else

    {{-- DANH SÁCH ĐƠN --}}
    <div class="orders-list">
        @foreach($orders as $order)
            @php
                $statusClass = 'status-pending';
                $icon = 'fa-receipt';
                
                $st = strtolower($order->status);
                if(in_array($st, ['đang giao', 'shipping', 'đang chuẩn bị'])) {
                    $statusClass = 'status-shipping'; $icon = 'fa-concierge-bell';
                } elseif(in_array($st, ['hoàn thành', 'completed', 'đã giao hàng'])) {
                    $statusClass = 'status-success'; $icon = 'fa-check';
                } elseif(in_array($st, ['đã hủy', 'cancelled', 'từ chối'])) {
                    $statusClass = 'status-cancel'; $icon = 'fa-times';
                }
            @endphp

            <div class="order-card">
                {{-- HEADER CARD --}}
                <div class="card-header">
                    <div>
                        <span class="order-id">Mã đơn #{{ $order->id }}</span>
                        <div class="order-date">
                            <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d/m/Y') }} <span style="margin: 0 5px">•</span> {{ $order->created_at->format('H:i') }}
                        </div>
                    </div>
                    <span class="status-badge {{ $statusClass }}">
                        <i class="fas {{ $icon }}"></i> {{ $order->status }}
                    </span>
                </div>

                {{-- BODY CARD --}}
                <div class="card-body">
                    <div class="info-group">
                        <div class="info-label">Quý khách</div>
                        <div class="info-value">{{ $order->customer_name }}</div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Điểm đến</div>
                        <div class="info-value" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                            {{ $order->address }}
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Giá trị trải nghiệm</div>
                        <div class="info-value total-price">{{ number_format($order->total_price) }} <small style="font-size: 12px;">đ</small></div>
                    </div>

                    <div>
                        <a href="{{ route('order.show', $order->id) }}" class="btn-detail">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <a href="{{ route('home') }}" class="btn-home">
        <i class="fas fa-chevron-left"></i> Trở về trang chủ
    </a>

</div>

</body>
</html>