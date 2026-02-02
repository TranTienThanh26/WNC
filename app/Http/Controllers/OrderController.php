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
        // ⚡ CHECK: Có đang mua ngay 1 món không?
        if (session()->has('buy_now_item')) {
            $itemData = session('buy_now_item');
            
            // Mock object để view hiển thị giống cart
            $cart = new \stdClass();
            $cart->items = collect([
                (object) [
                    'food' => $itemData['food'],
                    'price' => $itemData['price'],
                    'quantity' => $itemData['quantity'],
                    'food_id' => $itemData['id']
                ]
            ]);
            
            return view('checkout', compact('cart'));
        }

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

        $total = 0;
        $itemsToOrder = [];
        $isBuyNow = false;

        // ⚡ XỬ LÝ MUA NGAY (BUY NOW)
        if (session()->has('buy_now_item')) {
            $itemData = session('buy_now_item');
            $total = $itemData['price'] * $itemData['quantity'];
            
            $itemsToOrder[] = [
                'food_id' => $itemData['id'],
                'price' => $itemData['price'],
                'quantity' => $itemData['quantity']
            ];
            
            $isBuyNow = true;
        } 
        // 🛒 XỬ LÝ CART THƯỜNG
        else {
            $cart = \App\Models\Cart::with('items.food')
                ->where('user_id', auth()->id())
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Giỏ hàng trống');
            }

            foreach ($cart->items as $item) {
                $total += $item->price * $item->quantity;
                $itemsToOrder[] = [
                    'food_id' => $item->food_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity
                ];
            }
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
        foreach ($itemsToOrder as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id'  => $item['food_id'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // ✅ SAU KHI TẠO ĐƠN
        if ($isBuyNow) {
            // Xóa session mua ngay
            session()->forget('buy_now_item');
        } else {
            // Xóa items trong giỏ hàng DB
            $cart->items()->delete();
        }

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
