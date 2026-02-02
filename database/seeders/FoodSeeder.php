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
        // Xóa dữ liệu cũ để tránh trùng lặp nếu cần
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Food::truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $foods = [
            [
                'name' => 'Bún Chả Hương Quê',
                'price' => 45000,
                'description' => 'Bún chả Hà Nội truyền thống, thịt nướng than hoa thơm lừng.',
                'image' => 'foods/buncha.jpg',
                'category' => 'Món chính',
                'address' => '12 Hàng Than, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Phở Bò Lý Quốc Sư',
                'price' => 60000,
                'description' => 'Phở bò tái chín nước dùng ngọt xương hầm 24h.',
                'image' => 'foods/phobo.jpg',
                'category' => 'Món chính',
                'address' => '10 Lý Quốc Sư, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Cơm Tấm Sài Gòn 1985',
                'price' => 55000,
                'description' => 'Cơm tấm sườn bì chả, mỡ hành béo ngậy chuẩn vị Sài Gòn.',
                'image' => 'foods/comtam.jpg',
                'category' => 'Cơm',
                'address' => '54 Cầu Giấy, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Gà Rán Popeyes',
                'price' => 120000,
                'description' => 'Combo gà rán giòn cay + khoai tây chiên + nước ngọt.',
                'image' => 'foods/garan.jpg',
                'category' => 'Fast Food',
                'address' => 'Tầng 1 Indochina Plaza, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Trà Sữa Ding Tea',
                'price' => 35000,
                'description' => 'Trà sữa trân châu đen vị hồng trà đậm đà.',
                'image' => 'foods/trasua.jpg',
                'category' => 'Đồ uống',
                'address' => '156 Xuân Thủy, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Banh Mi Phuong',
                'price' => 30000,
                'description' => 'Bánh mì thập cẩm đặc biệt, pate gan ngỗng béo ngậy.',
                'image' => 'foods/banhmy.jpg',
                'category' => 'Fast Food',
                'address' => '23 Lò Sũ, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Pizza 4P\'s',
                'price' => 250000,
                'description' => 'Pizza kiểu Nhật với phô mai Burrata tươi tự làm.',
                'image' => 'foods/pizaaa.jpg',
                'category' => 'Pizza',
                'address' => 'Tầng 1, Lotte Center, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Mỳ Cay 7 Cấp Độ',
                'price' => 50000,
                'description' => 'Mỳ cay hải sản Hàn Quốc, thử thách độ cay cấp 7.',
                'image' => 'foods/mycayy.jpg',
                'category' => 'Món Á – Âu',
                'address' => '102 Chùa Láng, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Bún Đậu Mắm Tôm Cô Hằng',
                'price' => 40000,
                'description' => 'Mẹt bún đậu đầy đủ: đậu rán, chả cốm, nem chua rán, thịt chân giò.',
                'image' => 'foods/noodles.jpg',
                'category' => 'Món chính',
                'address' => 'Ngõ 65 Phạm Ngọc Thạch, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Cà Phê Giảng',
                'price' => 35000,
                'description' => 'Cà phê trứng nổi tiếng Hà Nội, thơm ngon, béo ngậy.',
                'image' => 'foods/coffee.jpg',
                'category' => 'Đồ uống',
                'address' => '39 Nguyễn Hữu Huân, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Lẩu Haidilao',
                'price' => 500000,
                'description' => 'Lẩu Trung Hoa nổi tiếng với dịch vụ múa mì đặc sắc.',
                'image' => 'foods/sushi.jpg',
                'category' => 'Món Á – Âu',
                'address' => 'Vincom Phạm Ngọc Thạch, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Nem Nướng Nha Trang',
                'price' => 65000,
                'description' => 'Nem nướng cuốn bánh tráng với rau sống và nước chấm đặc biệt.',
                'image' => 'foods/noodles.jpg',
                'category' => 'Món chính',
                'address' => '18 Phan Bội Châu, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Burger Bò Úc',
                'price' => 95000,
                'description' => 'Burger bò Úc 100% thịt thăn, phô mai cheddar, rau tươi.',
                'image' => 'foods/burger.jpg',
                'category' => 'Fast Food',
                'address' => '45 Trần Duy Hưng, Cầu Giấy, Hà Nội'
            ],
            [
                'name' => 'Cơm Gà Hải Nam',
                'price' => 65000,
                'description' => 'Cơm gà Hải Nam truyền thống, gà luộc mềm, cơm thơm nức mũi.',
                'image' => 'foods/comgahainam.jpg',
                'category' => 'Món chính',
                'address' => '78 Láng Hạ, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Sushi Set Premium',
                'price' => 350000,
                'description' => 'Set sushi cao cấp gồm 20 miếng: cá hồi, cá ngừ, bạch tuộc.',
                'image' => 'foods/sushi.jpg',
                'category' => 'Món chính',
                'address' => '12 Lý Thường Kiệt, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Trà Đào Cam Sả',
                'price' => 40000,
                'description' => 'Trà đào cam sả mát lạnh, vị chua ngọt hài hòa.',
                'image' => 'foods/tradaocamsa.jpg',
                'category' => 'Đồ uống',
                'address' => '89 Nguyễn Trãi, Thanh Xuân, Hà Nội'
            ],
            [
                'name' => 'Cà Phê Sữa Đá',
                'price' => 25000,
                'description' => 'Cà phê sữa đá truyền thống Việt Nam, đậm đà thơm ngon.',
                'image' => 'foods/caphesuada.jpg',
                'category' => 'Đồ uống',
                'address' => '34 Hàng Bài, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Mì Ý Carbonara',
                'price' => 85000,
                'description' => 'Mì Ý Carbonara sốt kem trứng, thịt xông khói giòn.',
                'image' => 'foods/mycarbonara.jpg',
                'category' => 'Fast Food',
                'address' => '56 Hoàng Cầu, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Gà Rán KFC',
                'price' => 110000,
                'description' => 'Combo gà rán giòn tan, khoai tây chiên, pepsi.',
                'image' => 'foods/chicken.jpg',
                'category' => 'Fast Food',
                'address' => '123 Giảng Võ, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Pizza Hải Sản',
                'price' => 280000,
                'description' => 'Pizza hải sản tươi ngon: tôm, mực, nghêu, sò điệp.',
                'image' => 'foods/pizza.jpg',
                'category' => 'Fast Food',
                'address' => '67 Trần Phú, Hà Đông, Hà Nội'
            ],
            [
                'name' => 'Phở Gà Nấm',
                'price' => 55000,
                'description' => 'Phở gà nấm thơm ngon, nước dùng ngọt thanh.',
                'image' => 'foods/pho.jpg',
                'category' => 'Món chính',
                'address' => '23 Tôn Đức Thắng, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Trà Sữa Matcha',
                'price' => 45000,
                'description' => 'Trà sữa matcha Nhật Bản, vị đắng nhẹ, thơm mát.',
                'image' => 'foods/milk_tea.jpg',
                'category' => 'Đồ uống',
                'address' => '90 Nguyễn Chí Thanh, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Cơm Chiên Dương Châu',
                'price' => 50000,
                'description' => 'Cơm chiên Dương Châu đầy đủ: tôm, xúc xích, trứng.',
                'image' => 'foods/fried_rice.jpg',
                'category' => 'Món chính',
                'address' => '15 Phố Huế, Hai Bà Trưng, Hà Nội'
            ],
            [
                'name' => 'Mì Ramen Nhật Bản',
                'price' => 75000,
                'description' => 'Mì ramen Nhật Bản nước dùng đậm đà, thịt xá xíu mềm.',
                'image' => 'foods/noodles.jpg',
                'category' => 'Món chính',
                'address' => '88 Kim Mã, Ba Đình, Hà Nội'
            ],
            [
                'name' => 'Sinh Tố Bơ',
                'price' => 35000,
                'description' => 'Sinh tố bơ sánh mịn, béo ngậy, bổ dưỡng.',
                'image' => 'foods/sinhtobo.jpg',
                'category' => 'Đồ uống',
                'address' => '44 Bà Triệu, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Gà Nướng Mật Ong',
                'price' => 130000,
                'description' => 'Gà nướng mật ong thơm phức, da giòn thịt mềm.',
                'image' => 'foods/chicken.jpg',
                'category' => 'Món chính',
                'address' => '99 Láng Hạ, Đống Đa, Hà Nội'
            ],
            [
                'name' => 'Pizza Pepperoni',
                'price' => 220000,
                'description' => 'Pizza pepperoni cổ điển, xúc xích cay, phô mai mozzarella.',
                'image' => 'foods/pizza.jpg',
                'category' => 'Fast Food',
                'address' => '33 Lê Duẩn, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Cà Phê Đen Đá',
                'price' => 20000,
                'description' => 'Cà phê đen đá đậm đà, tỉnh táo tinh thần.',
                'image' => 'foods/coffee.jpg',
                'category' => 'Đồ uống',
                'address' => '77 Hàng Bông, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Sushi California Roll',
                'price' => 180000,
                'description' => 'Sushi California roll với cua, bơ, dưa chuột.',
                'image' => 'foods/sushi.jpg',
                'category' => 'Món chính',
                'address' => '22 Hai Bà Trưng, Hoàn Kiếm, Hà Nội'
            ],
            [
                'name' => 'Burger Gà Giòn',
                'price' => 75000,
                'description' => 'Burger gà giòn cay, rau xà lách, sốt mayonnaise.',
                'image' => 'foods/burger.jpg',
                'category' => 'Fast Food',
                'address' => '111 Nguyễn Văn Cừ, Long Biên, Hà Nội'
            ],
            [
                'name' => 'Cơm Sườn Nướng',
                'price' => 60000,
                'description' => 'Cơm sườn nướng thơm lừng, sườn mềm thấm gia vị.',
                'image' => 'foods/fried_rice.jpg',
                'category' => 'Món chính',
                'address' => '55 Đê La Thành, Đống Đa, Hà Nội'
            ]
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
