<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ để tránh trùng lặp nếu cần
        // Food::truncate(); 
        
        $foods = [
            [
                'name' => 'Bún Chả Hương Quê',
                'price' => 45000,
                'description' => 'Bún chả Hà Nội truyền thống, thịt nướng than hoa thơm lừng.',
                'image' => null, // Sử dụng ảnh mặc định trong view nếu null
                'category' => 'Món chính',
                'address' => '12 Hàng Than, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Phở Bò Lý Quốc Sư',
                'price' => 60000,
                'description' => 'Phở bò tái chín nước dùng ngọt xương hầm 24h.',
                'image' => null,
                'category' => 'Món chính',
                'address' => '10 Lý Quốc Sư, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Cơm Tấm Sài Gòn 1985',
                'price' => 55000,
                'description' => 'Cơm tấm sườn bì chả, mỡ hành béo ngậy chuẩn vị Sài Gòn.',
                'image' => null,
                'category' => 'Cơm',
                'address' => '54 Cầu Giấy, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Gà Rán Popeyes',
                'price' => 120000,
                'description' => 'Combo gà rán giòn cay + khoai tây chiên + nước ngọt.',
                'image' => null,
                'category' => 'Fast Food',
                'address' => 'Tầng 1 Indochina Plaza, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Trà Sữa Ding Tea',
                'price' => 35000,
                'description' => 'Trà sữa trân châu đen vị hồng trà đậm đà.',
                'image' => null,
                'category' => 'Đồ uống',
                'address' => '156 Xuân Thủy, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Bánh Mì Phượng',
                'price' => 30000,
                'description' => 'Bánh mì thập cẩm đặc biệt, pate gan ngỗng béo ngậy.',
                'image' => null,
                'category' => 'Fast Food',
                'address' => '23 Lò Sũ, Hoàn Kiếm, Hà Nội'
            ],
             [
                'name' => 'Pizza 4P\'s',
                'price' => 250000,
                'description' => 'Pizza kiểu Nhật với phô mai Burrata tươi tự làm.',
                'image' => null,
                'category' => 'Pizza',
                'address' => 'Tầng 1, Lotte Center, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Mỳ Cay 7 Cấp Độ',
                'price' => 50000,
                'description' => 'Mỳ cay hải sản Hàn Quốc, thử thách độ cay cấp 7.',
                'image' => null,
                'category' => 'Món Á – Âu',
                'address' => '102 Chùa Láng, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Bún Đậu Mắm Tôm Cô Hằng',
                'price' => 40000,
                'description' => 'Mẹt bún đậu đầy đủ: đậu rán, chả cốm, nem chua rán, thịt chân giò.',
                'image' => null,
                'category' => 'Món chính',
                'address' => 'Ngõ 65 Phạm Ngọc Thạch, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Cà Phê Giảng',
                'price' => 35000,
                'description' => 'Cà phê trứng nổi tiếng Hà Nội, thơm ngon, béo ngậy.',
                'image' => null,
                'category' => 'Đồ uống',
                'address' => '39 Nguyễn Hữu Huân, Hoàn Kiếm, Hà Nội'
            ],
             [
                'name' => 'Lẩu Haidilao',
                'price' => 500000,
                'description' => 'Lẩu Trung Hoa nổi tiếng với dịch vụ múa mì đặc sắc.',
                'image' => null,
                'category' => 'Món Á – Âu',
                'address' => 'Vincom Phạm Ngọc Thạch, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Nem Nướng Nha Trang',
                'price' => 65000,
                'description' => 'Nem nướng cuốn bánh tráng với rau sống và nước chấm đặc biệt.',
                'image' => null,
                'category' => 'Món chính',
                'address' => '18 Phan Bội Châu, Hoàn Kiếm, Hà Nội'
            ]
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
