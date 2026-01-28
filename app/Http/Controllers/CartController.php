<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Xem giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Thêm món vào giỏ
    public function add($id)
    {
        $food = Food::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id'    => $food->id,
                'name'  => $food->name,
                'price'=> $food->price,
                'qty'   => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart');
    }

    // Xóa món
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
