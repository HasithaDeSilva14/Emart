<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class LaptopProductsSeeder extends Seeder
{
    public function run()
    {
        // Create Laptops category
        $category = Category::firstOrCreate(
            ['name' => 'Laptops'],
            ['slug' => 'laptops']
        );

        $laptops = [
            [
                'name' => 'MacBook Pro 16" M3 Max',
                'slug' => 'macbook-pro-16-m3-max',
                'description' => 'The most powerful MacBook Pro ever with M3 Max chip, stunning Liquid Retina XDR display, and up to 22 hours of battery life. Perfect for professionals.',
                'price' => 2499.99,
                'stock_quantity' => 15,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/macbook-pro.png',
                'is_active' => true,
            ],
            [
                'name' => 'Dell XPS 15 9530',
                'slug' => 'dell-xps-15-9530',
                'description' => 'Premium laptop with InfinityEdge display, 13th Gen Intel Core i7, NVIDIA RTX 4050, and stunning platinum silver finish.',
                'price' => 1899.99,
                'stock_quantity' => 20,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/dell-xps.png',
                'is_active' => true,
            ],
            [
                'name' => 'HP Spectre x360 14',
                'slug' => 'hp-spectre-x360-14',
                'description' => '2-in-1 convertible laptop with 360-degree hinge, Intel Evo platform, stunning OLED display, and premium gem-cut design.',
                'price' => 1599.99,
                'stock_quantity' => 18,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/hp-spectre.png',
                'is_active' => true,
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon Gen 11',
                'slug' => 'lenovo-thinkpad-x1-carbon-gen-11',
                'description' => 'Business ultrabook with legendary ThinkPad keyboard, military-grade durability, 13th Gen Intel processors, and all-day battery life.',
                'price' => 1749.99,
                'stock_quantity' => 25,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/lenovo-thinkpad.png',
                'is_active' => true,
            ],
            [
                'name' => 'ASUS ZenBook 14 OLED',
                'slug' => 'asus-zenbook-14-oled',
                'description' => 'Ultra-portable laptop with stunning OLED display, NumberPad 2.0, Intel Core i7, and premium royal blue finish.',
                'price' => 1299.99,
                'stock_quantity' => 22,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/asus-zenbook.png',
                'is_active' => true,
            ],
            [
                'name' => 'Acer Swift 3 SF314',
                'slug' => 'acer-swift-3-sf314',
                'description' => 'Lightweight and portable laptop with AMD Ryzen 7, full HD display, and all-day battery life. Perfect for students and professionals.',
                'price' => 799.99,
                'stock_quantity' => 30,
                'low_stock_threshold' => 10,
                'image_path' => '/images/products/acer-swift.png',
                'is_active' => true,
            ],
            [
                'name' => 'MSI GF63 Thin Gaming Laptop',
                'slug' => 'msi-gf63-thin-gaming',
                'description' => 'Affordable gaming laptop with NVIDIA RTX 4050, 144Hz display, RGB keyboard, and powerful cooling system.',
                'price' => 1199.99,
                'stock_quantity' => 12,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/msi-gaming.png',
                'is_active' => true,
            ],
            [
                'name' => 'Razer Blade 15 Advanced',
                'slug' => 'razer-blade-15-advanced',
                'description' => 'Premium gaming laptop with RTX 4070, QHD 240Hz display, per-key RGB keyboard, and CNC aluminum unibody.',
                'price' => 2799.99,
                'stock_quantity' => 8,
                'low_stock_threshold' => 3,
                'image_path' => '/images/products/razer-blade.png',
                'is_active' => true,
            ],
            [
                'name' => 'Microsoft Surface Laptop 5',
                'slug' => 'microsoft-surface-laptop-5',
                'description' => 'Elegant laptop with Alcantara keyboard deck, PixelSense touchscreen, 12th Gen Intel Core, and premium platinum finish.',
                'price' => 1499.99,
                'stock_quantity' => 16,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/microsoft-surface.png',
                'is_active' => true,
            ],
            [
                'name' => 'LG Gram 17 (2024)',
                'slug' => 'lg-gram-17-2024',
                'description' => 'Ultra-lightweight 17" laptop weighing just 2.98 lbs, with Intel 13th Gen processors, long battery life, and military-grade durability.',
                'price' => 1699.99,
                'stock_quantity' => 14,
                'low_stock_threshold' => 5,
                'image_path' => '/images/products/lg-gram.png',
                'is_active' => true,
            ],
        ];

        foreach ($laptops as $laptop) {
            Product::create(array_merge($laptop, ['category_id' => $category->id]));
        }

        $this->command->info('10 laptop products created successfully!');
    }
}
