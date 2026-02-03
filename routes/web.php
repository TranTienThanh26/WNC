<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Middleware\AdminMiddleware; // 🟢 Import Middleware Admin

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (KHÔNG CẦN ĐĂNG NHẬP)
|--------------------------------------------------------------------------
| Khách vãng lai có thể xem trang chủ, menu, tìm kiếm...
*/

// Trang chủ (Thay vì redirect login, hãy cho họ xem trang chủ)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']); // Alias cho home

// Auth (Đăng nhập/Đăng ký)
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Menu & Tìm kiếm
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/category/{category}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/search-food', [MenuController::class, 'search'])->name('search.food');

// Chi tiết món ăn (Chỉ xem)
Route::get('/food/{id}', [FoodController::class, 'show'])->name('food.show');


/*
|--------------------------------------------------------------------------
| 2. USER ROUTES (PHẢI ĐĂNG NHẬP)
|--------------------------------------------------------------------------
| Mua hàng, xem giỏ hàng, lịch sử đơn hàng...
*/
Route::middleware('auth')->group(function () {

    // --- Giỏ hàng ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    
    // Mua ngay (Sử dụng CartController thay vì viết code trực tiếp ở đây)
    Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');
    
    // Thao tác giỏ hàng
    Route::get('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // --- Thanh toán & Đơn hàng ---
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    
    // Lịch sử đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show'); // Sửa tên route cho chuẩn
});


/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (QUẢN TRỊ VIÊN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class]) // Sử dụng Class trực tiếp cho an toàn
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Quản lý Món ăn
    Route::get('/foods', [AdminController::class, 'foodIndex'])->name('foods.index');
    Route::get('/foods/create', [AdminController::class, 'foodCreate'])->name('foods.create');
    Route::post('/foods', [AdminController::class, 'foodStore'])->name('foods.store');
    
    Route::get('/foods/{id}/edit', [AdminController::class, 'foodEdit'])->name('foods.edit');
    Route::post('/foods/{id}', [AdminController::class, 'foodUpdate'])->name('foods.update');
    Route::get('/foods/{id}/delete', [AdminController::class, 'foodDelete'])->name('foods.delete'); // Đổi thành GET cho dễ gọi từ link, hoặc dùng form POST/DELETE

    // Quản lý Đơn hàng
    Route::get('/orders', [AdminController::class, 'orderIndex'])->name('orders.index');
    Route::post('/orders/{id}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.updateStatus');
});