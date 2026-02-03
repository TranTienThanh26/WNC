<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hàm này giúp lấy giỏ hàng của User đang đăng nhập
    private function getCart()
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    // 🛒 1. XEM GIỎ HÀNG
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        }

        $cart = $this->getCart();
        return view('user.cart', compact('cart'));
    }

    // ➕ 2. THÊM VÀO GIỎ (LƯU VÀO DB)
    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['login' => true]);
        }

        $food = Food::findOrFail($id);
        $qty = $request->qty ? (int)$request->qty : 1;
        if ($qty < 1) $qty = 1;

        $cart = $this->getCart();

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('food_id', $food->id)
                        ->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id'  => $cart->id,
                'food_id'  => $food->id,
                'quantity' => $qty,
                'price'    => $food->price
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Đã thêm món vào giỏ hàng!']);
    }

    // ⚡ 3. MUA NGAY (LƯU TẠM SESSION)
    public function buyNow(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['login' => true]);
        }

        $food = Food::findOrFail($id);
        $qty = $request->qty ? (int)$request->qty : 1;

        session()->put('buy_now_item', [
            'id'       => $food->id,
            'name'     => $food->name,
            'price'    => $food->price,
            'image'    => $food->image,
            'quantity' => $qty
        ]);

        return response()->json(['success' => true, 'redirect' => route('checkout')]);
    }

    // ❌ XÓA MỘT MÓN
    public function remove($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $item = CartItem::find($id);
        if ($item && $item->cart->user_id == Auth::id()) {
            $item->delete();
        }
        return redirect()->back();
    }

    // 🧹 XÓA HẾT GIỎ
    public function clear()
    {
        if (!Auth::check()) return redirect()->route('login');

        $cart = $this->getCart();
        $cart->items()->delete();
        return redirect()->back();
    }

    // ====================================================
    // 🟢 4. CẬP NHẬT SỐ LƯỢNG (AJAX) - MỚI THÊM
    // ====================================================
    public function updateQuantity(Request $request, $id)
    {
        if (!Auth::check()) return response()->json(['login' => true]);

        // Tìm item và đảm bảo nó thuộc về user đang đăng nhập
        $item = CartItem::where('id', $id)
            ->whereHas('cart', function($q) { 
                $q->where('user_id', Auth::id()); 
            })
            ->first();

        if (!$item) return response()->json(['error' => 'Item not found'], 404);

        // Tính toán số lượng mới
        $change = (int)$request->change;
        $newQty = $item->quantity + $change;

        $action = 'update';

        // Nếu giảm xuống < 1 -> Xóa luôn
        if ($newQty < 1) {
            $item->delete();
            $action = 'delete';
        } else {
            $item->quantity = $newQty;
            $item->save();
        }

        // Tính lại Tổng tiền của cả giỏ hàng để cập nhật giao diện
        $cartTotal = CartItem::where('cart_id', $item->cart_id)
            ->get()
            ->sum(function($t) { return $t->price * $t->quantity; });

        return response()->json([
            'success'   => true,
            'action'    => $action,
            'newQty'    => $newQty,
            'itemTotal' => number_format($item->price * $newQty), // Thành tiền của món này
            'cartTotal' => number_format($cartTotal)              // Tổng tiền cả giỏ
        ]);
    }

    // (Giữ lại các hàm cũ increase/decrease để fallback nếu cần, 
    // nhưng thực tế ta đã dùng Ajax updateQuantity ở trên rồi)
    public function increase($id) { return $this->updateQuantity(new Request(['change' => 1]), $id); }
    public function decrease($id) { return $this->updateQuantity(new Request(['change' => -1]), $id); }
}