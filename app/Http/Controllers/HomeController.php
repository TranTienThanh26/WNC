<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::latest(); // Mặc định lấy món mới nhất

        // Nếu người dùng nhập địa chỉ tìm kiếm ở Hero Banner
        if ($request->has('address') && $request->address != null) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        // Lấy 8 món nổi bật để hiển thị trang chủ (không cần phân trang ở đây)
        $foods = $query->take(8)->get();
        
        // Đếm tổng để hiện nút "Xem thêm" nếu cần
        $totalFoods = Food::count();

        return view('user.home', compact('foods', 'totalFoods'));
    }
}