<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * 🏠 1. DASHBOARD (TỔNG QUAN)
     */
    public function index()
    {
        $totalOrders = Order::count();
        $revenue = Order::where('status', '!=', 'Đã hủy')->sum('total_price');
        $totalFoods  = Food::count();
        $totalUsers  = User::where('role', 'user')->count();
        $newFoods    = Food::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'revenue', 'totalFoods', 'totalUsers', 'newFoods'));
    }

    /**
     * 🍔 2. QUẢN LÝ MÓN ĂN (FOODS)
     */

    public function foodIndex()
    {
        $foods = Food::with('category')->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.foods.index', compact('foods', 'categories'));
    }

    public function foodStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'address'     => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success', '✅ Tuyệt phẩm đã được khởi tạo thành công!');
    }

    /**
     * 🟡 LẤY DỮ LIỆU SỬA (AJAX) - Trả về JSON để hiển thị lên Modal
     */
    public function foodEdit($id)
    {
        $food = Food::findOrFail($id);
        return response()->json($food);
    }

    /**
     * 🟠 CẬP NHẬT THÔNG TIN
     */
    public function foodUpdate(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'address'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu là file nội bộ (không phải URL Unsplash)
            if ($food->image && !filter_var($food->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($food->image);
            }
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success', '✅ Thông tin mỹ thực đã được cập nhật.');
    }

    /**
     * 🔴 XÓA MÓN ĂN
     */
    public function foodDelete($id)
    {
        $food = Food::findOrFail($id);
        
        if ($food->image && !filter_var($food->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($food->image);
        }

        $food->delete();
        
        return back()->with('success', '🗑️ Đã gỡ bỏ món ăn khỏi thực đơn Signature.');
    }

    /**
     * 📦 3. QUẢN LÝ ĐƠN HÀNG (ORDERS)
     */
    public function orderIndex()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đang chuẩn bị,Đang giao,Đã giao hàng,Đã hủy'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', '🔄 Trạng thái đơn hàng đã được cập nhật.');
    }
}