<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Hiển thị trang checkout
    public function checkout()
    {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    }

    // Lưu đơn hàng
    public function store(Request $request)
    {
        // ✅ Validate
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address'       => 'required|string|max:255',
        ]);

        $cart = session('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart')
                ->with('error', 'Giỏ hàng trống');
        }

        // ✅ Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        // ✅ Tạo đơn hàng (ĐÚNG DB)
        $order = Order::create([
            'user_id'       => auth()->id(),
            'customer_name' => $request->customer_name,
            'address'       => $request->address,
            'total_price'   => $total,   // ✅ SỬA Ở ĐÂY
            'status'        => 'pending',
        ]);

        // ✅ Lưu chi tiết đơn hàng
        foreach ($cart as $food_id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id'  => $food_id,
                'price'    => $item['price'],
                'quantity' => $item['qty'],
            ]);
        }

        // ✅ Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('orders')
            ->with('success', 'Đặt hàng thành công');
    }

    // Danh sách đơn hàng
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }
}
