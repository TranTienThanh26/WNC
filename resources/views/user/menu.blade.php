<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTD.Signature | Thực Đơn Tinh Hoa</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #fcfcfc;
            --bg-card: #ffffff;
            --color-main: #1a1a1a;
            --color-gold: #c5a059;
            --color-gray: #777777;
            --shadow-soft: 0 15px 40px rgba(0,0,0,0.05);
            --shadow-hover: 0 20px 50px rgba(0,0,0,0.1);
            --shadow-search: 0 15px 35px rgba(0,0,0,0.2);
            --radius: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color: var(--bg-body); 
            color: var(--color-main); 
            font-family: 'Manrope', sans-serif; 
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; transition: 0.3s; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }

        /* --- HEADER --- */
        .header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 6%; background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px); 
            position: sticky; top: 0; z-index: 1000; height: 80px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .logo a { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: var(--color-main); letter-spacing: -0.5px; }
        .logo i { color: var(--color-gold); margin-right: 5px; }

        .nav-right { display: flex; align-items: center; gap: 30px; font-size: 14px; font-weight: 500; }
        .nav-item:hover { color: var(--color-gold); }
        
        .btn-login { 
            border: 1px solid var(--color-main); padding: 8px 24px; 
            border-radius: 30px; transition: 0.3s; font-weight: 600; font-size: 13px;
        }
        .btn-login:hover { background: var(--color-main); color: #fff; }

        /* --- HERO & NỔI BẬT TÌM KIẾM --- */
        .hero {
    position: relative; height: 450px;
    /* Cập nhật ảnh nền tối màu, chiều sâu để nổi bật thanh Search trắng */
    background: url('https://images.unsplash.com/photo-1514362545857-3bc16549766b?q=80&w=1920&auto=format&fit=crop') center/cover no-repeat fixed;
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    text-align: center; color: white;
}
        .hero::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); }
        
        .hero-content { position: relative; z-index: 2; width: 100%; max-width: 800px; padding: 0 20px; }
        .hero h2 { font-size: 3.2rem; margin-bottom: 15px; font-weight: 400; letter-spacing: 1px; }
        .hero p { font-size: 1.1rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; font-style: italic; font-family: 'Playfair Display', serif;}
        
        /* Pill Search nổi bật trên Banner */
        .search-pill {
            background: white; border-radius: 50px; padding: 8px 8px 8px 25px;
            display: flex; align-items: center; width: 100%; max-width: 550px; margin: 0 auto;
            box-shadow: var(--shadow-search);
            transition: 0.3s;
        }
        .search-pill:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .search-pill input { 
            flex: 1; border: none; outline: none; font-size: 16px; color: var(--color-main); font-family: 'Manrope', sans-serif;
        }
        .btn-search { 
            width: 50px; height: 50px; border-radius: 50%; background: var(--color-main); 
            color: white; border: none; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .btn-search:hover { background: var(--color-gold); }

        /* --- ADDRESS STRIP --- */
        .address-strip {
            background: white; padding: 15px 6%; border-bottom: 1px solid rgba(0,0,0,0.03);
            display: flex; justify-content: center; align-items: center;
        }
        .address-compact {
            display: flex; align-items: center; 
            border-bottom: 1px solid #ddd; width: 100%; max-width: 500px; padding-bottom: 5px;
        }
        .address-compact input { border: none; background: transparent; flex: 1; outline: none; font-size: 14px; padding: 0 10px; color: var(--color-main); }
        .btn-loc-small { background: none; border: none; color: var(--color-gold); cursor: pointer; font-size: 18px; }
        .btn-find-small { background: none; border: none; color: var(--color-main); font-weight: 700; text-transform: uppercase; font-size: 12px; cursor: pointer; }

        /* --- CATEGORY BAR (SẮP XẾP LẠI) --- */
        .category-bar { 
            display: flex; justify-content: center; gap: 40px; 
            padding: 40px 0; border-bottom: 1px solid rgba(0,0,0,0.05); margin-bottom: 40px;
        }
        .cat-link { 
            font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; 
            color: var(--color-gray); font-weight: 600; position: relative; padding-bottom: 5px;
        }
        .cat-link:hover, .cat-link.active { color: var(--color-main); }
        .cat-link.active::after { 
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 2px; background: var(--color-gold); 
        }

        /* --- FOOD GRID --- */
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header h3 { font-size: 32px; font-weight: 600; color: var(--color-main); }
        .separator { width: 60px; height: 2px; background: var(--color-gold); margin: 15px auto; }

        .food-grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 45px; padding: 0 6% 80px; 
        }
        
        .food-card { 
            background: var(--bg-card); border-radius: var(--radius); 
            transition: 0.4s ease; cursor: pointer; position: relative;
        }
        .food-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-soft); }
        
        .img-container { 
            height: 260px; overflow: hidden; border-radius: var(--radius); position: relative;
            margin-bottom: 20px;
        }
        .img-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s; }
        .food-card:hover .img-container img { transform: scale(1.08); }
        
        .btn-quick-add {
            position: absolute; bottom: 15px; right: 15px;
            width: 42px; height: 42px; background: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); opacity: 0; transform: translateY(10px); transition: 0.3s;
            color: var(--color-main);
        }
        .food-card:hover .btn-quick-add { opacity: 1; transform: translateY(0); }
        .btn-quick-add:hover { background: var(--color-main); color: var(--color-gold); }

        .info-container { text-align: center; padding: 0 10px 15px; }
        .f-name { font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 700; margin-bottom: 8px; color: var(--color-main); }
        .f-price { font-size: 16px; color: var(--color-gold); font-weight: 600; letter-spacing: 0.5px; }

        /* --- MODAL --- */
        .modal { display: none; position: fixed; inset: 0; z-index: 3000; background: rgba(0,0,0,0.65); backdrop-filter: blur(6px); align-items: center; justify-content: center; }
        .modal-box { 
            background: white; width: 950px; display: flex; 
            border-radius: 4px; overflow: hidden; box-shadow: 0 30px 70px rgba(0,0,0,0.3); 
            animation: fadeIn 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        @keyframes fadeIn { from{opacity:0; transform: translateY(30px);} to{opacity:1; transform: translateY(0);} }

        .m-img-wrap { flex: 1.2; height: 550px; background: #f0f0f0; }
        .m-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        
        .m-content { flex: 1; padding: 50px; display: flex; flex-direction: column; justify-content: center; position: relative; }
        .m-close { position: absolute; top: 25px; right: 25px; cursor: pointer; font-size: 26px; color: #bbb; transition: 0.3s; }
        .m-close:hover { color: var(--color-main); transform: rotate(90deg); }
        
        .m-title { font-size: 34px; margin-bottom: 12px; line-height: 1.2; }
        .m-price { font-size: 26px; color: var(--color-gold); font-weight: 600; margin-bottom: 25px; font-family: 'Manrope', sans-serif;}
        .m-desc { color: #666; margin-bottom: 40px; font-size: 15px; line-height: 1.8; }
        
        .qty-control { display: flex; align-items: center; gap: 0; margin-bottom: 35px; border: 1px solid #eee; width: fit-content; border-radius: 40px; padding: 6px; }
        .qty-btn { width: 38px; height: 38px; border-radius: 50%; border: none; background: white; cursor: pointer; font-weight: bold; transition: 0.2s; }
        .qty-btn:hover { background: #f5f5f5; }
        .qty-input { width: 45px; text-align: center; border: none; font-weight: 700; outline: none; font-size: 16px; }

        .m-actions { display: flex; gap: 20px; margin-top: auto; }
        .btn-modal { flex: 1; padding: 16px; text-align: center; border: none; cursor: pointer; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; transition: 0.3s; }
        .btn-outline { border: 1px solid #ddd; background: transparent; color: var(--color-main); }
        .btn-outline:hover { border-color: var(--color-main); background: #fafafa; }
        .btn-fill { background: var(--color-main); color: var(--color-gold); }
        .btn-fill:hover { background: #000; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

        .toast { position: fixed; bottom: 35px; right: 35px; background: var(--color-main); color: white; padding: 16px 35px; font-size: 13px; font-weight: 600; letter-spacing: 1px; border-left: 4px solid var(--color-gold); transform: translateY(120px); transition: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 4000; }
        .toast.show { transform: translateY(0); }

        @media (max-width: 768px) {
            .header { padding: 15px 5%; }
            .hero h2 { font-size: 2.2rem; }
            .hero p { font-size: 1rem; }
            .modal-box { flex-direction: column; width: 95%; height: 90vh; overflow-y: auto; }
            .m-img-wrap { height: 250px; flex: none; }
            .m-content { padding: 30px; }
            .category-bar { gap: 20px; overflow-x: auto; justify-content: flex-start; padding: 25px 5%; }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}"><i class="fas fa-crown"></i> TTD.Signature</a>
    </div>

    <div class="nav-right">
        @auth
            <a href="{{ route('cart') }}" class="nav-item">Giỏ hàng</a>
            <a href="{{ route('orders') }}" class="nav-item">Lịch sử</a>
            <div style="width:1px; height:15px; background:#ddd; margin: 0 5px;"></div>
            <span style="font-weight: 700;">{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button style="background:none; border:none; color:#999; cursor:pointer; font-size:18px; margin-left:15px;"><i class="fas fa-power-off"></i></button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-login">ĐĂNG NHẬP</a>
        @endauth
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="serif">Mỹ Vị Đương Đại</h2>
        <p>Hành trình khám phá tinh hoa ẩm thực</p>
        
        <form action="{{ route('search.food') }}" method="GET" class="search-pill">
            <input type="text" name="keyword" placeholder="Tìm kiếm món ăn yêu thích của bạn..." value="{{ request('keyword') }}">
            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
        </form>
    </div>
</section>

<<div class="address-strip">
    <div class="address-compact">
        <button type="button" onclick="getLocation()" class="btn-loc-small" title="Vị trí của tôi">
            <i class="fas fa-map-marker-alt"></i>
        </button>
        <form action="{{ route('menu') }}" method="GET" id="locationFilterForm" style="display: flex; flex: 1; align-items: center;">
            <input type="text" name="address" id="addressInput" 
                   placeholder="Nhập địa chỉ/thành phố để xem thực đơn tại đó..." 
                   value="{{ request('address') }}">
            <button type="submit" class="btn-find-small">Xác nhận</button>
        </form>
    </div>
    <span id="geoStatus" style="font-size: 12px; margin-left: 15px; color: var(--color-gold); font-style: italic;">
        @if(request('address'))
            <i class="fas fa-check"></i> Đang hiển thị món tại: {{ request('address') }}
        @endif
    </span>
</div>

<div class="category-bar">
    <a href="{{ route('menu') }}" class="cat-link {{ !isset($category) && !request('keyword') ? 'active' : '' }}">Tất cả</a>
    <a href="{{ route('menu.category', 'khai-vi') }}" class="cat-link {{ isset($category) && $category->slug == 'khai-vi' ? 'active' : '' }}">Khai vị</a>
    <a href="{{ route('menu.category', 'mon-chinh') }}" class="cat-link {{ isset($category) && $category->slug == 'mon-chinh' ? 'active' : '' }}">Món chính</a>
    <a href="{{ route('menu.category', 'trang-mieng') }}" class="cat-link {{ isset($category) && $category->slug == 'trang-mieng' ? 'active' : '' }}">Tráng miệng</a>
    <a href="{{ route('menu.category', 'do-uong') }}" class="cat-link {{ isset($category) && $category->slug == 'do-uong' ? 'active' : '' }}">Đồ uống</a>
</div>

<div class="section-header">
    <h3 class="serif">
        @if(isset($category))
            {{ $category->name }}
        @elseif(request('keyword'))
            Kết quả cho "{{ request('keyword') }}"
        @else
            Thực Đơn Signature
        @endif
    </h3>
    <div class="separator"></div>
</div>

@if($foods->count() == 0)
    <div style="text-align: center; padding: 100px; color: var(--color-gray);">
        <i class="fas fa-utensils" style="font-size: 40px; margin-bottom: 20px; opacity: 0.3;"></i>
        <p class="serif" style="font-size: 20px;">Không tìm thấy món ăn phù hợp.</p>
        <a href="{{ route('menu') }}" style="color: var(--color-gold); text-decoration: underline; margin-top: 10px; display: block;">Quay lại thực đơn</a>
    </div>
@else
<div class="food-grid">
    @foreach($foods as $food)
    <div class="food-card" onclick="openModal({{ json_encode($food) }})">
        <div class="img-container">
            @php
                $img = $food->image;
                if ($img && Str::startsWith($img, 'http')) {
                    $url = $img;
                } elseif ($img) {
                    // Trỏ thẳng vào public/foods/ vì ảnh bạn nằm ở đó
                    $cleanName = str_replace('foods/', '', $img);
                    $url = asset('foods/' . $cleanName);
                } else {
                    $url = asset('foods/default.jpg');
                }
            @endphp
            <img src="{{ $url }}" alt="{{ $food->name }}" onerror="this.src='https://placehold.co/600x800?text=Signature+Food'">
            <div class="btn-quick-add"><i class="fas fa-plus"></i></div>
        </div>
        {{-- Phần thông tin phải nằm TRONG food-card --}}
        <div class="info-container">
            <div class="f-name">{{ $food->name }}</div>
            <div class="f-price">{{ number_format($food->price) }} VNĐ</div>
        </div>
    </div>
    @endforeach
</div>

    <div style="display: flex; justify-content: center; margin-bottom: 80px;">
        {{ $foods->links('pagination::bootstrap-4') }}
    </div>
@endif

<div id="productModal" class="modal" onclick="if(event.target==this) closeM()">
    <div class="modal-box">
        <div class="m-img-wrap">
            <img id="mImg" src="">
        </div>
        <div class="m-content">
            <span class="m-close" onclick="closeM()">&times;</span>
            <h2 id="mName" class="m-title serif"></h2>
            <div id="mPrice" class="m-price"></div>
            <p id="mDesc" class="m-desc"></p>
            
            <div class="qty-control">
                <button class="qty-btn" onclick="changeQty(-1)">-</button>
                <input type="text" id="m_qty" value="1" class="qty-input" readonly>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>

            <div class="m-actions">
                @auth
                    <form id="formCart" method="POST" style="flex:1" onsubmit="handleAction(event, this)">
                        @csrf <input type="hidden" name="qty" id="input_qty_cart" value="1">
                        <button class="btn-modal btn-outline">THÊM GIỎ HÀNG</button>
                    </form>
                    <form id="formBuy" method="POST" style="flex:1" onsubmit="handleAction(event, this)">
                        @csrf <input type="hidden" name="qty" id="input_qty_buy" value="1">
                        <button class="btn-modal btn-fill">ĐẶT MÓN NGAY</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-modal btn-fill" style="display:block; text-decoration:none;">ĐĂNG NHẬP ĐỂ ĐẶT</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div id="toast" class="toast"><i class="fas fa-check-circle" style="color: var(--color-gold); margin-right: 10px;"></i> ĐÃ THÊM VÀO GIỎ HÀNG</div>

<script>
    function getLocation() {
    const s = document.getElementById('geoStatus'); 
    const i = document.getElementById('addressInput');
    const form = document.getElementById('locationFilterForm');

    if (!navigator.geolocation) return alert('Trình duyệt không hỗ trợ.');
    
    s.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang định vị...';
    
    navigator.geolocation.getCurrentPosition(
        p => {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${p.coords.latitude}&lon=${p.coords.longitude}&accept-language=vi`)
            .then(r=>r.json()).then(d=>{ 
                // Ưu tiên lấy tên Thành phố hoặc Quận
                const city = d.address.city || d.address.state || d.address.suburb;
                i.value = city;
                s.innerHTML = '<i class="fas fa-check"></i> Đã tìm thấy: ' + city;
                
                // Tự động gửi Form để lọc món ngay lập tức
                setTimeout(() => { form.submit(); }, 500);
            });
        },
        () => s.textContent = 'Không thể lấy vị trí.'
    );
}

    const modal = document.getElementById("productModal");
    const mQty = document.getElementById("m_qty");
    const iQtyCart = document.getElementById("input_qty_cart");
    const iQtyBuy = document.getElementById("input_qty_buy");

    // SỬA ĐOẠN NÀY TRONG HÀM openModal ĐỂ HIỆN ẢNH MODAL
    function openModal(f) {
    mQty.value = 1; iQtyCart.value = 1; iQtyBuy.value = 1;
    document.getElementById("mName").innerText = f.name;
    document.getElementById("mPrice").innerText = new Intl.NumberFormat('vi-VN').format(f.price) + " VNĐ";
    document.getElementById("mDesc").innerText = f.description || "Hương vị tuyệt hảo được chế biến công phu bởi đầu bếp hàng đầu.";
    
    // Logic trỏ thẳng vào thư mục public/foods
    let imgSrc = "https://placehold.co/600x800?text=Signature+Food";
    if(f.image) {
        if(f.image.startsWith('http')) {
            imgSrc = f.image;
        } else {
            // Sửa tại đây: Bỏ tiền tố /storage/ vì ảnh nằm ở public/foods
            let cleanPath = f.image.replace('foods/', '');
            imgSrc = '/foods/' + cleanPath; 
        }
    }
    document.getElementById("mImg").src = imgSrc;

    document.getElementById("formCart").action = "{{ route('cart.add', ':id') }}".replace(':id', f.id);
    document.getElementById("formBuy").action = "{{ route('cart.buyNow', ':id') }}".replace(':id', f.id);
    
    modal.style.display = "flex";
}

    function closeM() { modal.style.display = "none"; }

    function changeQty(n){ 
        let v = parseInt(mQty.value) + n; 
        if(v < 1) v = 1; 
        mQty.value = v; 
        iQtyCart.value = v; 
        iQtyBuy.value = v; 
    }

    function handleAction(e, form) {
        e.preventDefault();
        const btn = form.querySelector('button');
        const oldText = btn.innerText;
        btn.innerText = "ĐANG XỬ LÝ...";
        
        fetch(form.action, {
            method: 'POST', body: new FormData(form), headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(r => r.json())
        .then(d => {
            btn.innerText = oldText;
            if(d.redirect) window.location.href = d.redirect;
            if(d.success) {
                const toast = document.getElementById("toast");
                toast.classList.add("show");
                setTimeout(() => toast.classList.remove("show"), 3000);
                closeM();
            }
        });
    }
</script>

</body>
</html>