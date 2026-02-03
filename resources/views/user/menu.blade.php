<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực đơn - TTDFood</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
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
            display: none;
            z-index: 999;
        }

        .search-item {
            display: block;
            padding: 10px 14px;
            text-decoration: none;
            color: #333;
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

    <!-- 🔍 SEARCH FORM -->
    <form action="{{ route('search.food') }}" method="GET" class="search-box">
        <input
            type="text"
            name="keyword"
            id="searchFood"
            value="{{ request('keyword') }}"
            placeholder="🔍 Tìm món ăn..."
            autocomplete="off"
        >
        <div id="searchResult"></div>
    </form>

    @auth
        <a href="{{ route('orders') }}" class="btn-login">📦 Đơn hàng của bạn</a>
        <a href="{{ route('cart') }}" class="btn-login">🛒 Giỏ hàng</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn-login">Đăng xuất</button>
        </form>
    @endauth
</header>

<!-- ===== CATEGORY ===== -->


<div style="text-align:center; margin:20px 0;">
    <a href="{{ route('menu') }}" class="btn-login">🍽 Tất cả</a>
    <a href="{{ route('menu.category','Đồ uống') }}" class="btn-login">🥤 Đồ uống</a>
    <a href="{{ route('menu.category','Món chính') }}" class="btn-login">🍚 Cơm/Món chính</a>
    <a href="{{ route('menu.category','Fast Food') }}" class="btn-login">🍔 Đồ ăn nhanh</a>

</div>

<section class="menu">

    {{-- ❌ KHÔNG HIỆN "THỰC ĐƠN HÔM NAY" KHI TÌM KIẾM --}}
    @if(!request()->has('keyword'))
        
    @endif

    @if($foods->count() == 0)
        <p style="text-align:center">Không tìm thấy món phù hợp</p>
    @else
        <div class="food-grid">
            @foreach($foods as $food)
                <div class="food-card">
                    <a href="javascript:void(0)" onclick="openModal({{ json_encode($food) }})">
                        <img
                            src="{{ $food->image
                                ? (Str::startsWith($food->image, 'foods/') ? asset($food->image) : asset('storage/'.$food->image))
                                : asset('foods/burger.jpg')
                            }}"
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

                            <!-- THÊM VÀO GIỎ -->
                            <form action="{{ route('cart.add', $food->id) }}" method="POST" style="margin-bottom:6px;" onsubmit="addToCart(event, this)">
                                @csrf
                                <button type="submit" class="btn-add">
                                    🛒 Thêm vào giỏ hàng
                                </button>
                            </form>

                            <!-- ĐẶT MÓN -->
                            <form action="{{ route('buy.now', $food->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add" style="background:#ff6f00;">
                                    ⚡ Đặt món
                                </button>
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

<!-- ===== JS SEARCH AUTOCOMPLETE ===== -->
<script>
const input = document.getElementById('searchFood');
const resultBox = document.getElementById('searchResult');
let timeout = null;

input.addEventListener('keyup', function () {
    const keyword = this.value.trim();
    clearTimeout(timeout);

    if (!keyword) {
        resultBox.style.display = 'none';
        resultBox.innerHTML = '';
        return;
    }

    timeout = setTimeout(() => {
        fetch(`/search-food?keyword=${encodeURIComponent(keyword)}`)
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

document.addEventListener('click', e => {
    if (!e.target.closest('.search-box')) {
        resultBox.style.display = 'none';
    }
});
</script>

<div id="toast" class="toast">Thêm vào giỏ hàng thành công!</div>

<!-- ===== FOOD DETAIL MODAL ===== -->
<div id="foodModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        
        <div class="modal-left">
            <img id="m_image" src="" alt="">
        </div>

        <div class="modal-right">
            <h2 id="m_name"></h2>
            <span class="price" id="m_price"></span>
            <p class="desc" id="m_desc"></p>

            <!-- CHỌN SỐ LƯỢNG -->
            <div class="qty-box">
                <button type="button" onclick="changeQty(-1)">−</button>
                <input type="text" id="m_qty" value="1" readonly>
                <button type="button" onclick="changeQty(1)">+</button>
            </div>

            <!-- BUTTONS -->
            <div class="modal-actions">
                <form id="form_add_cart" method="POST" style="flex:1;" onsubmit="addToCart(event, this)">
                    @csrf
                    <input type="hidden" name="qty" id="input_qty_cart" value="1">
                    <button type="submit" class="btn-cart">🛒 Thêm vào giỏ</button>
                </form>

                <form id="form_buy_now" method="POST" style="flex:1;">
                    @csrf
                    <input type="hidden" name="qty" id="input_qty_buy" value="1">
                    <button type="submit" class="btn-buy">⚡ Đặt ngay</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("foodModal");
    const mImage = document.getElementById("m_image");
    const mName = document.getElementById("m_name");
    const mPrice = document.getElementById("m_price");
    const mDesc = document.getElementById("m_desc");
    const mQty = document.getElementById("m_qty");
    
    // Forms
    const formAdd = document.getElementById("form_add_cart");
    const formBuy = document.getElementById("form_buy_now");
    const inputQtyCart = document.getElementById("input_qty_cart");
    const inputQtyBuy = document.getElementById("input_qty_buy");

    function openModal(food) {
        // Reset qty
        mQty.value = 1;
        inputQtyCart.value = 1;
        inputQtyBuy.value = 1;

        // Fill data
        mName.innerText = food.name;
        mPrice.innerText = new Intl.NumberFormat('vi-VN').format(food.price) + " đ";
        mDesc.innerText = food.description || "Món ăn ngon – phục vụ nóng hổi 🍽️";
        
        // Handle Image Path
        let imgSrc = "{{ asset('foods/burger.jpg') }}";
        if (food.image) {
            if (food.image.startsWith('http')) {
                imgSrc = food.image;
            } else if (food.image.startsWith('foods/')) {
                imgSrc = `/${food.image}`;
            } else {
                imgSrc = `/storage/${food.image}`;
            }
        }
        mImage.src = imgSrc;
        


        // Update Form Action
        let actionUrl = "{{ route('cart.add', ':id') }}";
        actionUrl = actionUrl.replace(':id', food.id);
        
        let buyUrl = "{{ route('buy.now', ':id') }}";
        buyUrl = buyUrl.replace(':id', food.id);
        
        formAdd.action = actionUrl;
        formBuy.action = buyUrl;

        // Show
        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // Close when click outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    // Qty Logic
    function changeQty(step) {
        let current = parseInt(mQty.value);
        let newValue = current + step;
        if (newValue < 1) newValue = 1;

        mQty.value = newValue;
        inputQtyCart.value = newValue;
        inputQtyBuy.value = newValue;
    }

    // AJAX Add To Cart
    function addToCart(event, form) {
        event.preventDefault(); // Prevent default submission

        const url = form.action;
        const formData = new FormData(form);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || "Thêm vào giỏ hàng thành công!");
                // Optional: Update cart count if you have one
            } else {
                window.location.href = "{{ route('cart') }}"; // Fallback
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback for non-logged in or errors
             window.location.href = "{{ route('login') }}";
        });
    }

    function showToast(message) {
        const toast = document.getElementById("toast");
        toast.innerText = message;
        toast.className = "toast show success";
        setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);
    }
</script>

</body>
</html>
