<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // ===============================
    // 1️⃣ TRANG CHECKOUT
    // ===============================
    // ===============================
    // 1️⃣ TRANG CHECKOUT
    // ===============================
    public function checkout()
    {
        // Lấy cart từ DB thay vì session
        $cart = \App\Models\Cart::with('items.food')
            ->where('user_id', auth()->id())
            ->first();

        // Kiểm tra cart có tồn tại và có items không
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Giỏ hàng trống');
        }

        return view('checkout', compact('cart'));
    }

    // ===============================
    // 2️⃣ LƯU ĐƠN HÀNG
    // ===============================
    public function store(Request $request)
    {
        // ✅ Validate
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
        ]);

        // Lấy cart từ DB
        $cart = \App\Models\Cart::with('items.food')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Giỏ hàng trống');
        }

        // ✅ Tính tổng tiền
        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->price * $item->quantity;
        }

        // ✅ Tạo đơn hàng
        $order = Order::create([
            'user_id'       => auth()->id(),
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'total_price'   => $total,
            'status'        => 'Chờ thanh toán',
        ]);

        // ✅ Lưu chi tiết đơn hàng
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id'  => $item->food_id,
                'price'    => $item->price,
                'quantity' => $item->quantity,
            ]);
        }

        // ✅ Xóa items trong giỏ hàng DB
        $cart->items()->delete();

        // ✅ CÁCH 1: Quay về danh sách đơn hàng
        return redirect()->route('orders')
            ->with('success', '🎉 Đặt hàng thành công! Vui lòng thanh toán.');
    }

    // ===============================
    // 3️⃣ DANH SÁCH ĐƠN HÀNG
    // ===============================
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }

    // ===============================
    // 4️⃣ CHI TIẾT ĐƠN HÀNG
    // ===============================
    public function show($id)
    {
        // 🔒 Chỉ xem đơn của chính mình
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 🧾 Lấy danh sách món
        $items = OrderItem::where('order_id', $order->id)
            ->with('food') // cần relation food()
            ->get();

        return view('order_detail', compact('order', 'items'));
    }
}
