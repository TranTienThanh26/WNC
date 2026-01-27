<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thực đơn</title>
</head>
<body>
    <h2>📋 Thực đơn</h2>

    <ul>
        @foreach($foods as $food)
            <li>
                {{ $food['name'] }} - {{ number_format($food['price']) }} VNĐ
            </li>
        @endforeach
    </ul>

    <a href="/">⬅ Quay lại trang chủ</a>
</body>
</html>
