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
            ['slug' => 'ao-the-thao'],
            ['name' => 'Áo thể thao', 'description' => 'Áo thể thao dành cho người chơi', 'is_active' => true]
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
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
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
                'image_path' => 'images/2.jpg',
                'name' => 'Áo Thể Thao Đỏ Đô Vàng – Mạnh Mẽ & Đẳng Cấp',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p2->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p3 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-trang-kem-xanh-dam-phoi-mau-thoi-thuong-nang-dong'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/3.jpg',
                'name' => 'Áo Bóng Đá Trắng Kem Xanh Đậm – Phối Màu Thời Thượng, Năng Động',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p3->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p4 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-san-xanh-duong-camo-ran-ri-thiet-ke-nang-dong-hien-dai'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/4.jpg',
                'name' => 'Áo Bóng Đá Sân Xanh Dương Camo Rằn Ri – Thiết Kế Năng Động, Hiện Đại',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p4->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p5 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-nam-trang-xanh-dam-phoi-soc-chim-nang-dong-lich-lam'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/5.jpg',
                'name' => 'Áo Bóng Đá Nam Trắng Xanh Đậm Phối Sọc Chìm – Năng Động & Lịch Lãm',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p5->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p6 = Product::query()->firstOrCreate(
            ['slug' => 'ao-dau-bong-da-do-den-trang-thiet-ke-the-thao-nang-dong-chat-lieu-cao-cap'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/6.jpg',
                'name' => 'Áo Đấu Bóng Đá Đỏ Đen Trắng – Thiết Kế Thể Thao Năng Động, Chất Liệu Cao Cấp',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p6->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p7 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-nam-vang-pastel-xanh-navy-hoa-tiet-hinh-hoc-hien-dai'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/7.jpg',
                'name' => 'Áo Thể Thao Nam Vàng Pastel Xanh Navy – Họa Tiết Hình Học Hiện Đại',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p7->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p8 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-xanh-navy-hoa-tiet-la-cach-dieu-nang-dong-tien-dung-ca-tinh'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/8.jpg',
                'name' => 'Áo Thể Thao Xanh Navy Họa Tiết Lá Cách Điệu | Năng Động – Tiện Dụng – Cá Tính',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p8->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p9 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-xanh-duong-nang-dong-vien-vang-thiet-ke-hien-dai-ca-tinh'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/9.jpg',
                'name' => 'Áo Thể Thao Xanh Dương Năng Động Viền Vàng – Thiết Kế Hiện Đại Cá Tính',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p9->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p10 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-do-do-ruc-ro-nang-luong-va-dang-cap-the-thao'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/10.jpg',
                'name' => 'Áo Bóng Đá Đỏ Rực Rỡ – Năng Lượng Và Đẳng Cấp Thể Thao',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p10->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p11 = Product::query()->firstOrCreate(
            ['slug' => 'bo-quan-ao-bong-da-den-tim-hong-neon-hoa-tiet-tru-tuong-2026'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/11.jpg',
                'name' => 'Bộ quần áo bóng đá đen tím hồng neon họa tiết trừu tượng 2026',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p11->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p12 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-trang-hong-loang-vien-den-nang-dong-hien-dai'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/12.jpg',
                'name' => 'Áo bóng đá Trắng Hồng Loang viền đen – Năng Động, Hiện Đại',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p12->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p13 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-mau-cam-den-hien-dai-in-ten-so-theo-yeu-cau'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/13.jpg',
                'name' => 'Áo Bóng Đá Màu Cam Đen Hiện Đại – In Tên Số Theo Yêu Cầu',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p13->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p14 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-nam-nu-beige-kem-hoa-tiet-xanh-navy-nang-dong-thoi-thuong'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/14.jpg',
                'name' => 'Áo Thể Thao Nam Nữ Beige Kem Hoạ Tiết Xanh Navy – Năng Động, Thời Thượng',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p14->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p15 = Product::query()->firstOrCreate(
            ['slug' => 'bo-quan-ao-the-thao-nam-trang-tim-thiet-ke-gradient-nang-dong'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/15.jpg',
                'name' => 'Bộ Quần Áo Thể Thao Nam Trắng Tím Thiết Kế Gradient Năng Động',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p15->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p16 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-xanh-luc-phoi-soc-vang-neon-nang-dong-2024'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/16.jpg',
                'name' => 'Áo Bóng Đá Xanh Lục Phối Sọc Vàng Neon Năng Động 2024',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p16->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p17 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-nam-mau-kem-nhat-phot-cam-den'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/17.jpg',
                'name' => 'Áo Thể Thao Nam Màu Kem Nhạt Phối Cam Đen',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p17->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p18 = Product::query()->firstOrCreate(
            ['slug' => 'ao-da-bong-trang-do-hoa-tiet-vo-hien-dai-nang-dong-va-ca-tinh'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/18.jpg',
                'name' => 'Áo Đá Bóng Trắng Đỏ Họa Tiết Vỡ Hiện Đại – Năng Động & Cá Tính',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p18->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p19 = Product::query()->firstOrCreate(
            ['slug' => 'ao-bong-da-vang-do-2026-hoa-tiet-chuyen-mau-nang-dong'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/19.jpg',
                'name' => 'Áo Bóng Đá Vàng Đỏ 2026 Họa Tiết Chuyển Màu Năng Động',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p19->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p20 = Product::query()->firstOrCreate(
            ['slug' => 'bo-quan-ao-the-thao-xanh-dam-hong-chuyen-sac-nang-dong-ca-tinh'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/20.jpg',
                'name' => 'Bộ Quần Áo Thể Thao Xanh Đậm Hồng Chuyển Sắc – Thiết Kế Năng Động, Cá Tính',
                'description' => "Sở hữu màu sắc và họa tiết đơn giản, giúp dễ in ấn và phù hợp với mọi lứa tuổi.\nChất vải Fake Thái cao cấp luôn được khách hàng ưa chuộng.\nThoát hút mồ hôi tốt.\nThoát hơi nhanh.\nChống tia UV.",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p20->id, 'size' => $size],
                ['stock' => 50]
            );
        }

        $p21 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-ag-pro-kylian-mbappe-io0927-200'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/21.png',
                'name' => 'Nike Mercurial Vapor 16 Elite AG-Pro Kylian Mbappé IO0927-200',
                'description' => "Siêu phẩm thiết kế dành riêng cho siêu sao Kylian Mbappé, phiên bản đế AG-pro dành cho sân cỏ nhân tạo, trọng lượng siêu nhẹ, upper mỏng và mềm …",
                'base_price' => 299000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p21->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p22 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-tiempo-maestro-elite-fg-hq3157-146-trang-xanh'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/22.png',
                'name' => 'Nike Tiempo Maestro Elite FG HQ3157-146 trắng/ xanh',
                'description' => "Giày Nike Tiempo Elite cao cấp nhất, đế FG dành cho sân cỏ tự nhiên, upper siêu mềm, trọng lượng nhẹ …",
                'base_price' => 399000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p22->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p23 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-mizuno-morelia-neo-sala-beta-japan-tf-q1gb264064-trang-hong'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/23.png',
                'name' => 'Mizuno Morelia Neo Sala β Japan TF- trắng/ hồng Q1GB264064',
                'description' => "Giày bóng đá chính hãng Mizuno Made In Japan , siêu phẩm được sản xuất tại Nhật Bản, đáp ứng tiêu chuẩn riêng biệt chỉ có tại đây, đem lại trải nghiệm khác biệt …",
                'base_price' => 599000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p23->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p24 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-mizuno-alpha-iii-elite-fg-unity-sky-blue-white-p1ga266225'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/24.png',
                'name' => 'Mizuno Alpha III Elite FG Unity Sky- Blue/ White P1GA266225',
                'description' => "Giày bóng đá chín hãng Mizuno Alpha 3 Elite FG trọng lượng siêu nhẹ, upper mỏng, phù hợp cho sân cỏ tự nhiên …",
                'base_price' => 699000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p24->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p25 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-adidas-predator-club-tf-ft-xanh-ngoc-jr5912'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/25.png',
                'name' => 'Adidas Predator Club TF FT xanh ngọc JR5912',
                'description' => "Giày bóng đá chính hãng thiết kế lưỡi gà gập cực đẹp, hàng fullbox, bảo hành trọn đời, gửi nhiều size cho ae ở xa chọn, đổi size đổi mẫu không giới hạn.",
                'base_price' => 799000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p25->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p26 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-pro-fg-vjr-vinicius-jr-io9813-640'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/26.png',
                'name' => 'Nike Mercurial Vapor 16 Pro FG VJR Vinicius Jr IO9813-640',
                'description' => "Vapor 16 Pro FG phiên bản VJR phối màu cực đẹp, trọng lượng nhẹ, phù hợp cho san cỏ tự nhiên nhất …",
                'base_price' => 399000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p26->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p27 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-adidas-f50-league-mg-xanh-ngoc-jr8980'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/27.png',
                'name' => 'Adidas F50 League MG xanh ngọc JR8980',
                'description' => "Adidas F50 League MG phối màu xanh ngọc cực đẹp, đinh giày MG đa năng, chơi bóng cực tốt trên mặt sân cỏ nhân tạo nước ta, trọng lượng nhẹ …",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p27->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p28 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-adidas-f50-league-ag-xanh-ngoc-jq1485'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/28.png',
                'name' => 'Adidas F50 League AG xanh ngọc JQ1485',
                'description' => "Giày bóng đá Adidas F50 League AG thuần chủng, đế AG đinh trụ tròn phù hợp cho sân cỏ nhân tạo Việt Nam, trọng lượng nhẹ …",
                'base_price' => 299000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p28->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p29 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-adidas-f50-elite-ag-xanh-ngoc-jr6463'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/29.png',
                'name' => 'Adidas F50 Elite AG xanh ngọc JR6463',
                'description' => "Giày Adidas F50 Elite AG cao cấp nhất, đế AG thuần chủng phù hợp sân cỏ nhân tạo Việt Nam, trọng lượng giày siêu nhẹ, upper cực mỏng nhưng êm ái …",
                'base_price' => 399000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p29->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p30 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-academy-mg-nu3-rou-vang-io8443-661'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/30.png',
                'name' => 'Nike Mercurial Vapor 16 Academy MG NU3 rượu vang IO8443-661',
                'description' => "Giày Nike Vapor NU3 MG đa năng có thể chơi trên sân cỏ nhân tạo và tự nhiên, phối màu rượu vang hiếm thấy, trọng lượng nhẹ  thuộc BST Nike United 003, là phiên bản giới hạn trong series Nike…",
                'base_price' => 599000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p30->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p31 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-pro-tf-nu3-rou-vang-ir2357-661'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/31.png',
                'name' => 'Nike Mercurial Vapor 16 Pro TF NU3 rượu vang IR2357-661 Nike United 3',
                'description' => "Một siêu phẩm siêu hiếm mang tên Nike Mercurial Vapor 16 Pro TF NU3 rượu vang, phối màu đẹp độc đáo, bám sân hoàn hảo, upper cực mềm …",
                'base_price' => 699000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p31->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p32 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-fg-lv8-heat-up-pack-den-do-if4101-088'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/32.png',
                'name' => 'Nike Mercurial Vapor 16 Elite FG LV8 Heat Up pack đen/đỏ IF4101-088',
                'description' => "Nike Mercurial Vapor 16 Elite FG IF4101-088 – đỉnh cao của dòng Mercurial 2026 trên sân cỏ tự nhiên, thuộc bộ sưu tập Heat Up Pack độc quyền phân khúc Elite. Phối màu Black / Hyper Crimson: nền đen tuyền,…",
                'base_price' => 399000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p32->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p33 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-superfly-academy-tf-jr-racer-blue-fq8310-446'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/33.png',
                'name' => 'Nike Mercurial Superfly Academy TF Jr Racer Blue FQ8310-446',
                'description' => "Giày bóng đá cổ cao không dây buộc, phiên bản Junior size nhỏ- phom nhỏ, thiết kế đẹp ngoại thất đẹp, chất lượng tốt, bền bỉ …",
                'base_price' => 799000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p33->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p34 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-fg-lv8-heat-up-pack-den-do-if4101-088'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/34.png',
                'name' => 'Nike Mercurial Vapor Club MG VJR Vini Jr màu hồng – Sunset Pulse/Old Royal – IM3647-640',
                'description' => "Phiên bản signature mới nhất của Vinícius Júnior chính thức xuất hiện trên thế hệ Nike Mercurial 2026. Với phối màu hồng rực Sunset Pulse kết hợp đế xanh Old Royal",
                'base_price' => 899000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p34->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p35 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-fg-lv8-heat-up-pack-den-do-if4101-088'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/35.png',
                'name' => 'Nike Mercurial Vapor 16 Elite FG VJR Vinicius Jr IM3643-640',
                'description' => "Phiên bản signature mới nhất của Vinícius Júnior chính thức xuất hiện trên thế hệ Nike Mercurial 2026. Với phối màu hồng rực Sunset Pulse kết hợp đế xanh Old Royal , phân khúc Elite cao cấp nhất chính là…",
                'base_price' => 999000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p35->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p36 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-ag-vjr-vinicius-jr-io9812-640'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/36.png',
                'name' => 'Nike Mercurial Vapor 16 Elite AG VJR Vinicius Jr IO9812-640',
                'description' => "Siêu phẩm ngon nhất dành cho sân cỏ nhân tạo, trọng lượng siêu nhẹ, phối màu độc quyền dành cho Vinicius Jr …",
                'base_price' => 599000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p36->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p37 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-fg-se-io1555-800'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/37.png',
                'name' => 'Nike Mercurial Vapor 16 Elite FG SE IO1555-800',
                'description' => "Giày sân cỏ tự nhiên (FG).\nForm ôm chân.",
                'base_price' => 299000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p37->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p38 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-academy-ic-hong-hac-fq8434-600'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/38.png',
                'name' => 'Nike Mercurial Vapor 16 Academy IC hồng hạc FQ8434-600',
                'description' => "Ae yêu bóng đá đều hài lòng vì dịch vụ tốt nhất tại shop: không ưng ý hoàn tiền ngay, đổi size- đổi mẫu không giới hạn, bảo hành trọn đời, ship nhiều đôi để thử",
                'base_price' => 399000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p38->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p39 = Product::query()->firstOrCreate(
            ['slug' => 'giay-bong-da-nike-mercurial-vapor-16-elite-fg-km-xoai-chin-fq8683-801'],
            [
                'category_id' => $shoes->id,
                'image_path' => 'images/39.png',
                'name' => 'Nike Mercurial Vapor 16 Elite FG KM xoài chín FQ8683-801',
                'description' => "Hệ thống shop giày uy tín hơn 10 năm, đảm bảo hàng chính hãng đi kèm dịch vụ tốt nhất, 98% ae hài lòng",
                'base_price' => 199000,
                'is_active' => true,
            ]
        );
        foreach (['39', '40', '41', '42', '43'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p39->id, 'size' => $size],
                ['stock' => 30]
            );
        }

        $p40 = Product::query()->firstOrCreate(
            ['slug' => 'ao-the-thao-do-do-vang-dang-cap'],
            [
                'category_id' => $shirts->id,
                'image_path' => 'images/10.jpg',
                'name' => 'Nike Mercurial Vapor 16 Academy TF Junior màu xanh xám FQ8284-301',
                'description' => "Nike Mercurial Vapor 16 Academy TF Junior màu xanh xám FQ8284-301 thuộc Prism Pack 2025, phiên bản Junior với dải size phù hợp cho các cầu thủ nhí hoặc các nữ cầu thủ, size từ 33-38.5",
                'base_price' => 699000,
                'is_active' => true,
            ]
        );
        foreach (['33', '34', '35', '36', '37','38' ,'38.5'] as $size) {
            ProductVariant::query()->firstOrCreate(
                ['product_id' => $p40->id, 'size' => $size],
                ['stock' => 30]
            );
        }
    }
}
