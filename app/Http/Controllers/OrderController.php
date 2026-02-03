<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB; // 🟢 BẮT BUỘC PHẢI CÓ ĐỂ DÙNG TRANSACTION

class OrderController extends Controller
{
    // ====================================================
    // 1️⃣ TRANG THANH TOÁN (CHECKOUT)
    // ====================================================
    public function checkout()
    {
        // ⚡ TRƯỜNG HỢP 1: MUA NGAY (BUY NOW)
        // Kiểm tra xem trong Session có lưu món "mua ngay" không
        if (session()->has('buy_now_item')) {
            $itemData = session('buy_now_item');
            
            // Tạo một object giả lập cấu trúc giống Giỏ hàng để View không bị lỗi
            $cart = new \stdClass();
            $cart->items = collect([
                (object) [
                    'food_id'  => $itemData['id'],
                    'food'     => $itemData['food'], // Object món ăn
                    'price'    => $itemData['price'],
                    'quantity' => $itemData['quantity']
                ]
            ]);
            
            return view('user.checkout', compact('cart'));
        }

        // 🛒 TRƯỜNG HỢP 2: MUA TỪ GIỎ HÀNG
        $cart = Cart::with('items.food')
            ->where('user_id', auth()->id())
            ->first();

        // Nếu giỏ hàng trống hoặc không tồn tại -> Đá về trang giỏ hàng
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Giỏ hàng của bạn đang trống, vui lòng chọn món trước!');
        }

        return view('user.checkout', compact('cart'));
    }

    // ====================================================
    // 2️⃣ XỬ LÝ LƯU ĐƠN HÀNG (STORE)
    // ====================================================
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:255',
        ]);

        // 🟢 BẮT ĐẦU GIAO DỊCH (Transaction)
        // Giúp đảm bảo: Hoặc là lưu thành công tất cả, hoặc là không lưu gì cả (tránh lỗi rác data)
        DB::beginTransaction();

        try {
            $total = 0;
            $itemsToOrder = [];
            $isBuyNow = false;

            // --- BƯỚC A: LẤY DỮ LIỆU MÓN ĂN ---
            
            // Nếu là Mua Ngay
            if (session()->has('buy_now_item')) {
                $itemData = session('buy_now_item');
                $total = $itemData['price'] * $itemData['quantity'];
                
                $itemsToOrder[] = [
                    'food_id'  => $itemData['id'],
                    'price'    => $itemData['price'],
                    'quantity' => $itemData['quantity']
                ];
                $isBuyNow = true;
            } 
            // Nếu là Mua từ Giỏ hàng
            else {
                $cart = Cart::with('items')->where('user_id', auth()->id())->first();

                // Check kỹ lần cuối
                if (!$cart || $cart->items->isEmpty()) {
                    return redirect()->route('cart');
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

            // --- BƯỚC B: TẠO ĐƠN HÀNG (ORDER) ---
            $order = Order::create([
                'user_id'       => auth()->id(),
                'customer_name' => $request->customer_name,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'total_price'   => $total,
                // ⚠️ QUAN TRỌNG: Phải là 'Chờ xác nhận' để khớp với Admin Controller
                'status'        => 'Chờ xác nhận', 
            ]);

            // --- BƯỚC C: TẠO CHI TIẾT ĐƠN (ORDER ITEMS) ---
            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id'  => $item['food_id'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // --- BƯỚC D: DỌN DẸP ---
            if ($isBuyNow) {
                session()->forget('buy_now_item'); // Xóa session mua ngay
            } else {
                $cart->items()->delete(); // Xóa sạch giỏ hàng trong DB
            }

            // ✅ MỌI THỨ OK -> LƯU VÀO DB
            DB::commit();

            return redirect()->route('orders')
                ->with('success', '🎉 Đặt hàng thành công! Đơn hàng đang chờ quán xác nhận.');

        } catch (\Exception $e) {
            // ❌ CÓ LỖI -> HOÀN TÁC MỌI THỨ
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    // ====================================================
    // 3️⃣ DANH SÁCH ĐƠN HÀNG CỦA TÔI
    // ====================================================
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest() // Sắp xếp mới nhất lên đầu
            ->get();

        return view('user.orders', compact('orders'));
    }

    // ====================================================
    // 4️⃣ CHI TIẾT ĐƠN HÀNG
    // ====================================================
    public function show($id)
    {
        // Tìm đơn hàng (Chỉ cho phép xem đơn của chính mình)
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Lấy danh sách món trong đơn đó
        $items = OrderItem::where('order_id', $order->id)
            ->with('food') // Load kèm thông tin món ăn (tên, ảnh)
            ->get();

        return view('user.order_detail', compact('order', 'items'));
    }
}