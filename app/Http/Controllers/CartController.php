<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🛒 Xem giỏ hàng
    public function index()
    {
        $cart = Cart::with('items.food')
        ->where('user_id', auth()->id())
        ->first();

    return view('cart', compact('cart'));
    }

    // ➕ Thêm món vào giỏ
    public function add(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $qty = (int) ($request->qty ?? 1);
        if ($qty < 1) $qty = 1;

        // Lấy hoặc tạo cart cho user
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        // Kiểm tra món đã tồn tại chưa
        $item = CartItem::where('cart_id', $cart->id)
            ->where('food_id', $food->id)
            ->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'food_id' => $food->id,
                'quantity' => $qty,
                'price' => $food->price
            ]);
        }

        if ($request->has('redirect') && $request->redirect == 'checkout') {
            return redirect()->route('checkout');
        }

        return redirect()->route('cart')
            ->with('success', 'Đã thêm món vào giỏ hàng');
    }

    // ➕ Tăng số lượng
    public function increase($id)
    {
        $item = CartItem::findOrFail($id);
        $item->increment('quantity');

        return back();
    }

    // ➖ Giảm số lượng
    public function decrease($id)
    {
        $item = CartItem::findOrFail($id);

        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }

        return back();
    }

    // ❌ Xóa món
    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();
        return back();
    }

    // 🧹 Xóa toàn bộ giỏ
    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('cart');
    }
}
