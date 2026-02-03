<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $food->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>

<a href="{{ route('menu') }}" class="back-link">⬅ Quay lại</a>

<div class="detail-container">

    <img
        src="{{ $food->image ?? 'https://source.unsplash.com/400x300/?food' }}"
        class="food-image"
    >

    <h2>{{ $food->name }}</h2>

    <p class="price">{{ number_format($food->price) }} đ</p>

    <p class="desc">
        Món ăn ngon – phục vụ nóng hổi 🍽️
    </p>

    <!-- CHỌN SỐ LƯỢNG -->
    <div class="qty-box">
        <button type="button" onclick="changeQty(-1)">−</button>
        <input type="text" id="qty" value="1" readonly>
        <button type="button" onclick="changeQty(1)">+</button>
    </div>

    <!-- FORM ĐẶT MÓN -->
    <form action="{{ route('cart.add', $food->id) }}" method="POST">
        @csrf
        <input type="hidden" name="qty" id="qty_input" value="1">
        <button class="add-cart-btn">🛒 Đặt món</button>
    </form>

</div>

<script>
function changeQty(step) {
    let qty = document.getElementById('qty');
    let qtyInput = document.getElementById('qty_input');

    let value = parseInt(qty.value) + step;
    if (value < 1) value = 1;

    qty.value = value;
    qtyInput.value = value;
}
</script>

</body>
</html>
