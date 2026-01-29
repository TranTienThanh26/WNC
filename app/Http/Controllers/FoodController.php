<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /* =========================
     * 1. DANH SÁCH MÓN (MENU)
     * ========================= */
    public function index()
    {
        $foods = Food::latest()->paginate(12);
        return view('menu', compact('foods'));
    }

    /* =========================
     * 2. FORM THÊM MÓN
     * ========================= */
    public function create()
    {
        return view('food_create');
    }

    /* =========================
     * 3. LƯU MÓN + ẢNH
     * ========================= */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // upload ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($data);

        return redirect()->route('menu')
            ->with('success', '✅ Thêm món ăn thành công');
    }

    /* =========================
     * 4. TRANG CHI TIẾT MÓN ĂN
     * ========================= */
    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('food_detail', compact('food'));
    }

    /* =========================
     * 5. FORM SỬA MÓN
     * ========================= */
    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('food_edit', compact('food'));
    }

    /* =========================
     * 6. CẬP NHẬT MÓN + ẢNH
     * ========================= */
    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // nếu có ảnh mới → thay ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($data);

        return redirect()->route('food.show', $food->id)
            ->with('success', '✅ Cập nhật món thành công');
    }

    /* =========================
     * 7. XÓA MÓN
     * ========================= */
    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->route('menu')
            ->with('success', '🗑️ Đã xóa món ăn');
    }
}
