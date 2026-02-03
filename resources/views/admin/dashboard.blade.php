@extends('admin.layout')

@section('title', 'Tổng quan hệ thống')

@section('content')
    
    <div class="row g-3 mb-4">
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                        <i class="fas fa-shopping-bag fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Tổng đơn hàng</h6>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Doanh thu</h6>
                        <h4 class="mb-0 fw-bold text-success">{{ number_format($revenue) }} đ</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3 text-warning">
                        <i class="fas fa-utensils fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Món đang bán</h6>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalFoods) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3 text-danger">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Khách thành viên</h6>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title mb-0 fw-bold">🍽 Món ăn mới thêm gần đây</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Món ăn</th>
                            <th>Giá bán</th>
                            <th>Danh mục</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($newFoods as $food)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img 
                                        src="{{ $food->image 
                                            ? asset('storage/'.$food->image) 
                                            : 'https://placehold.co/40x40?text=No+Img' 
                                        }}" 
                                        width="40" height="40" class="rounded-3 object-fit-cover me-3 border"
                                        alt="{{ $food->name }}"
                                    >
                                    <span class="fw-bold text-dark">{{ $food->name }}</span>
                                </div>
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($food->price) }} đ</td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10">
                                    {{ $food->category }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                <i class="far fa-clock me-1"></i>{{ $food->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Chưa có món ăn nào được thêm.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection