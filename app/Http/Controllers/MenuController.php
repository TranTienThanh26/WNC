<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * ===============================
     * 1️⃣ TRANG MENU (TẤT CẢ MÓN)
     * ===============================
     * URL: /menu
     */
    public function index()
    {
        $foods = Food::orderBy('id', 'desc')->get();
        return view('menu', compact('foods'));
    }

    /**
     * ===============================
     * 2️⃣ MENU THEO DANH MỤC
     * ===============================
     * URL: /menu/do-uong
     *      /menu/com
     *      /menu/thuc-an-nhanh
     */
    public function category($category)
    {
        $foods = Food::where('category', $category)
            ->orderBy('id', 'desc')
            ->get();

        return view('menu', compact('foods'));
    }

    /**
     * ===============================
     * 3️⃣ TÌM MÓN ĂN (GÕ CHỮ LÀ RA)
     * ===============================
     * URL: /search-food?q=ga
     */
    public function search(Request $request)
    {
        $keyword = $request->q;

        if (!$keyword) {
            return response()->json([]);
        }

        $foods = Food::where('name', 'LIKE', '%' . $keyword . '%')
            ->limit(10)
            ->get([
                'id',
                'name',
                'price',
                'image'
            ]);

        return response()->json($foods);
    }
}
