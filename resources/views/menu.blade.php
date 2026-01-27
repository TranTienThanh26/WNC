<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực đơn</title>
</head>
<body>

<h2>📋 Thực đơn</h2>

@if($foods->count() == 0)
    <p>Chưa có món ăn nào</p>
@else
    <ul>
        @foreach($foods as $food)
            <li>
                {{ $food->name }} -
                {{ number_format($food->price) }} VNĐ
            </li>
        @endforeach
    </ul>
@endif

<a href="/">⬅ Quay lại trang chủ</a>

</body>
</html>
