<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================== MẶC ĐỊNH ==================
Route::get('/', function () {
    return redirect('/login');
});

// ================== AUTH ==================
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== USER (PHẢI LOGIN) ==================
Route::middleware('auth')->group(function () {

    // HOME
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // MENU / XEM MÓN
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');

    // ================== CART (GIỎ HÀNG) ==================
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // ================== ORDER ==================
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
});

// ================== ADMIN ==================
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // (sau này mở rộng)
    // Route::get('/admin/orders', ...);
    // Route::get('/admin/foods', ...);
});
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', fn() => view('checkout'))->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');