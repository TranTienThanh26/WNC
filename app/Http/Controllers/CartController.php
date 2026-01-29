<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🛒 Xem giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // ➕ Thêm món vào giỏ (từ trang chi tiết – có số lượng)
    public function add(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $qty  = (int) ($request->qty ?? 1);

        if ($qty < 1) {
            $qty = 1;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id'    => $food->id,
                'name'  => $food->name,
                'price' => $food->price,
                'qty'   => $qty
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')
            ->with('success', 'Đã thêm món vào giỏ hàng');
    }

    // ➕ Tăng số lượng (trong giỏ hàng)
    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // ➖ Giảm số lượng (trong giỏ hàng)
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // ❌ Xóa món khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // 🧹 Xóa toàn bộ giỏ hàng (dùng sau checkout)
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart');
    }
}
