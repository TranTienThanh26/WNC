<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🛒 1. XEM GIỎ HÀNG
    public function index()
    {
        // Lấy giỏ hàng của người dùng hiện tại từ Database
        $cart = Cart::with('items.food')
                    ->where('user_id', Auth::id())
                    ->first();

        return view('cart', compact('cart'));
    }

    // ➕ 2. THÊM VÀO GIỎ (Lưu vào Database)
    public function add(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $qty = $request->qty ? (int)$request->qty : 1;
        if ($qty < 1) $qty = 1;

        // Tìm hoặc tạo giỏ hàng cho user này
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        // Kiểm tra món này đã có trong giỏ chưa
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('food_id', $food->id)
                        ->first();

        if ($item) {
            // Nếu có rồi -> Tăng số lượng
            $item->quantity += $qty;
            $item->save();
        } else {
            // Nếu chưa -> Tạo mới
            CartItem::create([
                'cart_id'  => $cart->id,
                'food_id'  => $food->id,
                'quantity' => $qty,
                'price'    => $food->price
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm món vào giỏ hàng!');
    }

    // ⚡ 3. MUA NGAY (Không lưu Database, dùng Session tạm)
    public function buyNow(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $qty = $request->qty ? (int)$request->qty : 1;

        // Lưu thông tin món này vào Session đặc biệt để Checkout nhận biết
        session()->put('buy_now_item', [
            'id'       => $food->id,
            'name'     => $food->name,
            'price'    => $food->price,
            'quantity' => $qty,
            'image'    => $food->image,
            'food'     => $food // Lưu cả object để view hiển thị dễ dàng
        ]);

        // Chuyển thẳng đến trang thanh toán
        return redirect()->route('checkout');
    }

    // 🔼 4. TĂNG SỐ LƯỢNG
    public function increase($id)
    {
        $item = CartItem::findOrFail($id);
        
        // Bảo mật: Chỉ sửa món trong giỏ của mình (tránh hack ID)
        if ($item->cart->user_id == Auth::id()) {
            $item->increment('quantity');
        }
        
        return redirect()->back();
    }

    // 🔽 5. GIẢM SỐ LƯỢNG
    public function decrease($id)
    {
        $item = CartItem::findOrFail($id);

        if ($item->cart->user_id == Auth::id()) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                // Nếu giảm về 0 thì xóa luôn
                $item->delete();
            }
        }

        return redirect()->back();
    }

    // ❌ 6. XÓA MÓN
    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        
        if ($item->cart->user_id == Auth::id()) {
            $item->delete();
        }

        return redirect()->back()->with('success', 'Đã xóa món khỏi giỏ hàng');
    }

    // 🧹 7. XÓA SẠCH GIỎ
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
}