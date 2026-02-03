<?php

namespace App\Http\Controllers;

use App\Models\Food;

class FoodController extends Controller
{
    // CHỈ GIỮ LẠI HÀM NÀY
    public function show($id)
    {
        $food = Food::findOrFail($id);
        
        // Gợi ý thêm 4 món cùng danh mục (tính năng Related Products)
        // where('id', '!=', $id) để tránh hiện lại chính món đang xem
        $relatedFoods = Food::where('category', $food->category)
                            ->where('id', '!=', $food->id)
                            ->take(4)
                            ->get();

        return view('food_detail', compact('food', 'relatedFoods'));
    }
}