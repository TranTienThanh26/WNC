@extends('admin.layout')

@section('title', 'Quản lý món ăn')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title m-0">🍽 Danh sách thực đơn</h2>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFoodModal">
            <i class="fas fa-plus-circle me-2"></i>Thêm món mới
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Hình ảnh</th>
                            <th>Tên món</th>
                            <th>Giá bán</th>
                            <th>Danh mục</th>
                            <th>Địa chỉ</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($foods as $food)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration + ($foods->currentPage() - 1) * $foods->perPage() }}</td>
                            <td>
                                <img 
                                    src="{{ $food->image 
                                        ? (Str::startsWith($food->image, 'foods/') ? asset('storage/'.$food->image) : asset('storage/'.$food->image)) 
                                        : 'https://placehold.co/600x400?text=No+Image' 
                                    }}" 
                                    width="50" height="50" class="rounded-3 object-fit-cover border"
                                    alt="{{ $food->name }}"
                                >
                            </td>
                            <td class="fw-bold text-dark">{{ $food->name }}</td>
                            <td class="text-danger fw-bold">{{ number_format($food->price, 0, ',', '.') }} đ</td>
                            <td>
                                @php
                                    $badges = [
                                        'Món chính' => 'bg-primary',
                                        'Cơm' => 'bg-success',
                                        'Đồ uống' => 'bg-info text-dark',
                                        'Fast Food' => 'bg-warning text-dark',
                                        'Pizza' => 'bg-danger',
                                        'Món Á – Âu' => 'bg-dark'
                                    ];
                                    $badgeClass = $badges[$food->category] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $food->category }}</span>
                            </td>
                            <td class="text-muted small">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ Str::limit($food->address, 20) ?? '---' }}
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editFoodModal{{ $food->id }}"
                                        title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <a href="{{ route('admin.foods.delete', $food->id) }}" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa món này không?');"
                                   title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <div class="modal fade text-start" id="editFoodModal{{ $food->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Cập nhật: {{ $food->name }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Tên món ăn <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $food->name }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                                                            <input type="number" name="price" class="form-control" value="{{ $food->price }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                                            <select name="category" class="form-select" required>
                                                                @foreach(['Món chính', 'Cơm', 'Đồ uống', 'Fast Food', 'Pizza', 'Món Á – Âu'] as $cat)
                                                                    <option value="{{ $cat }}" {{ $food->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Địa chỉ quán</label>
                                                            <input type="text" name="address" class="form-control" value="{{ $food->address }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Mô tả</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $food->description }}</textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Hình ảnh</label>
                                                            <div class="d-flex align-items-center gap-3 p-2 border rounded bg-light">
                                                                <img src="{{ $food->image ? asset('storage/'.$food->image) : 'https://placehold.co/50x50' }}" width="60" height="60" class="rounded object-fit-cover">
                                                                <div class="flex-grow-1">
                                                                    <input type="file" name="image" class="form-control">
                                                                    <small class="text-muted">Chỉ chọn nếu muốn thay đổi ảnh cũ</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary fw-bold">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($foods->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $foods->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="createFoodModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Thêm món ăn mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên món ăn <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Ví dụ: Phở bò tái lăn..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" placeholder="Ví dụ: 50000" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="" disabled selected>-- Chọn danh mục --</option>
                                    <option value="Món chính">Món chính</option>
                                    <option value="Cơm">Cơm</option>
                                    <option value="Đồ uống">Đồ uống</option>
                                    <option value="Fast Food">Fast Food</option>
                                    <option value="Pizza">Pizza</option>
                                    <option value="Món Á – Âu">Món Á – Âu</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Địa chỉ quán</label>
                                <input type="text" name="address" class="form-control" placeholder="Ví dụ: 123 Cầu Giấy...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Mô tả hương vị, thành phần..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Hình ảnh</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success fw-bold">Tạo mới ngay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection