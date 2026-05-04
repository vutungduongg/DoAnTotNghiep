<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $shirts = Category::query()->firstOrCreate(
            ['slug' => 'ao-dau'],
            ['name' => 'Áo đấu', 'description' => 'Áo đấu CLB/ĐTQG', 'is_active' => true]
        );

        $shoes = Category::query()->firstOrCreate(
            ['slug' => 'giay-bong-da'],
            ['name' => 'Giày bóng đá', 'description' => 'Giày đá sân cỏ nhân tạo/tự nhiên', 'is_active' => true]
        );

        $p1 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-nam-vang-xanh-nang-dong'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/1.jpg',
                'name' => 'Áo Thể Thao Nam Vàng Xanh – Năng Động & Bứt Phá',
                'description' => "Áo đấu chất liệu thoáng khí.\nCó đủ size S/M/L/XL.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );

        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p1->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p2 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-do-do-vang-dang-cap'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/10.jpg',
                'name' => 'Áo Thể Thao Đỏ Đô Vàng – Mạnh Mẽ & Đẳng Cấp',
                'description' => "Giày sân cỏ nhân tạo (TF).\nForm ôm chân.",
                'base_price' => 499000,
                'is_active' => true,
            ]
        );

        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p2->id, 'size' => $size],
                ['stock' => 30]
            );
        }
    }
}
