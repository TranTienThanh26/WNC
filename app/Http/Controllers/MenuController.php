<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * 1️⃣ TRANG MENU - TẤT CẢ MÓN
     * URL: /menu
     */
    public function index()
    {
        // Lấy tất cả món ăn, mới nhất hiện lên đầu
        $foods = Food::orderBy('id', 'desc')->get();

        return view('menu', compact('foods'));
    }

    /**
     * 2️⃣ MENU THEO DANH MỤC
     * URL: /menu/{category}
     */
    public function category($category)
    {
        /* SỬA TẠI ĐÂY: 
           Không dùng mảng ['drink', 'fastfood'] vì database của bạn lưu tiếng Việt.
           Controller sẽ lấy trực tiếp $category từ URL để tìm trong DB.
        */
        
        $foods = Food::where('category', $category)
                     ->orderBy('id', 'desc')
                     ->get();

        // Trả về view menu với danh sách đã lọc
        return view('menu', compact('foods', 'category'));
    }

    /**
     * 3️⃣ TÌM KIẾM MÓN ĂN
     * URL: /search-food?keyword=ga
     */
    public function search(Request $request)
    {
        $keyword = trim($request->keyword);

        if (empty($keyword)) {
            return redirect()->route('menu');
        }

        $foods = Food::where('name', 'LIKE', '%' . $keyword . '%')
                     ->orderBy('id', 'desc')
                     ->get();

        return view('menu', compact('foods', 'keyword'));
    }
}