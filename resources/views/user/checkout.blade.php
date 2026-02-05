<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng | TTD.Signature</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #fcfcfc;
            --bg-card: #ffffff;
            --text-main: #1a1a1a;
            --text-light: #777777;
            --gold: #c5a059;
            --shadow: 0 15px 40px rgba(0,0,0,0.05);
            --border: rgba(0,0,0,0.06);
            --radius: 8px; /* Tăng bo góc cho hiện đại */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--bg-body); color: var(--text-main); font-family: 'Manrope', sans-serif; line-height: 1.6; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        .serif { font-family: 'Playfair Display', serif; }

        .header { display: flex; justify-content: space-between; align-items: center; padding: 15px 6%; background: var(--bg-card); position: sticky; top: 0; z-index: 1000; height: 80px; border-bottom: 1px solid var(--border); }
        .logo a { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: var(--text-main); letter-spacing: -0.5px; }
        .logo i { color: var(--gold); }

        .checkout-container { max-width: 1200px; margin: 40px auto; padding: 0 5%; display: grid; grid-template-columns: 1.4fr 1fr; gap: 40px; }
        .card { background: var(--bg-card); padding: 40px; border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border); }
        
        .section-title { font-family: 'Playfair Display', serif; font-size: 24px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; }
        .section-title i { color: var(--gold); font-size: 18px; }

        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 700; margin-bottom: 10px; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-light); }
        .form-control { width: 100%; padding: 15px; border: 1px solid #eee; border-radius: var(--radius); font-size: 14px; outline: none; transition: 0.3s; background: #fafafa; font-family: 'Manrope', sans-serif; }
        .form-control:focus { border-color: var(--gold); background: white; box-shadow: 0 0 0 4px rgba(197,160,89,0.05); }
        textarea.form-control { resize: none; height: 100px; }

        .order-list { max-height: 380px; overflow-y: auto; margin-bottom: 25px; padding-right: 10px; }
        .order-item { display: flex; gap: 15px; padding-bottom: 15px; border-bottom: 1px solid #f8f8f8; margin-bottom: 15px; align-items: center; }
        .item-img { width: 75px; height: 75px; border-radius: 4px; object-fit: cover; border: 1px solid #eee; }
        .item-details h4 { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; margin-bottom: 4px; }
        .item-details p { font-size: 12px; color: var(--text-light); }
        .item-price { margin-left: auto; font-weight: 700; color: var(--gold); font-size: 15px; }

        .total-row { border-top: 1px solid var(--text-main); padding-top: 25px; margin-top: 20px; display: flex; justify-content: space-between; align-items: center; }
        .total-row span:first-child { text-transform: uppercase; letter-spacing: 2px; font-size: 12px; font-weight: 700; }
        .total-row span:last-child { font-size: 28px; font-weight: 700; color: var(--text-main); }

        .radio-group { display: flex; gap: 15px; margin-top: 15px; }
        .radio-item { flex: 1; }
        .radio-item input { display: none; }
        .radio-item label { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 15px; border: 1px solid #eee; cursor: pointer; font-weight: 700; font-size: 10px; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; border-radius: 4px; }
        .radio-item input:checked + label { border-color: var(--gold); color: var(--gold); background: #fffdf9; }

        .qr-box { text-align: center; margin-top: 25px; display: none; padding: 25px; background: #fffdf9; border: 1px solid #fef3c7; border-radius: 4px; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from{opacity:0; transform:translateY(10px)} to{opacity:1; transform:translateY(0)} }
        .qr-box img { width: 150px; margin-bottom: 15px; mix-blend-mode: multiply; }
        
        .bank-details { text-align: left; font-size: 12px; border-left: 3px solid var(--gold); padding-left: 15px; line-height: 1.8; }
        .bank-details b { color: var(--text-main); font-weight: 700; }

        .btn-confirm { width: 100%; padding: 20px; background: var(--text-main); color: var(--gold); border: none; font-size: 12px; font-weight: 700; letter-spacing: 3px; cursor: pointer; transition: 0.4s; margin-top: 30px; text-transform: uppercase; border-radius: 4px; }
        .btn-confirm:hover { background: #000; transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        
        .back-link { display: block; text-align: center; margin-top: 25px; color: var(--text-light); font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }
        .back-link:hover { color: var(--gold); }

        @media (max-width: 992px) { .checkout-container { grid-template-columns: 1fr; } .col-right { order: -1; } }
    </style>
</head>
<body>

<header class="header">
    <div class="logo"><a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a></div>
</header>

<div class="checkout-container">
    
    {{-- CỘT TRÁI: CẬP NHẬT THÔNG TIN --}}
    <div class="col-left">
        <form action="{{ route('order.update', $order->id) }}" method="POST" id="checkoutForm">
            @csrf
            @method('PUT')
            
            <div class="card">
                <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Thông tin phục vụ</h3>
                
                <div class="form-group">
                    <label>Danh tính Quý khách</label>
                    <input type="text" name="customer_name" class="form-control" 
                           placeholder="Nhập họ và tên..." 
                           value="{{ old('customer_name', $order->customer_name) }}" required>
                </div>

                <div class="form-group">
                    <label>Đường dây liên hệ</label>
                    <input type="text" name="phone" class="form-control" 
                           placeholder="Số điện thoại di động..." 
                           value="{{ old('phone', $order->phone) }}" required>
                </div>

                <div class="form-group">
                    <label>Địa điểm điểm đến</label>
                    <textarea name="address" class="form-control" 
                              placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required>{{ old('address', $order->address) }}</textarea>
                </div>
                
                <div class="form-group" style="margin-bottom:0">
                    <label>Yêu cầu đặc biệt (Ghi chú)</label>
                    <textarea name="note" class="form-control" style="height: 80px;" 
                              placeholder="Ví dụ: Không hành, giao đúng 19:00, hay lời nhắn gửi...">{{ old('note', $order->note) }}</textarea>
                </div>
            </div>
        </form>
    </div>

    {{-- CỘT PHẢI: TÓM TẮT TRẢI NGHIỆM --}}
    <div class="col-right">
        <div class="card" style="position: sticky; top: 120px;">
            <h3 class="section-title"><i class="fas fa-concierge-bell"></i> Thực đơn đã chọn</h3>

            <div class="order-list">
                @foreach($order->items as $item)
                    @php 
                        // ĐỒNG BỘ LOGIC ẢNH VỚI TRANG MENU VÀ ADMIN
                        $img = $item->food->image ?? '';
                        if ($img && Str::startsWith($img, 'http')) {
                            $displayImg = $img;
                        } elseif ($img) {
                            $cleanName = str_replace('foods/', '', $img);
                            $displayImg = asset('foods/' . $cleanName);
                        } else {
                            $displayImg = asset('foods/default.jpg');
                        }
                    @endphp

                    <div class="order-item">
                        <img src="{{ $displayImg }}" class="item-img" alt="Món ăn" onerror="this.src='https://placehold.co/100x100?text=Signature'">
                        <div class="item-details">
                            <h4>{{ $item->food->name ?? 'Món Signature' }}</h4>
                            <p>Số lượng: <b>{{ $item->quantity }}</b></p>
                        </div>
                        <div class="item-price">{{ number_format($item->price * $item->quantity) }}đ</div>
                    </div>
                @endforeach
            </div>

            <div class="total-row">
                <span>Tổng giá trị</span>
                <span class="serif">{{ number_format($order->total_price) }} <small style="font-size:14px; font-weight:500;">đ</small></span>
            </div>

            <div class="payment-method" style="margin-top: 40px;">
                <label style="font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-light);">Phương thức thanh toán</label>
                <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" name="payment_method" id="pay_cod" value="cod" checked onchange="toggleQR(false)">
                        <label for="pay_cod"><i class="fas fa-hand-holding-usd" style="font-size: 18px; margin-bottom:5px"></i> Tiền mặt</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" name="payment_method" id="pay_qr" value="qr" onchange="toggleQR(true)">
                        <label for="pay_qr"><i class="fas fa-qrcode" style="font-size: 18px; margin-bottom:5px"></i> Chuyển khoản</label>
                    </div>
                </div>

                <div id="qrBox" class="qr-box">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TTDSIGNATURE_{{ $order->id }}" alt="QR Payment">
                    <div class="bank-details">
                        <p>🏦 Hệ thống: <b>Vietcombank</b></p>
                        <p>💳 Số tài khoản: <b>0123 4567 8999</b></p>
                        <p>👤 Chủ tài khoản: <b>TTD SIGNATURE</b></p>
                        <p>📝 Nội dung: <b>TTDS {{ $order->id }}</b></p>
                    </div>
                </div>
            </div>

            <button type="button" onclick="confirmAndSubmit()" class="btn-confirm" id="btnConfirm">
                Xác nhận trải nghiệm
            </button>
            
            <a href="{{ route('menu') }}" class="back-link"><i class="fas fa-chevron-left"></i> Tiếp tục chọn món</a>
        </div>
    </div>
</div>

<script>
    function toggleQR(show) {
        document.getElementById('qrBox').style.display = show ? 'block' : 'none';
    }

    function confirmAndSubmit() {
        const btn = document.getElementById('btnConfirm');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang khởi tạo...';
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.7';
        
        // Gửi form
        document.getElementById('checkoutForm').submit();
    }
</script>

</body>
</html>