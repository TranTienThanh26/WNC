<?php

namespace App\Http\Controllers;

use App\Models\Food;

class HomeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Food::latest();

        if ($request->has('address') && $request->address != null) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        // Lấy 8 món (sau khi lọc hoặc mặc định)
        $foods = $query->take(8)->get();

        // Đếm tổng số món trong DB (để hiện nút "Xem thêm") - cái này đếm tổng tất cả, hoặc đếm theo filter tùy ý, 
        // nhưng để đơn giản ta cứ đếm count() của query nếu muốn ẩn nút xem thêm khi filter.
        // Tuy nhiên logic cũ là Food::count() là tổng toàn DB. Để giữ nguyên logic cũ cho nút Xem thêm:
        $totalFoods = Food::count();

        return view('home', compact('foods', 'totalFoods'));
    }
}
