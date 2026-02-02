<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>TTDFood - Đặt đồ ăn online</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="header">
    <div class="logo">
        <a href="{{ route('home') }}" style="color:white;text-decoration:none">
            TTDFood
        </a>
    </div>

    <!-- SEARCH -->
<div class="search-box">
    <form action="{{ route('search.food') }}" method="GET">

        <input
            type="text"
            name="keyword"
            placeholder="🔍 Tìm món ăn..."
            value="{{ request('keyword') }}"
        >
    </form>
</div>

    @auth
        <div class="user-box">
            <span>👋 Xin chào, {{ auth()->user()->name }}</span>

            <a href="{{ route('orders') }}" class="btn-login">📦 Đơn hàng của bạn</a>
            <a href="{{ route('cart') }}" class="btn-login">🛒 Giỏ hàng</a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-login">Đăng xuất</button>
            </form>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn-login">
            Đăng nhập / Đăng ký
        </a>
    @endauth
</header>

<!-- ===== HERO ===== -->
<section class="hero">
    <h2>Địa chỉ bạn muốn giao món</h2>
    <div class="address-box">
        <form action="{{ route('home') }}" method="GET" style="display: flex; width: 100%;" id="addressForm">
            <input type="text" name="address" id="addressInput" placeholder="Nhập địa chỉ của bạn (Ví dụ: Cầu Giấy...)" value="{{ request('address') }}">
            <button type="button" onclick="getLocation()" title="Lấy vị trí hiện tại" style="background: #dc3545; margin-left: 5px;">📍</button>
            <button type="submit" style="margin-left: 5px;">Tìm</button>
        </form>
    </div>
    <p id="geoStatus" style="color: white; margin-top: 10px; display: none;"></p>
</section>

<script>
    function getLocation() {
        const status = document.getElementById('geoStatus');
        const input = document.getElementById('addressInput');
        
        if (!navigator.geolocation) {
            alert('Trình duyệt của bạn không hỗ trợ định vị.');
            return;
        }

        status.style.display = 'block';
        status.textContent = 'Đang lấy vị trí...';
        
        navigator.geolocation.getCurrentPosition(success, error);

        function success(position) {
            const latitude  = position.coords.latitude;
            const longitude = position.coords.longitude;
            
            // Gọi API miễn phí để lấy địa chỉ từ toạ độ (Reverse Geocoding)
            // Sử dụng OpenStreetMap Nominatim API
            status.textContent = 'Đang tìm địa chỉ...';
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                .then(response => response.json())
                .then(data => {
                    if(data && data.display_name) {
                         // Lấy quận/huyện hoặc tên đường ngắn gọn hơn nếu muốn, ở đây lấy full
                         // Để ngắn gọn hơn ta có thể split lấy phần đầu
                        input.value = data.display_name;
                        status.style.display = 'none';
                    } else {
                        status.textContent = 'Không tìm thấy địa chỉ.';
                    }
                })
                .catch(err => {
                    status.textContent = 'Lỗi khi lấy địa chỉ.';
                    console.error(err);
                });
        }

        function error() {
            status.textContent = 'Không thể lấy vị trí của bạn.';
        }
    }
</script>

<!-- ===== CATEGORY ===== -->
<section class="menu">
    <h2>Bộ sưu tập món ăn</h2>

    <div class="menu-grid">
        <a href="{{ route('menu.category', 'Đồ uống') }}" class="menu-item">
            <img src="{{ asset('foods/jpgdouongg.jpg') }}">
            <p>Đồ uống</p>
        </a>

        <a href="{{ route('menu.category', 'Fast Food') }}" class="menu-item">
            <img src="{{ asset('foods/thucannhanh.jpg') }}">
            <p>Thức ăn nhanh</p>
        </a>

        <a href="{{ route('menu.category', 'Món chính') }}" class="menu-item">
            <img src="{{ asset('foods/comm.jpg') }}">
            <p>Cơm</p>
        </a>

        <a href="{{ route('menu.category', 'Pizza') }}" class="menu-item">
            <img src="{{ asset('foods/aau.jpg') }}">
            <p>Món Á – Âu</p>
        </a>
    </div>
</section>

<!-- ===== FEATURED FOOD ===== -->
<section class="section">
    <h2 class="section-title">Món ngon hôm nay</h2>

    @if($foods->count() == 0)
        <p>Chưa có món ăn nào trong hệ thống</p>
    @else
        <div class="food-grid">
            @foreach($foods as $food)
                <div class="food-card">

                    <a href="javascript:void(0)" onclick="openModal({{ json_encode($food) }})">
                        <img
                            src="{{ $food->image
                                ? (Str::startsWith($food->image, 'foods/') ? asset($food->image) : asset('storage/'.$food->image))
                                : 'https://source.unsplash.com/400x300/?food'
                            }}"
                            alt="{{ $food->name }}"
                        >
                    </a>

                    <div class="food-info">
                        <h3>{{ $food->name }}</h3>

                        <p class="food-desc">
                            {{ $food->description ?? 'Món ăn hấp dẫn – phục vụ nóng hổi' }}
                        </p>
                        @if($food->address)
                            <p class="food-address" style="font-size: 13px; color: #666; margin-top: 4px;">
                                📍 {{ $food->address }}
                            </p>
                        @endif

                        <!-- ===== GIÁ + NÚT ===== -->
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

        <!-- XEM THÊM -->
        @if($totalFoods > $foods->count())
            <div style="text-align:center; margin-top:30px;">
                <a href="{{ route('menu') }}" class="btn-login">
                    👀 Xem thêm món ăn
                </a>
            </div>
        @endif
    @endif
</section>

<!-- ===== APP DOWNLOAD ===== -->
<section class="app-download">
    <div>
        <h2>Đặt đồ ăn nhanh chóng cùng TTDFood</h2>
        <p>Tải ứng dụng để nhận nhiều ưu đãi hấp dẫn mỗi ngày</p>
        <a href="{{ route('menu') }}" class="btn-login">🍽 Xem thực đơn</a>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-grid">
        <div>
            <h4>Về TTDFood</h4>
            <p>Giới thiệu</p>
            <p>Tuyển dụng</p>
            <p>Điều khoản sử dụng</p>
        </div>

        <div>
            <h4>Hỗ trợ</h4>
            <p>Trung tâm trợ giúp</p>
            <p>Hướng dẫn đặt món</p>
            <p>Chính sách bảo mật</p>
        </div>

        <div>
            <h4>Liên hệ</h4>
            <p>Hotline: 1900 9999</p>
            <p>Email: support@ttdfood.vn</p>
            <p>TP. Hồ Chí Minh</p>
        </div>

        <div>
            <h4>Kết nối</h4>
            <p>Facebook</p>
            <p>Instagram</p>
            <p>Zalo</p>
        </div>
    </div>
</footer>

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
        
        // Fix image path logic
        let imgSrc = "https://source.unsplash.com/400x300/?food";
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
