<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTD.Signature | Ẩm Thực Thượng Hạng</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- 1. THIẾT LẬP MÀU SẮC SANG TRỌNG (GIỮ NGUYÊN) --- */
        :root {
            --bg-body: #fcfcfc;      /* Trắng kem nhẹ */
            --bg-card: #ffffff;
            --color-main: #1a1a1a;   /* Đen than */
            --color-gold: #c5a059;   /* Vàng đồng sang trọng */
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

        /* --- 2. HEADER MINIMALIST (GIỮ NGUYÊN) --- */
        .header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 6%; background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px); 
            position: sticky; top: 0; z-index: 1000; height: 80px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .logo a { 
            font-family: 'Playfair Display', serif; 
            font-size: 24px; font-weight: 700; color: var(--color-main); 
            letter-spacing: -0.5px;
        }
        .logo i { color: var(--color-gold); margin-right: 5px; }

        .nav-right { display: flex; align-items: center; gap: 30px; font-size: 14px; font-weight: 500; }
        .nav-item { position: relative; color: var(--color-main); }
        .nav-item:hover { color: var(--color-gold); }
        
        .btn-login { 
            border: 1px solid var(--color-main); padding: 8px 24px; 
            border-radius: 30px; transition: 0.3s; font-weight: 600; font-size: 13px;
        }
        .btn-login:hover { background: var(--color-main); color: #fff; }

        /* --- 3. HERO SECTION & COMPACT SEARCH (GIỮ NGUYÊN ẢNH XỊN) --- */
        .hero {
            position: relative; height: 480px;
            background: url('https://images.unsplash.com/photo-1514362545857-3bc16549766b?q=80&w=1920&auto=format&fit=crop') center/cover no-repeat fixed;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center; color: white;
        }
        .hero::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.55); } 
        
        .hero-content { position: relative; z-index: 2; width: 100%; max-width: 800px; padding: 0 20px; }
        .hero h2 { font-size: 3.2rem; margin-bottom: 15px; font-weight: 400; letter-spacing: 1px; }
        .hero p { font-size: 1.1rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; font-style: italic; font-family: 'Playfair Display', serif;}
        
        .search-pill {
            background: white; border-radius: 50px; padding: 8px 8px 8px 25px;
            display: flex; align-items: center; width: 100%; max-width: 550px; margin: 0 auto;
            box-shadow: var(--shadow-search); transition: 0.3s;
        }
        .search-pill:hover { transform: translateY(-3px); }
        .search-pill input { 
            flex: 1; border: none; outline: none; font-size: 16px; color: var(--color-main); font-family: 'Manrope', sans-serif;
        }
        .btn-search { 
            width: 50px; height: 50px; border-radius: 50%; background: var(--color-main); 
            color: white; border: none; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .btn-search:hover { background: var(--color-gold); }

        /* --- 4. THAY ĐỔI: THANH DANH MỤC BIẾN THÀNH NÚT ĐẶT ĐỒ --- */
        .cta-container { 
            display: flex; justify-content: center; 
            padding: 50px 0; border-bottom: 1px solid rgba(0,0,0,0.05); margin-bottom: 40px;
        }
        .btn-order-now {
            padding: 15px 45px; border-radius: 50px; background: var(--color-main); color: var(--color-gold);
            font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 2px;
            transition: 0.4s; border: 1px solid var(--color-gold); box-shadow: var(--shadow-soft);
            display: flex; align-items: center; gap: 12px;
        }
        .btn-order-now:hover { transform: translateY(-3px); background: #000; color: #fff; }

        /* --- 5. FOOD GRID (CHỈ XEM) --- */
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header h3 { font-size: 32px; font-weight: 600; color: var(--color-main); }
        .separator { width: 60px; height: 2px; background: var(--color-gold); margin: 15px auto; }

        .food-grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 40px; padding: 0 6% 80px; 
        }
        
        .food-card { 
            background: var(--bg-card); border-radius: var(--radius); 
            transition: 0.4s ease; cursor: pointer; position: relative;
        }
        .food-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-soft); }
        
        .img-container { 
            height: 240px; overflow: hidden; border-radius: var(--radius); position: relative;
            margin-bottom: 20px;
        }
        .img-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s; }
        .food-card:hover .img-container img { transform: scale(1.08); }
        
        /* Loại bỏ nút + và thay bằng Badge "Xem chi tiết" */
        .view-badge {
            position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.9);
            padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 700;
            color: var(--color-main); text-transform: uppercase; letter-spacing: 1px;
            opacity: 0; transition: 0.3s;
        }
        .food-card:hover .view-badge { opacity: 1; }

        .info-container { text-align: center; padding: 0 10px 15px; }
        .f-name { 
            font-family: 'Playfair Display', serif; font-size: 18px; 
            font-weight: 700; margin-bottom: 8px; color: var(--color-main);
        }
        .f-price { font-size: 16px; color: var(--color-gold); font-weight: 600; letter-spacing: 0.5px; }

        /* --- 6. MODAL (CHỈ XEM - DẪN LINK) --- */
        .modal { display: none; position: fixed; inset: 0; z-index: 3000; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); align-items: center; justify-content: center; }
        .modal-box { 
            background: white; width: 900px; display: flex; 
            border-radius: 4px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.2); 
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn { from{opacity:0; transform: scale(0.95);} to{opacity:1; transform: scale(1);} }

        .m-img-wrap { flex: 1.2; height: 500px; background: #f0f0f0; }
        .m-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        
        .m-content { flex: 1; padding: 50px; display: flex; flex-direction: column; justify-content: center; position: relative; }
        .m-close { position: absolute; top: 20px; right: 20px; cursor: pointer; font-size: 24px; color: #999; }
        
        .m-title { font-size: 30px; margin-bottom: 10px; line-height: 1.2; }
        .m-price { font-size: 24px; color: var(--color-gold); font-weight: 600; margin-bottom: 20px; }
        .m-desc { color: #666; margin-bottom: 40px; font-size: 14px; line-height: 1.8; }
        
        .btn-fill { 
            background: var(--color-main); color: var(--color-gold); 
            padding: 14px; border: none; font-weight: 700; cursor: pointer; 
            text-align: center; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;
        }
        .btn-fill:hover { background: #333; }

        /* TOAST (GIỮ LẠI) */
        .toast { 
            position: fixed; bottom: 30px; right: 30px; 
            background: var(--color-main); color: white; padding: 15px 30px; 
            font-size: 13px; letter-spacing: 0.5px; border-left: 3px solid var(--color-gold);
            transform: translateY(100px); transition: 0.4s; z-index: 4000;
        }
        .toast.show { transform: translateY(0); }

        @media (max-width: 768px) {
            .modal-box { flex-direction: column; width: 95%; height: 90vh; overflow-y: auto; }
            .m-img-wrap { height: 250px; flex: none; }
            .hero h2 { font-size: 2rem; }
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
        <a href="{{ route('cart') }}" class="nav-item">GIỎ HÀNG</a>
        <a href="{{ route('orders') }}" class="nav-item">LỊCH SỬ</a>
        <span style="color: var(--color-gold); font-weight: 600; font-size: 13px;">
             <i class="fas fa-user"></i> {{ Auth::user()->name }}
        </span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; border:none; color:#999; cursor:pointer; font-size:18px; margin-left:10px;">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn-login">ĐĂNG NHẬP</a>
    @endauth
</div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="serif">Trải nghiệm ẩm thực tinh hoa</h2>
        <p>Hương vị đánh thức mọi giác quan của bạn</p>
        
        <form action="{{ route('search.food') }}" method="GET" class="search-pill">
            <input type="text" name="keyword" placeholder="Bạn muốn thưởng thức món gì?..." value="{{ request('keyword') }}">
            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
        </form>
    </div>
</section>

<div class="cta-container">
    <a href="{{ route('menu') }}" class="btn-order-now">
        <i class="fas fa-concierge-bell"></i> Đặt đồ ngay
    </a>
</div>

<div class="section-header">
    <h3 class="serif">Thực Đơn Hôm Nay</h3>
    <div class="separator"></div>
</div>

<div class="food-grid">
    @if(isset($foods) && $foods->count() > 0)
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
                        $url = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800';
                    }
                @endphp
                <img src="{{ $url }}" 
                     onerror="this.src='https://placehold.co/600x800?text=Signature+Food'" 
                     alt="{{ $food->name }}">
                <div class="view-badge">Chi tiết</div>
            </div>
            <div class="info-container">
                <div class="f-name">{{ $food->name }}</div>
                <div class="f-price">{{ number_format($food->price) }} VNĐ</div>
            </div>
        </div>
        @endforeach
    @else
        {{-- Món Demo khi chưa có dữ liệu --}}
        <div class="food-card">
            <div class="img-container">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=800" alt="Demo">
                <div class="view-badge">Chi tiết</div>
            </div>
            <div class="info-container">
                <div class="f-name">Thăn Bò Ribeye Nướng Củi</div>
                <div class="f-price">1.450.000 VNĐ</div>
            </div>
        </div>
    @endif
</div>

<div id="productModal" class="modal" onclick="if(event.target==this) closeM()">
    <div class="modal-box">
        <div class="m-img-wrap"><img id="mImg" src=""></div>
        <div class="m-content">
            <span class="m-close" onclick="closeM()">&times;</span>
            <h2 id="mName" class="m-title serif">Tên Món</h2>
            <div id="mPrice" class="m-price">0 VNĐ</div>
            <p id="mDesc" class="m-desc">Hương vị tuyệt hảo được chế biến công phu bởi đầu bếp hàng đầu.</p>
            
            <a href="{{ route('menu') }}" class="btn-fill">ĐI ĐẾN THỰC ĐƠN ĐỂ ĐẶT MÓN</a>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("productModal");

    // Hàm Mở Modal
    function openModal(f) {
        document.getElementById("mName").innerText = f.name;
        document.getElementById("mPrice").innerText = new Intl.NumberFormat('vi-VN').format(f.price) + " VNĐ";
        document.getElementById("mDesc").innerText = f.description || "Một kiệt tác ẩm thực được chế biến tinh tế.";
        
        let imgSrc = 'https://placehold.co/600x800?text=No+Image';
        if(f.image) {
            if(f.image.startsWith('http')) {
                imgSrc = f.image;
            } else {
                let cleanPath = f.image.replace('foods/', '');
                imgSrc = window.location.origin + '/foods/' + cleanPath; 
            }
        }
        
        const imgElement = document.getElementById("mImg");
        imgElement.src = imgSrc;
        
        imgElement.onerror = function() {
            this.src = 'https://placehold.co/600x800?text=Image+Not+Found';
        };

        modal.style.display = "flex";
    }

    // --- ĐÂY LÀ HÀM BẠN ĐANG THIẾU ---
    function closeM() {
        modal.style.display = "none";
    }

    // Đóng modal khi nhấn phím Escape trên bàn phím Mac
    window.onkeydown = function(event) {
        if (event.key === "Escape") {
            closeM();
        }
    };
</script>

</body>
</html>