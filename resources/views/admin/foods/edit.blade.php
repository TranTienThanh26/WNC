@extends('admin.layout')

@section('title', 'Chỉnh sửa món ăn')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Chỉnh sửa món ăn: {{ $food->name }}</h2>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-primary">⬅ Quay lại</a>
    </div>

    <div class="card" style="display:block;">
        <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Tên món ăn</label>
                <input type="text" name="name" class="form-control" required value="{{ $food->name }}">
            </div>

            <div class="form-group">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control" required value="{{ $food->price }}">
            </div>

            <div class="form-group">
                <label class="form-label">Danh mục</label>
                <select name="category" class="form-control" required>
                    <option value="Món chính" {{ $food->category == 'Món chính' ? 'selected' : '' }}>Món chính</option>
                    <option value="Cơm" {{ $food->category == 'Cơm' ? 'selected' : '' }}>Cơm</option>
                    <option value="Đồ uống" {{ $food->category == 'Đồ uống' ? 'selected' : '' }}>Đồ uống</option>
                    <option value="Fast Food" {{ $food->category == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                    <option value="Pizza" {{ $food->category == 'Pizza' ? 'selected' : '' }}>Pizza</option>
                    <option value="Món Á – Âu" {{ $food->category == 'Món Á – Âu' ? 'selected' : '' }}>Món Á – Âu</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ quán</label>
                <input type="text" name="address" class="form-control" value="{{ $food->address }}">
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4">{{ $food->description }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Hình ảnh hiện tại</label>
                @if($food->image)
                    <div style="margin:10px 0;">
                        <img src="{{ asset('storage/'.$food->image) }}" width="100" style="border-radius:5px;">
                    </div>
                @endif
                <label class="form-label">Chọn ảnh mới (nếu muốn thay đổi)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px;">
                💾 Cập nhật
            </button>
        </form>
    </div>

@endsection
