<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách món ăn nổi bật
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // --- 1️⃣ Query món ăn theo thời gian tạo mới nhất ---
        $query = Food::latest(); // 'latest()' tự động sắp xếp theo created_at DESC

        // --- 2️⃣ Nếu người dùng tìm kiếm theo địa chỉ ---
        if ($request->filled('address')) { // kiểm tra tồn tại và khác null
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        // --- 3️⃣ Lấy 8 món mới nhất / nổi bật ---
        $foods = $query->take(8)->get();

        // --- 4️⃣ Tổng số món ăn (dùng cho nút "Xem thêm") ---
        $totalFoods = Food::count();

        // --- 5️⃣ Trả dữ liệu ra view ---
        return view('user.home', compact('foods', 'totalFoods'));
    }
}
