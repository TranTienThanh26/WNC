<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 🏠 1. DASHBOARD (TỔNG QUAN)
    public function index()
    {
        $totalOrders = Order::count();
        
        // Doanh thu: Chỉ tính những đơn KHÔNG bị hủy
        $revenue = Order::where('status', '!=', 'Đã hủy')->sum('total_price');
        
        $totalFoods  = Food::count();
        
        // Đếm user thường (không tính admin)
        $totalUsers  = User::where('role', 'user')->count();

        // Lấy 5 món mới nhất để hiển thị widget
        $newFoods    = Food::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'revenue', 'totalFoods', 'totalUsers', 'newFoods'));
    }

    // ====================================================
    // 🍔 QUẢN LÝ MÓN ĂN (FOODS)
    // ====================================================

    // Danh sách món ăn (Giao diện chính chứa cả Modal Thêm/Sửa)
    public function foodIndex()
    {
        // Paginate 10 món mỗi trang (100 là quá nhiều, kéo mỏi tay)
        $foods = Food::latest()->paginate(10); 
        return view('admin.foods.index', compact('foods'));
    }

    // 🟢 XỬ LÝ THÊM MỚI (Từ Modal)
    public function foodStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'category' => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address'  => 'nullable|string'
        ]);

        $data = $request->all();

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success', '✅ Thêm món ăn thành công!');
    }

    // 🟠 XỬ LÝ CẬP NHẬT (Từ Modal)
    public function foodUpdate(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'category' => 'required',
            'address'  => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Nếu có up ảnh mới thì thay thế, không thì giữ nguyên
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success', '✅ Cập nhật món ăn thành công!');
    }

    // 🔴 XÓA MÓN ĂN
    public function foodDelete($id)
    {
        $food = Food::findOrFail($id);
        
        // (Tuỳ chọn) Nếu muốn xóa cả ảnh trong folder storage để tiết kiệm dung lượng:
        // if ($food->image && \Storage::disk('public')->exists($food->image)) {
        //    \Storage::disk('public')->delete($food->image);
        // }

        $food->delete();
        
        return back()->with('success', '🗑️ Đã xóa món ăn khỏi thực đơn.');
    }

    // ====================================================
    // 📦 QUẢN LÝ ĐƠN HÀNG (ORDERS)
    // ====================================================

    // Danh sách đơn hàng
    public function orderIndex()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Cập nhật trạng thái đơn
    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Validate dữ liệu đầu vào cho an toàn
        $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đang chuẩn bị,Đang giao,Đã giao hàng,Đã hủy'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', '🔄 Trạng thái đơn hàng đã được cập nhật.');
    }
}