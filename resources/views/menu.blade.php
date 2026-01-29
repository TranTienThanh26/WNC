<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực đơn - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        /* ===== SEARCH AUTOCOMPLETE ===== */
        .search-box {
            position: relative;
            width: 260px;
        }

        .search-box input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 20px;
            border: none;
            outline: none;
        }

        #searchResult {
            position: absolute;
            top: 42px;
            left: 0;
            width: 100%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            overflow: hidden;
            display: none;
            z-index: 999;
        }

        .search-item {
            display: block;
            padding: 10px 14px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .search-item:hover {
            background: #facc15;
        }

        .search-item span {
            float: right;
            color: #ff6a00;
            font-weight: 600;
        }

        .search-empty {
            padding: 10px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}" style="color:white;text-decoration:none">
            TTDFood
        </a>
    </div>

    <!-- 🔍 SEARCH -->
    <div class="search-box">
    <input 
        type="text" 
        id="searchFood"
        placeholder="🔍 Tìm món ăn..."
        autocomplete="off"
    >
    <div id="searchResult"></div>
</div>


    @auth
        <a href="{{ route('cart') }}" class="btn-login">🛒 Giỏ hàng</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn-login">Đăng xuất</button>
        </form>
    @endauth
</header>

<!-- ===== MENU ===== -->
 <input type="text" id="searchFood" placeholder="🔍 Tìm món ăn...">
<!-- ===== CATEGORY FILTER ===== -->
<div style="text-align:center; margin:20px 0;">
    <a href="{{ route('menu') }}" class="btn-login">🍽 Tất cả</a>
    <a href="{{ route('menu.category', 'do-uong') }}" class="btn-login">🥤 Đồ uống</a>
    <a href="{{ route('menu.category', 'com') }}" class="btn-login">🍚 Cơm</a>
    <a href="{{ route('menu.category', 'thuc-an-nhanh') }}" class="btn-login">🍔 Thức ăn nhanh</a>
</div>

<section class="menu">
    <h2>📋 Thực đơn hôm nay</h2>

    @if($foods->count() == 0)
        <p>Chưa có món ăn nào</p>
    @else
        <div class="food-grid">
           @foreach($foods as $food)
    <div class="food-card" data-name="{{ strtolower($food->name) }}">


                    <!-- CLICK ẢNH → CHI TIẾT -->
                    <a href="{{ route('food.show', $food->id) }}">
                        <img
                            src="{{ $food->image ?? 'https://source.unsplash.com/400x300/?food' }}"
                            alt="{{ $food->name }}"
                        >
                    </a>

                    <div class="food-info">
                        <h3>{{ $food->name }}</h3>

                        <p class="food-desc">
                            {{ $food->description ?? 'Món ăn hấp dẫn – phục vụ nóng hổi' }}
                        </p>

                        <div class="food-bottom">
                            <span class="price">
                                {{ number_format($food->price) }} đ
                            </span>

                            <form action="{{ route('cart.add', $food->id) }}" method="POST">
                                @csrf
                                <button class="btn-add">➕ Đặt món</button>
                            </form>
                            
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

    <br>
    <a href="{{ route('home') }}" class="btn-back">⬅ Quay lại trang chủ</a>
</section>

<!-- ===== JS SEARCH REALTIME ===== -->
<script>
const input = document.getElementById('searchFood');
const resultBox = document.getElementById('searchResult');
let timeout = null;

input.addEventListener('keyup', function () {
    const keyword = this.value.trim();
    clearTimeout(timeout);

    if (keyword.length === 0) {
        resultBox.style.display = 'none';
        resultBox.innerHTML = '';
        return;
    }

    timeout = setTimeout(() => {
        fetch(`/search-food?q=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    resultBox.innerHTML = `<div class="search-empty">Không tìm thấy món</div>`;
                } else {
                    let html = '';
                    data.forEach(item => {
                        html += `
                            <a href="/food/${item.id}" class="search-item">
                                ${item.name}
                                <span>${Number(item.price).toLocaleString()} đ</span>
                            </a>
                        `;
                    });
                    resultBox.innerHTML = html;
                }
                resultBox.style.display = 'block';
            });
    }, 300);
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-box')) {
        resultBox.style.display = 'none';
    }
});
</script>
<script>
const input = document.getElementById('searchFood');
const foods = document.querySelectorAll('.food-card');

input.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();

    foods.forEach(food => {
        const name = food.dataset.name;
        food.style.display = name.includes(keyword) ? 'block' : 'none';
    });
});
</script>

</body>
</html>
