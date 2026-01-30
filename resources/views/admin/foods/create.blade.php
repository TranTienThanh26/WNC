@extends('admin.layout')

@section('title', 'Thêm món ăn mới')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Thêm món ăn</h2>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-primary">⬅ Quay lại</a>
    </div>

    <div class="card" style="display:block;">
        <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Tên món ăn</label>
                <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Phở bò...">
            </div>

            <div class="form-group">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control" required placeholder="50000">
            </div>

            <div class="form-group">
                <label class="form-label">Danh mục</label>
                <select name="category" class="form-control" required>
                    <option value="Món chính">Món chính</option>
                    <option value="Cơm">Cơm</option>
                    <option value="Đồ uống">Đồ uống</option>
                    <option value="Fast Food">Fast Food</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Món Á – Âu">Món Á – Âu</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ quán</label>
                <input type="text" name="address" class="form-control" placeholder="123 Cầu Giấy...">
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px;">
                💾 Lưu món ăn
            </button>
        </form>
    </div>

@endsection
