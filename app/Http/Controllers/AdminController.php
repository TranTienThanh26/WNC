<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 🏠 DASHBOARD
    public function index()
    {
        $totalOrders = Order::count();
        $revenue     = Order::where('status', 'Đã giao hàng')->sum('total_price'); // Hoặc tính all tùy logic
        // Tạm tính doanh thu của tất cả đơn không bị hủy
        $revenue     = Order::where('status', '!=', 'Đã hủy')->sum('total_price');
        
        $totalFoods  = Food::count();
        $totalUsers  = User::where('role', 'user')->count();

        $newFoods    = Food::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'revenue', 'totalFoods', 'totalUsers', 'newFoods'));
    }

    // 🍔 MÓN ĂN - LIST
    public function foodIndex()
    {
        $foods = Food::latest()->paginate(100);
        return view('admin.foods.index', compact('foods'));
    }

    // 🍔 MÓN ĂN - FORM THÊM
    public function foodCreate()
    {
        return view('admin.foods.create');
    }

    // 🍔 MÓN ĂN - XỬ LÝ THÊM
    public function foodStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'category' => 'required',
            'image' => 'nullable|image',
            'address' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Thêm món ăn thành công');
    }

    // 🍔 MÓN ĂN - FORM SỬA
    public function foodEdit($id)
    {
        $food = Food::findOrFail($id);
        return view('admin.foods.edit', compact('food'));
    }

    // 🍔 MÓN ĂN - XỬ LÝ SỬA
    public function foodUpdate(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
            'category' => 'required',
            'address' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Cập nhật món ăn thành công');
    }

    // 🍔 MÓN ĂN - XÓA
    public function foodDelete($id)
    {
        Food::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa món ăn');
    }

    // 📦 ĐƠN HÀNG - LIST
    public function orderIndex()
    {
        $orders = Order::latest()->paginate(100);
        return view('admin.orders.index', compact('orders'));
    }

    // 📦 ĐƠN HÀNG - STATUS
    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }
}
