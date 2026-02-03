@extends('admin.layout')

@section('title', 'Tổng quan')

@section('content')
    <div class="card-grid">
        <!-- CARD 1 -->
        <div class="card">
            <div class="card-icon bg-blue">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="card-info">
                <h3>{{ $totalOrders }}</h3>
                <p>Tổng đơn hàng</p>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="card">
            <div class="card-icon bg-green">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="card-info">
                <h3>{{ number_format($revenue) }} đ</h3>
                <p>Doanh thu</p>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="card">
            <div class="card-icon bg-orange">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="card-info">
                <h3>{{ $totalFoods }}</h3>
                <p>Món ăn đang bán</p>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="card">
            <div class="card-icon bg-red">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-info">
                <h3>{{ $totalUsers }}</h3>
                <p>Khách hàng thành viên</p>
            </div>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 15px;">Món ăn mới thêm</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên món</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Ngày thêm</th>
                </tr>
            </thead>
            <tbody>
                @foreach($newFoods as $food)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <img 
                                src="{{ $food->image 
                                    ? (Str::startsWith($food->image, 'foods/') ? asset($food->image) : asset('storage/'.$food->image)) 
                                    : asset('foods/burger.jpg') 
                                }}" 
                                width="40" height="40" style="border-radius:5px; object-fit:cover;"
                            >
                            {{ $food->name }}
                        </div>
                    </td>
                    <td>{{ number_format($food->price) }} đ</td>
                    <td>{{ $food->category }}</td>
                    <td>{{ $food->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
