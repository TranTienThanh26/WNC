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

    // ---------- MENU THEO LOẠI ----------
    Route::get('/menu/{category}', [MenuController::class, 'category'])
        ->name('menu.category');

    // ---------- SEARCH (ENTER TÌM KIẾM) ----------
    Route::get('/search-food', [MenuController::class, 'search'])
        ->name('search.food');

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

    // ---------- ĐẶT MÓN NGAY ----------
    Route::post('/order-now/{id}', function ($id) {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $food = \App\Models\Food::findOrFail($id);
            $cart[$id] = [
                'name' => $food->name,
                'price' => $food->price,
                'quantity' => 1,
                'image' => $food->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('checkout');
    })->name('order.now');

    // ================== ORDER ==================
    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('checkout');

    Route::post('/order', [OrderController::class, 'store'])
        ->name('order.store');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');
});

// ================== ADMIN ==================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // 🏠 Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // 🍔 Quản lý món ăn
    Route::get('/foods', [AdminController::class, 'foodIndex'])->name('foods.index');
    Route::get('/foods/create', [AdminController::class, 'foodCreate'])->name('foods.create');
    Route::post('/foods', [AdminController::class, 'foodStore'])->name('foods.store');
    Route::get('/foods/{id}/edit', [AdminController::class, 'foodEdit'])->name('foods.edit');
    Route::post('/foods/{id}', [AdminController::class, 'foodUpdate'])->name('foods.update');
    Route::post('/foods/{id}/delete', [AdminController::class, 'foodDelete'])->name('foods.delete');

    // 📦 Quản lý đơn hàng
    Route::get('/orders', [AdminController::class, 'orderIndex'])->name('orders.index');
    Route::post('/orders/{id}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.status');
});
