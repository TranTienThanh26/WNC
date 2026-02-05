<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | TTD.Signature</title>
    
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
            --radius: 8px;
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

        /* --- 3. CART CONTAINER --- */
        .cart-container { max-width: 1100px; margin: 60px auto; padding: 0 5%; }
        .page-title { 
            font-size: 32px; margin-bottom: 40px; font-family: 'Playfair Display', serif; 
            font-weight: 500; text-align: center; color: var(--text-main); 
        }
        .page-title span { color: var(--gold); font-style: italic; }
        
        /* EMPTY STATE */
        .empty-cart { 
            text-align: center; padding: 80px 40px; background: var(--bg-card); 
            border-radius: var(--radius); box-shadow: var(--shadow); 
        }
        .empty-cart i { font-size: 50px; color: #eee; margin-bottom: 25px; }
        .empty-cart p { font-size: 16px; color: var(--text-light); margin-bottom: 30px; letter-spacing: 0.5px; }
        .btn-go-menu { 
            padding: 12px 35px; background: var(--text-main); color: var(--gold); 
            border-radius: 4px; font-weight: 600; text-transform: uppercase; font-size: 12px; 
            letter-spacing: 1px; transition: 0.3s; display: inline-block;
        }
        .btn-go-menu:hover { background: #000; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        /* CART BOX & TABLE */
        .cart-box { background: var(--bg-card); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); border: 1px solid var(--border); }
        .cart-table { width: 100%; border-collapse: collapse; }
        .cart-table th { 
            background: #fafafa; padding: 20px; text-align: left; 
            font-weight: 700; font-size: 11px; text-transform: uppercase; 
            color: var(--text-light); border-bottom: 1px solid var(--border); letter-spacing: 2px;
        }
        .cart-table td { padding: 25px 20px; border-bottom: 1px solid #f8f8f8; vertical-align: middle; }
        
        /* ITEM INFO */
        .item-info { display: flex; align-items: center; gap: 20px; }
        .item-img { width: 85px; height: 85px; border-radius: 4px; object-fit: cover; background: #f9f9f9; border: 1px solid #eee; }
        .item-name { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 18px; color: var(--text-main); display: block; margin-bottom: 5px; }
        .item-price-mobile { display: none; font-size: 14px; color: var(--gold); font-weight: 600; }

        /* QTY CONTROL */
        .qty-control { display: flex; align-items: center; border: 1px solid #eee; border-radius: 30px; width: fit-content; padding: 5px; background: #fff; }
        .qty-btn { 
            width: 30px; height: 30px; border-radius: 50%; background: #fff; cursor: pointer; 
            color: var(--text-main); transition: 0.3s; border: none; font-size: 10px; display: flex; align-items: center; justify-content: center;
        }
        .qty-btn:hover { background: var(--text-main); color: var(--gold); }
        .qty-number { padding: 0 15px; font-weight: 700; font-size: 14px; min-width: 40px; text-align: center; }

        /* PRICE & REMOVE */
        .price-col { font-weight: 700; color: var(--gold); font-size: 16px; letter-spacing: 0.5px; }
        .remove-btn { color: #ccc; font-size: 18px; transition: 0.3s; cursor: pointer; }
        .remove-btn:hover { color: #c53030; transform: rotate(90deg); }

        /* FOOTER ACTION */
        .cart-footer { 
            padding: 40px; background: #fff; display: flex; 
            justify-content: space-between; align-items: center; 
            border-top: 1px solid var(--border); flex-wrap: wrap; gap: 30px; 
        }
        .total-price { font-size: 14px; font-weight: 500; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px; }
        .total-price span { color: var(--text-main); font-size: 32px; font-weight: 700; margin-left: 15px; font-family: 'Manrope', sans-serif; }
        
        .action-group { display: flex; gap: 15px; align-items: center; }
        .btn-back { 
            padding: 14px 25px; border-radius: 4px; border: 1px solid #eee; 
            color: var(--text-light); font-weight: 700; font-size: 11px; 
            text-transform: uppercase; letter-spacing: 1.5px; transition: 0.3s; 
        }
        .btn-back:hover { border-color: var(--text-main); color: var(--text-main); background: #fdfdfd; }
        
        .btn-checkout { 
            padding: 14px 40px; background: var(--text-main); color: var(--gold); 
            border-radius: 4px; font-weight: 700; font-size: 11px; 
            text-transform: uppercase; letter-spacing: 2px; border: none; cursor: pointer; transition: 0.3s; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-checkout:hover { background: #000; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .cart-table thead { display: none; }
            .cart-table tr { display: flex; flex-direction: column; align-items: center; padding: 25px; border-bottom: 1px solid #f8f8f8; position: relative; }
            .cart-table td { padding: 10px; border: none; text-align: center !important; }
            .item-info { flex-direction: column; text-align: center; }
            .col-remove { position: absolute; top: 15px; right: 15px; }
            .item-price-mobile { display: block; }
            .desktop-only { display: none; }
            .cart-footer { flex-direction: column; text-align: center; }
            .action-group { flex-direction: column; width: 100%; }
            .btn-checkout, .btn-back { width: 100%; }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a>
    </div>
    <div class="user-meta">
        @auth
            <a href="{{ route('orders') }}" style="font-weight: 700; margin-right:25px; font-size:11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-light);">Lịch sử đặt món</a>
            <span style="font-weight: 700; font-size:13px; color: var(--gold);">{{ Auth::user()->name }}</span>
        @endauth
    </div>
</header>

<div class="cart-container">
    <h2 class="page-title">Giỏ hàng <span>của bạn</span></h2>

    @if(!$cart || $cart->items->isEmpty())
        <div class="empty-cart">
            <i class="fas fa-concierge-bell"></i>
            <p>Quý khách chưa chọn món ăn nào cho trải nghiệm hôm nay.</p>
            <a href="{{ route('menu') }}" class="btn-go-menu">Khám phá thực đơn</a>
        </div>
    @else

    <div class="cart-box">
        <table class="cart-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Tuyệt phẩm</th>
                    <th style="width: 15%; text-align:center;">Đơn giá</th>
                    <th style="width: 15%; text-align:center;">Số lượng</th>
                    <th style="width: 20%; text-align:right;">Thành tiền</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp

                @foreach($cart->items as $item)
                    @php
                        $sub = $item->price * $item->quantity;
                        $total += $sub;
                        
                        // ĐỒNG BỘ LOGIC LẤY ẢNH VỚI TRANG MENU & ADMIN
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

                    <tr id="row-{{ $item->id }}">
                        <td class="col-info">
                            <div class="item-info">
                                <img src="{{ $dImg }}" class="item-img" alt="Món ăn" onerror="this.src='https://placehold.co/200?text=Signature'">
                                <div>
                                    <span class="item-name">{{ $item->food->name ?? 'Món không tồn tại' }}</span>
                                    <span class="item-price-mobile">{{ number_format($item->price) }}đ</span>
                                </div>
                            </div>
                        </td>

                        <td style="text-align:center;" class="desktop-only price-col">
                            {{ number_format($item->price) }}đ
                        </td>

                        <td class="col-qty">
                            <div style="display:flex; justify-content:center">
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="qty-number" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                        <td class="col-total price-col" style="text-align:right;">
                            <span id="sub-{{ $item->id }}">{{ number_format($sub) }}</span>đ
                        </td>

                        <td class="col-remove" style="text-align:center;">
                            <a href="{{ route('cart.remove', $item->id) }}" class="remove-btn" title="Gỡ bỏ">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-footer">
            <div class="total-price">
                Tổng giá trị trải nghiệm: <span id="cart-total">{{ number_format($total) }}</span> VNĐ
            </div>

            <div class="action-group">
                <a href="{{ route('menu') }}" class="btn-back">
                    Tiếp tục chọn món
                </a>
                
                @if(Route::has('cart.clear'))
                    <a href="{{ route('cart.clear') }}" class="btn-back" style="color:#c53030;" onclick="return confirm('Xóa toàn bộ các món đã chọn?')">
                        Làm trống giỏ
                    </a>
                @endif

                <button onclick="window.location.href='{{ route('checkout') }}'" class="btn-checkout">
                    Tiến hành đặt hàng
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function updateQty(itemId, change) {
        // Hiệu ứng mờ nhẹ khi đang tải
        const qtySpan = document.getElementById(`qty-${itemId}`);
        qtySpan.style.opacity = '0.5';

        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ change: change })
        })
        .then(response => response.json())
        .then(data => {
            qtySpan.style.opacity = '1';
            if (data.success) {
                if (data.action === 'delete') {
                    // Hiệu ứng xóa dòng mượt mà
                    const row = document.getElementById(`row-${itemId}`);
                    row.style.transition = '0.4s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        if (data.cartTotal == 0) location.reload(); 
                    }, 400);
                } else {
                    qtySpan.innerText = data.newQty;
                    document.getElementById(`sub-${itemId}`).innerText = data.itemTotal;
                }
                document.getElementById('cart-total').innerText = data.cartTotal;
            } 
            else if (data.login) {
                window.location.href = "{{ route('login') }}";
            }
        })
        .catch(error => {
            qtySpan.style.opacity = '1';
            console.error('Lỗi Ajax:', error);
        });
    }
</script>

</body>
</html>