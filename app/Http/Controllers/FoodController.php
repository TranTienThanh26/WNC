<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /* =========================
     * 1. DANH SÁCH MÓN (TẤT CẢ)
     * ========================= */
    public function index()
    {
        $foods = Food::latest()->paginate(12);
        return view('menu', compact('foods'));
    }

    /* =========================
     * 2. LỌC MÓN THEO CATEGORY
     * drink | fastfood | rice
     * ========================= */
    public function category($category)
    {
        $foods = Food::where('category', $category)
                     ->latest()
                     ->paginate(12);

        return view('menu', compact('foods'));
    }

    /* =========================
     * 3. FORM THÊM MÓN (ADMIN)
     * ========================= */
    public function create()
    {
        return view('food_create');
    }

    /* =========================
     * 4. LƯU MÓN + ẢNH + CATEGORY
     * ========================= */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'category'    => 'required|in:drink,fastfood,rice',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($data);

        return redirect()->route('menu')
            ->with('success', '✅ Thêm món ăn thành công');
    }

    /* =========================
     * 5. CHI TIẾT MÓN
     * ========================= */
    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('food_detail', compact('food'));
    }

    /* =========================
     * 6. FORM SỬA MÓN
     * ========================= */
    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('food_edit', compact('food'));
    }

    /* =========================
     * 7. CẬP NHẬT MÓN + ẢNH
     * ========================= */
    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'category'    => 'required|in:drink,fastfood,rice',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Nếu có ảnh mới → thay ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($data);

        return redirect()->route('food.show', $food->id)
            ->with('success', '✅ Cập nhật món thành công');
    }

    /* =========================
     * 8. XÓA MÓN
     * ========================= */
    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->route('menu')
            ->with('success', '🗑️ Đã xóa món ăn');
    }
}
