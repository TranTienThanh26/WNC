@extends('admin.layout')

@section('title', 'Quản lý món ăn')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Danh sách món ăn</h2>
        <a href="{{ route('admin.foods.create') }}" class="btn btn-primary">+ Thêm món mới</a>
    </div>

    <div class="table-container" style="margin-top:0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên món</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($foods as $food)
                <tr>
                    <td>{{ $food->id }}</td>
                    <td>
                        @if($food->image)
                            <img src="{{ asset('storage/'.$food->image) }}" width="60" height="60" style="border-radius:5px; object-fit:cover;">
                        @else
                            <span style="color:#aaa;">No Image</span>
                        @endif
                    </td>
                    <td><b>{{ $food->name }}</b></td>
                    <td>{{ number_format($food->price) }} đ</td>
                    <td>
                        <span class="badge" style="background:#f3f4f6; color:#333;">{{ $food->category }}</span>
                    </td>
                    <td>{{ $food->address ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.foods.edit', $food->id) }}" class="btn btn-info">Sửa</a>
                        
                        <form action="{{ route('admin.foods.delete', $food->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa món này?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top:20px;">
            {{ $foods->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
