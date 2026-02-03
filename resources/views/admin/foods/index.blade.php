@extends('admin.layout')

@section('title', 'TTD.Signature | Quản lý Thực đơn')

@section('content')
<style>
    /* FIX LỖI BỊ MỜ: Ép Modal luôn nổi lên trên lớp màn đen (Backdrop) */
    .modal { z-index: 1070 !important; }
    .modal-backdrop { z-index: 1060 !important; }
    
    .food-manager-wrapper { padding: 25px; position: relative; z-index: 1; }
    .sig-banner { background: var(--dark); color: #fff; padding: 40px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .lux-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none; overflow: hidden; }
    .food-thumb { width: 50px; height: 50px; border-radius: 12px; object-fit: cover; }
    
    #modalLoading { padding: 50px; text-align: center; display: none; }
</style>

<div class="food-manager-wrapper">
    <div class="sig-banner shadow-sm">
        <div>
            <h2 class="serif fw-bold mb-1">Thực đơn <span style="color: var(--primary)">Signature</span></h2>
            <p class="small opacity-50 mb-0">HỆ THỐNG QUẢN TRỊ</p>
        </div>
        <button class="btn px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#createFoodModal" 
                style="background: var(--primary); color: #fff; border-radius: 12px; border: none;">
            <i class="fas fa-plus me-2"></i> THÊM MÓN
        </button>
    </div>

    <div class="lux-card card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light text-uppercase">
                    <tr>
                        <th class="ps-4">Tuyệt phẩm</th>
                        <th>Danh mục</th>
                        <th>Địa chỉ</th>
                        <th>Giá bán</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foods as $food)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @php
                                    $imgSrc = str_contains($food->image, 'http') ? $food->image : asset('storage/' . $food->image);
                                @endphp
                                <img src="{{ $food->image ? $imgSrc : 'https://placehold.co/100' }}" class="food-thumb me-3" onerror="this.src='https://placehold.co/100'">
                                <span class="fw-bold text-dark">{{ $food->name }}</span>
                            </div>
                        </td>
                        <td>{{ $food->category->name ?? 'N/A' }}</td>
                        <td><small class="text-muted">{{ $food->address ?: 'Toàn hệ thống' }}</small></td>
                        <td><span class="fw-bold text-primary">{{ number_format($food->price) }}đ</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-edit-trigger" data-id="{{ $food->id }}" 
                                    style="background: rgba(197,160,89,0.1); color: var(--primary); border:none; padding: 8px 15px; border-radius: 8px;">
                                <i class="fas fa-edit me-1"></i> Sửa
                            </button>
                            <a href="{{ route('admin.foods.delete', $food->id) }}" class="ms-2 text-danger" onclick="return confirm('Xác nhận xóa món này?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createFoodModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
            <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 px-4 pt-4">
                    <h4 class="serif fw-bold m-0">Thêm <span style="color: var(--primary)">Mỹ Thực Mới</span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8 mb-3"><label class="small fw-bold">TÊN MÓN</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label class="small fw-bold">GIÁ BÁN</label><input type="number" name="price" class="form-control" required></div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">DANH MỤC</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label class="small fw-bold">ĐỊA CHỈ</label><input type="text" name="address" class="form-control"></div>
                        <div class="col-12 mb-3"><label class="small fw-bold">HÌNH ẢNH</label><input type="file" name="image" class="form-control" required></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold shadow" style="border-radius: 12px; color: var(--primary);">LƯU MỸ THỰC</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
            <form id="editFoodForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 px-4 pt-4">
                    <h4 class="serif fw-bold m-0">Hiệu chỉnh <span style="color: var(--primary)">Mỹ Thực</span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div id="modalLoading"><div class="spinner-border text-warning" role="status"></div></div>
                <div class="modal-body p-4" id="modalContent" style="display:none;">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <img id="edit_preview" src="" class="img-fluid rounded-4 border w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                            <input type="file" name="image" class="form-control mt-3" id="edit_image_input">
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3"><label class="small fw-bold">TÊN MÓN</label><input type="text" name="name" id="edit_name" class="form-control py-2 bg-light border-0" required></div>
                            <div class="row g-2">
                                <div class="col-6 mb-3"><label class="small fw-bold">GIÁ BÁN</label><input type="number" name="price" id="edit_price" class="form-control py-2 bg-light border-0" required></div>
                                <div class="col-6 mb-3">
                                    <label class="small fw-bold">DANH MỤC</label>
                                    <select name="category_id" id="edit_category" class="form-select py-2 bg-light border-0">
                                        @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3"><label class="small fw-bold">ĐỊA CHỈ PHỤC VỤ</label><input type="text" name="address" id="edit_address" class="form-control py-2 bg-light border-0"></div>
                            <div class="mb-3"><label class="small fw-bold">MÔ TẢ</label><textarea name="description" id="edit_description" class="form-control bg-light border-0" rows="3"></textarea></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold shadow" style="border-radius: 12px; color: var(--primary);">CẬP NHẬT THÔNG TIN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-edit-trigger', function() {
        const id = $(this).data('id');
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
        
        $('#modalLoading').show();
        $('#modalContent').hide();

        $.ajax({
            url: `/admin/foods/${id}/edit`,
            type: 'GET',
            success: function(res) {
                $('#edit_name').val(res.name);
                $('#edit_price').val(res.price);
                $('#edit_category').val(res.category_id);
                $('#edit_description').val(res.description);
                $('#edit_address').val(res.address);
                
                let imgSrc = res.image.includes('http') ? res.image : `/storage/${res.image}`;
                $('#edit_preview').attr('src', imgSrc);
                
                // Gán Action URL để nút Lưu có hiệu lực
                $('#editFoodForm').attr('action', `/admin/foods/update/${id}`);

                $('#modalLoading').hide();
                $('#modalContent').fadeIn();
            }
        });
    });

    // Preview ảnh khi chọn file mới
    $('#edit_image_input').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) { $('#edit_preview').attr('src', event.target.result); }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush