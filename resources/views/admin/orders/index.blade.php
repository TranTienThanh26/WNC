@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

    <div class="page-header">
        <h2 class="page-title">Danh sách đơn hàng</h2>
    </div>

    <div class="table-container" style="margin-top:0;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <b>{{ $order->customer_name }}</b><br>
                        <small>{{ $order->phone }}</small> <br>
                        <small style="color:#666;">{{ $order->address }}</small>
                    </td>
                    <td>{{ number_format($order->total_price) }} đ</td>
                    <td>
                        @php
                            $badge = match($order->status) {
                                'Chờ thanh toán' => 'badge-pending',
                                'Đang giao hàng' => 'badge-shipping',
                                'Đã giao hàng'   => 'badge-completed',
                                'Đã hủy'         => 'badge-cancelled',
                                default => ''
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $order->status }}</span>
                    </td>
                    <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="padding:5px; border-radius:4px; border:1px solid #ccc;">
                                <option value="Chờ thanh toán" {{ $order->status == 'Chờ thanh toán' ? 'selected' : '' }}>Chờ thanh toán</option>
                                <option value="Đang giao hàng" {{ $order->status == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="Đã giao hàng" {{ $order->status == 'Đã giao hàng' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
