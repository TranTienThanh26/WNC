<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;

class MenuController extends Controller
{
    /**
     * 1️⃣ Hiển thị thực đơn & Lọc theo địa chỉ
     * URL: /menu?address=Hà+Nội
     */
    public function index(Request $request)
{
    $query = Food::with('category');

    // 🟢 Lọc chính xác theo cột address trong Database
    if ($request->filled('address')) {
        $loc = trim($request->address);
        $query->where('address', 'LIKE', "%{$loc}%");
    }

    $foods = $query->latest()->paginate(12);
    $foods->appends(['address' => $request->address]);

    return view('user.menu', compact('foods'));
}

    /**
     * 2️⃣ Lọc món theo danh mục (Giữ nguyên và tối ưu)
     */
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Food::with('category')->where('category_id', $category->id);

        // Vẫn cho phép lọc theo địa chỉ ngay cả khi đang ở trong Danh mục
        if ($request->filled('address')) {
            $address = trim($request->address);
            $query->where('description', 'LIKE', "%{$address}%");
        }

        $foods = $query->latest()->paginate(12);
        $foods->appends(['address' => $request->address]);

        return view('user.menu', compact('foods', 'category'));
    }

    /**
     * 3️⃣ Tìm kiếm món ăn theo từ khóa (Giữ nguyên)
     */
    public function search(Request $request)
    {
        $keyword = trim($request->keyword);

        if (!$keyword) {
            return redirect()->route('menu');
        }

        $foods = Food::with('category')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->latest()
            ->paginate(12);

        $foods->appends(['keyword' => $keyword]);

        return view('user.menu', compact('foods', 'keyword'));
    }
}