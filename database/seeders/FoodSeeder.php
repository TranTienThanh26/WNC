<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            [
                'name' => 'Pizza Hải Sản',
                'price' => 85000,
                'image' => 'foods/pizza.jpg',
                'description' => 'Pizza nóng giòn với hải sản tươi ngon'
            ],
            [
                'name' => 'Burger Bò Phô Mai',
                'price' => 45000,
                'image' => 'foods/burger.jpg',
                'description' => 'Burger bò Úc phô mai béo ngậy'
            ],
            [
                'name' => 'Cơm Chiên Hải Sản',
                'price' => 40000,
                'image' => 'foods/fried_rice.jpg',
                'description' => 'Cơm chiên vàng đều, đậm vị'
            ],
            [
                'name' => 'Trà Sữa Trân Châu',
                'price' => 30000,
                'image' => 'foods/milk_tea.jpg',
                'description' => 'Trà sữa ngọt dịu, trân châu dai'
            ],
            [
                'name' => 'Phở Bò Tái',
                'price' => 50000,
                'image' => 'foods/pho.jpg',
                'description' => 'Phở truyền thống Việt Nam'
            ],
            [
                'name' => 'Sushi Cá Hồi',
                'price' => 90000,
                'image' => 'foods/sushi.jpg',
                'description' => 'Sushi cá hồi tươi sống'
            ],
            [
                'name' => 'Mì Xào Hải Sản',
                'price' => 55000,
                'image' => 'foods/noodles.jpg',
                'description' => 'Mì xào nóng hổi, nhiều topping'
            ],
            [
                'name' => 'Gà Rán Giòn',
                'price' => 60000,
                'image' => 'foods/chicken.jpg',
                'description' => 'Gà rán giòn rụm, thơm ngon'
            ],
            [
                'name' => 'Cà Phê Sữa Đá',
                'price' => 25000,
                'image' => 'foods/coffee.jpg',
                'description' => 'Cà phê đậm đà kiểu Việt'
            ],
        ];

        // 👉 Lặp lại để đủ 30 món
        for ($i = 0; $i < 3; $i++) {
            foreach ($foods as $food) {
                Food::create($food);
            }
        }
    }
}
