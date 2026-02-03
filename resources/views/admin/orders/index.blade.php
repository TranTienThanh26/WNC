@extends('admin.layout')

@section('title', 'TTD.Signature | Quản lý Đơn hàng')
@section('page_title', 'Quản lý Đơn hàng')

@section('content')
<style>
    /* Ép Modal nổi lên trên cùng, tách biệt hoàn toàn với bảng */
    .modal { z-index: 1070 !important; }
    .modal-backdrop { z-index: 1060 !important; }
    
    .order-manager-wrapper { padding: 25px; }
    .sig-banner { background: var(--dark); color: #fff; padding: 40px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .lux-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none; overflow: hidden; }
    
    .status-select { border-radius: 10px; font-size: 0.85rem; padding: 5px 10px; transition: all 0.3s; border-width: 2px; }
</style>

<div class="order-manager-wrapper">
    <div class="sig-banner shadow-sm">
        <div>
            <h2 class="serif fw-bold mb-1">Đơn hàng <span style="color: var(--primary)">Signature</span></h2>
            <p class="small opacity-50 mb-0">QUẢN TRỊ TRẠNG THÁI PHỤC VỤ</p>
        </div>
        <div class="text-end">
            <span class="badge bg-warning text-dark px-3 py-2" style="border-radius: 10px;">
                Tổng: {{ $orders->total() }} đơn
            </span>
        </div>
    </div>

    <div class="lux-card card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase">
                    <tr style="font-size: 0.75rem; letter-spacing: 1px;">
                        <th class="ps-4">ID</th>
                        <th>Khách hàng</th>
                        <th>Thực đơn đặt</th>
                        <th>Tổng giá trị</th>
                        <th>Trạng thái</th>
                        <th class="pe-4 text-end">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                            <div class="small text-muted"><i class="fas fa-phone-alt me-1 text-primary"></i> {{ $order->phone }}</div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark fw-bold px-3" 
                                    data-bs-toggle="modal" data-bs-target="#orderDetail{{ $order->id }}"
                                    style="border-radius: 8px;">
                                <i class="fas fa-receipt me-2 text-warning"></i> {{ $order->items->count() }} món
                            </button>
                        </td>
                        <td class="fw-bold text-primary">{{ number_format($order->total_price) }}đ</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @php
                                    $statusStyle = match($order->status) {
                                        'Chờ xác nhận' => 'border-warning text-warning bg-light-warning',
                                        'Đang chuẩn bị' => 'border-info text-info bg-light-info',
                                        'Đang giao' => 'border-primary text-primary bg-light-primary',
                                        'Đã giao hàng' => 'border-success text-success bg-light-success',
                                        'Đã hủy' => 'border-danger text-danger bg-light-danger',
                                        default => 'border-secondary'
                                    };
                                @endphp
                                <select name="status" class="form-select status-select fw-bold {{ $statusStyle }}" onchange="this.form.submit()">
                                    <option value="Chờ xác nhận" {{ $order->status == 'Chờ xác nhận' ? 'selected' : '' }}>🕒 Chờ xác nhận</option>
                                    <option value="Đang chuẩn bị" {{ $order->status == 'Đang chuẩn bị' ? 'selected' : '' }}>👨‍🍳 Đang chuẩn bị</option>
                                    <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>🚀 Đang giao</option>
                                    <option value="Đã giao hàng" {{ $order->status == 'Đã giao hàng' ? 'selected' : '' }}>✅ Đã giao hàng</option>
                                    <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>❌ Đã hủy</option>
                                </select>
                            </form>
                        </td>
                        <td class="pe-4 text-end small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 
    LƯU Ý CỰC KỲ QUAN TRỌNG: 
    Phải để vòng lặp Modal ở NGOÀI thẻ Table hoặc sau thẻ đóng Div của Wrapper 
    để không bị vướng Stacking Context của Table.
--}}
@foreach($orders as $order)
<div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="serif fw-bold m-0">Chi tiết <span style="color: var(--primary)">#{{ $order->id }}</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="bg-light p-3 mb-3" style="border-radius: 15px;">
                    <div class="small fw-bold text-muted mb-1 text-uppercase">Thông tin giao hàng</div>
                    <div class="fw-bold">{{ $order->customer_name }}</div>
                    <div class="small">{{ $order->phone }}</div>
                    <div class="small text-muted italic">{{ $order->address }}</div>
                </div>
                
                <table class="table table-sm align-middle">
                    <thead>
                        <tr class="small text-muted">
                            <th>SẢN PHẨM</th>
                            <th class="text-center">SL</th>
                            <th class="text-end">GIÁ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-2 fw-bold small text-dark">{{ $item->food->name ?? 'Món đã xóa' }}</td>
                            <td class="text-center small">x{{ $item->quantity }}</td>
                            <td class="text-end fw-bold small text-dark">{{ number_format($item->price * $item->quantity) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                    <span class="fw-bold">TỔNG CỘNG:</span>
                    <span class="fw-bold text-danger fs-5">{{ number_format($order->total_price) }}đ</span>
                </div>
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn btn-dark w-100 py-2 fw-bold" data-bs-dismiss="modal" style="border-radius: 12px; color: var(--primary);">ĐÓNG</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection