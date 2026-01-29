<?php

namespace App\Http\Controllers;

use App\Models\Food;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 món mới nhất hiển thị ngoài trang chủ
        $foods = Food::latest()->take(8)->get();

        // Đếm tổng số món trong DB (để hiện nút "Xem thêm")
        $totalFoods = Food::count();

        return view('home', compact('foods', 'totalFoods'));
    }
}
