<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class MenuController extends Controller
{
    // 1️⃣ HIỂN THỊ TẤT CẢ MÓN
    public function index()
    {
        // Sử dụng paginate thay vì get() để không bị load quá nhiều món 1 lúc
        $foods = Food::latest()->paginate(12);

       return view('user.menu', compact('foods'));
       }
    }

    // 2️⃣ LỌC THEO DANH MỤC (Ví dụ: /menu/Fast Food)
    public function category($category)
    {
        $foods = Food::where('category', $category)
                     ->latest()
                     ->paginate(12);

        // Truyền thêm biến $category để view hiển thị tiêu đề "Danh mục: Fast Food"
        return view('user.menu', compact('foods', 'category'));
    }

    // 3️⃣ TÌM KIẾM MÓN ĂN (Search)
    public function search(Request $request)
    {
        $keyword = trim($request->keyword);

        if (empty($keyword)) {
            return redirect()->route('menu');
        }

        $foods = Food::where('name', 'LIKE', '%' . $keyword . '%')
                     ->latest()
                     ->paginate(12);

        // withQueryString() giúp giữ lại từ khóa tìm kiếm khi bấm sang trang 2, 3
        $foods->appends(['keyword' => $keyword]);

        return view('user.menu', compact('foods', 'keyword'));
    }
}