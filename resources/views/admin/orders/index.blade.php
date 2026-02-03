@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title m-0">📦 Danh sách đơn hàng</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Khách hàng</th>
                            <th>Thực đơn đặt</th> <th>Tổng tiền</th>
                            <th>Trạng thái & Hành động</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                            <td>
                                <div class="fw-bold text-primary">{{ $order->customer_name }}</div>
                                <div class="small text-muted"><i class="fas fa-phone-alt me-1"></i>{{ $order->phone }}</div>
                                <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($order->address, 30) }}</div>
                            </td>
                            
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#orderDetail{{ $order->id }}">
                                    <i class="fas fa-eye me-1"></i> Xem {{ $order->items->count() }} món
                                </button>

                                <div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title fw-bold">🧾 Chi tiết đơn #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Khách:</strong> {{ $order->customer_name }} - {{ $order->phone }}</p>
                                                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                                                <hr>
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Món ăn</th>
                                                            <th class="text-center">SL</th>
                                                            <th class="text-end">Giá</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->items as $item)
                                                        <tr>
                                                            <td>
                                                                {{ $item->food->name ?? 'Món đã bị xóa' }}
                                                            </td>
                                                            <td class="text-center fw-bold">x{{ $item->quantity }}</td>
                                                            <td class="text-end">{{ number_format($item->price * $item->quantity) }} đ</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light fw-bold">
                                                        <tr>
                                                            <td colspan="2" class="text-end">Tổng cộng:</td>
                                                            <td class="text-end text-danger">{{ number_format($order->total_price) }} đ</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>

                            <td class="fw-bold text-danger">
                                {{ number_format($order->total_price) }} đ
                            </td>

                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @php
                                        // Màu sắc Badge theo trạng thái
                                        $statusClass = match($order->status) {
                                            'Chờ xác nhận' => 'border-warning text-warning',
                                            'Đang chuẩn bị' => 'border-info text-info',
                                            'Đang giao' => 'border-primary text-primary',
                                            'Đã giao hàng' => 'border-success text-success',
                                            'Đã hủy' => 'border-danger text-danger',
                                            default => 'border-secondary'
                                        };
                                    @endphp
                                    
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select fw-bold {{ $statusClass }}" onchange="this.form.submit()" style="min-width: 140px;">
                                            <option value="Chờ xác nhận" {{ $order->status == 'Chờ xác nhận' ? 'selected' : '' }}>🕒 Chờ xác nhận</option>
                                            <option value="Đang chuẩn bị" {{ $order->status == 'Đang chuẩn bị' ? 'selected' : '' }}>👨‍🍳 Đang chuẩn bị</option>
                                            <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>🚀 Đang giao</option>
                                            <option value="Đã giao hàng" {{ $order->status == 'Đã giao hàng' ? 'selected' : '' }}>✅ Đã giao hàng</option>
                                            <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>❌ Đã hủy</option>
                                        </select>
                                    </div>
                                </form>
                            </td>
                            
                            <td class="text-muted small">
                                {{ $order->created_at->format('H:i') }}<br>
                                {{ $order->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection