<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Food;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Bước 1: Khi khách bấm "Thanh toán" -> Tạo ngay đơn hàng "Chưa thanh toán"
     */
    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $itemsToOrder = [];
            $total = 0;

            if (session()->has('buy_now_item')) {
                $itemData = session('buy_now_item');
                $food = Food::find($itemData['id']);
                if (!$food) return redirect()->route('menu');

                $total = $itemData['price'] * $itemData['quantity'];
                $itemsToOrder[] = [
                    'food_id'  => $food->id,
                    'price'    => $itemData['price'],
                    'quantity' => $itemData['quantity']
                ];
            } else {
                $cart = Cart::with('items')->where('user_id', Auth::id())->first();
                if (!$cart || $cart->items->isEmpty()) {
                    return redirect()->route('menu')->with('error', 'Giỏ hàng trống');
                }

                foreach ($cart->items as $item) {
                    $total += $item->price * $item->quantity;
                    $itemsToOrder[] = [
                        'food_id'  => $item->food_id,
                        'price'    => $item->price,
                        'quantity' => $item->quantity
                    ];
                }
            }

            $order = Order::create([
                'user_id'       => Auth::id(),
                'customer_name' => Auth::user()->name,
                'phone'         => Auth::user()->phone ?? '',
                'address'       => $request->address ?? '',
                'total_price'   => $total,
                'status'        => 'Chưa thanh toán',
            ]);

            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id'  => $item['food_id'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            if (session()->has('buy_now_item')) {
                session()->forget('buy_now_item');
            } else {
                $cart->items()->delete();
                $cart->delete();
            }

            DB::commit();
            return redirect()->route('checkout.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khởi tạo đơn hàng: ' . $e->getMessage());
        }
    }

    public function showCheckoutForm($id)
    {
        $order = Order::with('items.food')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if($order->status != 'Chưa thanh toán') {
            return redirect()->route('orders');
        }
        return view('user.checkout', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:255',
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $order->update([
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'note'          => $request->note,
            'status'        => 'Chờ xác nhận',
        ]);

        return redirect()->route('orders')->with('success', '🎉 Đặt hàng thành công!');
    }

    /**
     * 👇 HÀM MỚI: Xử lý hủy đơn hàng dành cho khách hàng
     */
    public function cancel($id)
    {
        // Tìm đơn hàng của đúng User đang đăng nhập
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Danh sách các trạng thái được phép hủy (tùy biến theo logic của bạn)
        $allowCancel = ['chờ xác nhận', 'chưa thanh toán', 'pending'];

        if (in_array(strtolower($order->status), $allowCancel)) {
            $order->update(['status' => 'Đã hủy']);
            return back()->with('success', 'Đã hủy đơn hàng thành công.');
        }

        return back()->with('error', 'Không thể hủy đơn hàng vì đơn đang được xử lý hoặc đã hoàn thành.');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('user.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $items = OrderItem::where('order_id', $order->id)->with('food')->get();
        return view('user.order_detail', compact('order', 'items'));
    }
}