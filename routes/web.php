<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (AI CŨNG XEM ĐƯỢC - Mở web là thấy ngay)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/category/{slug}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/search-food', [MenuController::class, 'search'])->name('search.food');
Route::get('/food/{id}', [FoodController::class, 'show'])->name('food.show');

/*
|--------------------------------------------------------------------------
| 2. GUEST ROUTES (CHỈ DÀNH CHO NGƯỜI CHƯA ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| 3. PROTECTED ROUTES (BẮT BUỘC ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // --- Auth ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Giỏ hàng ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // --- Thanh toán & Đơn hàng ---
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/{id}', [OrderController::class, 'showCheckoutForm'])->name('checkout.show');
    Route::put('/checkout/{id}', [OrderController::class, 'update'])->name('order.update');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
    
    // 👇 TUYẾN ĐƯỜNG MỚI: Hủy đơn hàng
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
});

/*
|--------------------------------------------------------------------------
| 4. ADMIN ROUTES (QUẢN TRỊ VIÊN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('foods')->name('foods.')->group(function () {
        Route::get('/', [AdminController::class, 'foodIndex'])->name('index');
        Route::post('/store', [AdminController::class, 'foodStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'foodEdit'])->name('edit');
        Route::post('/update/{id}', [AdminController::class, 'foodUpdate'])->name('update');
        Route::get('/delete/{id}', [AdminController::class, 'foodDelete'])->name('delete');
    });

    Route::get('/orders', [AdminController::class, 'orderIndex'])->name('orders.index');
    Route::post('/orders/{id}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.updateStatus');
});