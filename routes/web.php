<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ================== MẶC ĐỊNH ==================
Route::get('/', function () {
    return redirect()->route('login');
});

// ================== AUTH ==================
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== USER (ĐÃ LOGIN) ==================
Route::middleware('auth')->group(function () {

    // ---------- HOME ----------
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ---------- MENU ----------
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');

    // ---------- CHI TIẾT MÓN ----------
    Route::get('/food/{id}', [FoodController::class, 'show'])
        ->name('food.show');

    // ================== CART ==================
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::post('/cart/add/{id}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::get('/cart/increase/{id}', [CartController::class, 'increase'])
        ->name('cart.increase');

    Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])
        ->name('cart.decrease');

    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');

    // ================== ORDER ==================
    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('checkout');

    // Lưu đơn hàng
    Route::post('/order', [OrderController::class, 'store'])
        ->name('order.store');

    // Danh sách đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders');

    // Chi tiết đơn hàng
    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');
});

// ================== ADMIN ==================
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

});
Route::get('/search-food', [MenuController::class, 'search'])
    ->name('food.search');
// route lọc theo loại
Route::get('/menu/{category}', [MenuController::class, 'category'])
    ->name('menu.category');