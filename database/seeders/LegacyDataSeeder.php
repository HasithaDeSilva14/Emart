<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LegacyDataSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Table: users
        DB::table('users')->truncate();
        DB::table('users')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'name' => 'Admin User',
    'email' => 'admin@emart.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$j.zr9tY9JpcyummPX8x9QeuDCmcsfu8oBf0i8w0sTIQJMzEBaw93K',
    'remember_token' => 'foRH2d6ZkZrPqyfHPbe62tSPuQiTxRA4ofRrLwMCnirjyeyV18vbPNsW9SwX',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
    'role' => 'admin',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 1,
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$aZiK2R4/5trKDS1IplEHFu4AN3B7G90/FntDH/DSvawu79qtXIprW',
    'remember_token' => NULL,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'Jane Smith',
    'email' => 'jane@example.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$6T8IGY/xUwNDinOcD6/XmeS/xCtPwcQIXSN80ryPmeiZryTDiA.8m',
    'remember_token' => NULL,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'Chamodth De Silva',
    'email' => 'jeromedesilva44@gmail.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$CNkp7GLxBPSnP9PqCILZ8OHWNHr1MPwwaMB34vOmlEuxIbbm1Zl/y',
    'remember_token' => NULL,
    'created_at' => '2026-01-06 04:51:53',
    'updated_at' => '2026-01-06 04:51:53',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'chama',
    'email' => 'desilvahasitha14@gmail.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$.Tg/RvQJbQfKH/PSb8ZFdOpyCxLnDC7kU9w1EVyp4lTE3SU4SOR9m',
    'remember_token' => NULL,
    'created_at' => '2026-01-06 15:08:15',
    'updated_at' => '2026-01-06 15:08:15',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  5 => 
  array (
    'id' => 6,
    'name' => 'Test User',
    'email' => 'test@example.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$M1FKrNbYTO7EKkQ3GEVuBe5dIvQxH6gcIX66XINEp3JpLAxB3eiWS',
    'remember_token' => NULL,
    'created_at' => '2026-01-06 20:03:16',
    'updated_at' => '2026-01-06 20:03:16',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  6 => 
  array (
    'id' => 7,
    'name' => 'Admin Test',
    'email' => 'admin_test@example.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$cZgB7iHWVt1xAKggrHacUOiHU6DRnRfiA/BJobHSMpEUcfPGzeaaO',
    'remember_token' => NULL,
    'created_at' => '2026-01-08 06:15:56',
    'updated_at' => '2026-01-08 06:15:56',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
  7 => 
  array (
    'id' => 8,
    'name' => 'Unique User',
    'email' => 'unique_user@example.com',
    'email_verified_at' => NULL,
    'password' => '$2y$12$Pz0hxAXmVzhG0Q3wSei.meqxZGO/kQ/JyL6t7kZVov9/22pLnkXVa',
    'remember_token' => NULL,
    'created_at' => '2026-01-28 11:21:18',
    'updated_at' => '2026-01-28 11:21:18',
    'role' => 'customer',
    'two_factor_secret' => NULL,
    'two_factor_recovery_codes' => NULL,
    'two_factor_confirmed_at' => NULL,
    'is_admin' => 0,
  ),
)
        );

        // Table: categories
        DB::table('categories')->truncate();
        DB::table('categories')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'name' => 'Smartphones',
    'slug' => 'smartphones',
    'description' => 'Latest smartphones and mobile devices',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'Laptops',
    'slug' => 'laptops',
    'description' => 'High-performance laptops and notebooks',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'Tablets',
    'slug' => 'tablets',
    'description' => 'Tablets and iPad devices',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'Accessories',
    'slug' => 'accessories',
    'description' => 'Phone cases, chargers, and other accessories',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'Audio',
    'slug' => 'audio',
    'description' => 'Headphones, earbuds, and speakers',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  5 => 
  array (
    'id' => 6,
    'name' => 'Wearables',
    'slug' => 'wearables',
    'description' => 'Smartwatches and fitness trackers',
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
)
        );

        // Table: products
        DB::table('products')->truncate();
        DB::table('products')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'category_id' => 1,
    'name' => 'iPhone 15 Pro',
    'slug' => 'iphone-15-pro',
    'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system',
    'price' => 399000,
    'stock_quantity' => 50,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/iphone-15-pro.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  1 => 
  array (
    'id' => 2,
    'category_id' => 1,
    'name' => 'Samsung Galaxy S24',
    'slug' => 'samsung-galaxy-s24',
    'description' => 'Flagship Samsung phone with AI features and stunning display',
    'price' => 350000,
    'stock_quantity' => 45,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/samsung-galaxy-s24.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  2 => 
  array (
    'id' => 3,
    'category_id' => 1,
    'name' => 'Google Pixel 8',
    'slug' => 'google-pixel-8',
    'description' => 'Pure Android experience with excellent camera',
    'price' => 280000,
    'stock_quantity' => 8,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/google-pixel-8.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  3 => 
  array (
    'id' => 4,
    'category_id' => 2,
    'name' => 'MacBook Pro 16"',
    'slug' => 'macbook-pro-16',
    'description' => 'Powerful laptop with M3 Pro chip for professionals',
    'price' => 750000,
    'stock_quantity' => 25,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/macbook-pro-16.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  4 => 
  array (
    'id' => 5,
    'category_id' => 2,
    'name' => 'Dell XPS 15',
    'slug' => 'dell-xps-15',
    'description' => 'Premium Windows laptop with stunning display',
    'price' => 540000,
    'stock_quantity' => 30,
    'low_stock_threshold' => 8,
    'image_path' => '/images/products/dell-xps-15.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  5 => 
  array (
    'id' => 6,
    'category_id' => 2,
    'name' => 'Lenovo ThinkPad X1',
    'slug' => 'lenovo-thinkpad-x1',
    'description' => 'Business laptop with excellent keyboard and durability',
    'price' => 480000,
    'stock_quantity' => 20,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/lenovo-thinkpad-x1.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  6 => 
  array (
    'id' => 7,
    'category_id' => 3,
    'name' => 'iPad Pro 12.9"',
    'slug' => 'ipad-pro-129',
    'description' => 'Professional tablet with M2 chip and ProMotion display',
    'price' => 330000,
    'stock_quantity' => 35,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/ipad-pro-129.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  7 => 
  array (
    'id' => 8,
    'category_id' => 3,
    'name' => 'Samsung Galaxy Tab S9',
    'slug' => 'samsung-galaxy-tab-s9',
    'description' => 'Premium Android tablet with S Pen included',
    'price' => 240000,
    'stock_quantity' => 28,
    'low_stock_threshold' => 8,
    'image_path' => '/images/products/samsung-tab-s9.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  8 => 
  array (
    'id' => 9,
    'category_id' => 4,
    'name' => 'USB-C Fast Charger',
    'slug' => 'usb-c-fast-charger',
    'description' => '65W fast charging adapter with USB-C cable',
    'price' => 12000,
    'stock_quantity' => 100,
    'low_stock_threshold' => 20,
    'image_path' => '/images/products/usbc-charger.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  9 => 
  array (
    'id' => 10,
    'category_id' => 4,
    'name' => 'Phone Case Premium',
    'slug' => 'phone-case-premium',
    'description' => 'Protective case with military-grade drop protection',
    'price' => 9000,
    'stock_quantity' => 150,
    'low_stock_threshold' => 30,
    'image_path' => '/images/products/phone-case.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  10 => 
  array (
    'id' => 11,
    'category_id' => 4,
    'name' => 'Wireless Charging Pad',
    'slug' => 'wireless-charging-pad',
    'description' => '15W fast wireless charger for all Qi-enabled devices',
    'price' => 15000,
    'stock_quantity' => 75,
    'low_stock_threshold' => 15,
    'image_path' => '/images/products/wireless-charger.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  11 => 
  array (
    'id' => 12,
    'category_id' => 5,
    'name' => 'AirPods Pro 2',
    'slug' => 'airpods-pro-2',
    'description' => 'Premium wireless earbuds with active noise cancellation',
    'price' => 75000,
    'stock_quantity' => 60,
    'low_stock_threshold' => 15,
    'image_path' => '/images/products/airpods-pro-2.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  12 => 
  array (
    'id' => 13,
    'category_id' => 5,
    'name' => 'Sony WH-1000XM5',
    'slug' => 'sony-wh-1000xm5',
    'description' => 'Industry-leading noise cancelling headphones',
    'price' => 120000,
    'stock_quantity' => 40,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/sony-wh1000xm5.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  13 => 
  array (
    'id' => 14,
    'category_id' => 5,
    'name' => 'JBL Flip 6',
    'slug' => 'jbl-flip-6',
    'description' => 'Portable Bluetooth speaker with powerful sound',
    'price' => 39000,
    'stock_quantity' => 55,
    'low_stock_threshold' => 12,
    'image_path' => '/images/products/jbl-flip-6.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  14 => 
  array (
    'id' => 15,
    'category_id' => 6,
    'name' => 'Apple Watch Series 9',
    'slug' => 'apple-watch-series-9',
    'description' => 'Advanced smartwatch with health and fitness features',
    'price' => 120000,
    'stock_quantity' => 45,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/apple-watch-9.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  15 => 
  array (
    'id' => 16,
    'category_id' => 6,
    'name' => 'Samsung Galaxy Watch 6',
    'slug' => 'samsung-galaxy-watch-6',
    'description' => 'Feature-rich smartwatch for Android users',
    'price' => 90000,
    'stock_quantity' => 38,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/samsung-watch-6.png',
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  16 => 
  array (
    'id' => 17,
    'category_id' => 6,
    'name' => 'Fitbit Charge 6',
    'slug' => 'fitbit-charge-6',
    'description' => 'Fitness tracker with heart rate and sleep monitoring',
    'price' => 48000,
    'stock_quantity' => 7,
    'low_stock_threshold' => 10,
    'image_path' => NULL,
    'is_active' => 1,
    'created_at' => '2025-12-23 06:29:30',
    'updated_at' => '2025-12-23 06:29:30',
  ),
  17 => 
  array (
    'id' => 18,
    'category_id' => 2,
    'name' => 'Asus Tuf A-15',
    'slug' => 'asus-tuf-A-15',
    'description' => 'asus-tuf-A-15',
    'price' => 280000,
    'stock_quantity' => 13,
    'low_stock_threshold' => 10,
    'image_path' => '/storage/products/WJBYEsoTdW68RSf1WaSlP7UzwmpCKHXHABbzFCnG.jpg',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:15:51',
    'updated_at' => '2026-01-30 19:43:37',
  ),
  18 => 
  array (
    'id' => 19,
    'category_id' => 2,
    'name' => 'MacBook Pro 16" M3 Max',
    'slug' => 'macbook-pro-16-m3-max',
    'description' => 'The most powerful MacBook Pro ever with M3 Max chip, stunning Liquid Retina XDR display, and up to 22 hours of battery life. Perfect for professionals.',
    'price' => 750000,
    'stock_quantity' => 15,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/macbook-pro.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  19 => 
  array (
    'id' => 20,
    'category_id' => 2,
    'name' => 'Dell XPS 15 9530',
    'slug' => 'dell-xps-15-9530',
    'description' => 'Premium laptop with InfinityEdge display, 13th Gen Intel Core i7, NVIDIA RTX 4050, and stunning platinum silver finish.',
    'price' => 570000,
    'stock_quantity' => 20,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/dell-xps.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  20 => 
  array (
    'id' => 21,
    'category_id' => 2,
    'name' => 'HP Spectre x360 14',
    'slug' => 'hp-spectre-x360-14',
    'description' => '2-in-1 convertible laptop with 360-degree hinge, Intel Evo platform, stunning OLED display, and premium gem-cut design.',
    'price' => 480000,
    'stock_quantity' => 18,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/hp-spectre.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  21 => 
  array (
    'id' => 22,
    'category_id' => 2,
    'name' => 'Lenovo ThinkPad X1 Carbon Gen 11',
    'slug' => 'lenovo-thinkpad-x1-carbon-gen-11',
    'description' => 'Business ultrabook with legendary ThinkPad keyboard, military-grade durability, 13th Gen Intel processors, and all-day battery life.',
    'price' => 525000,
    'stock_quantity' => 25,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/lenovo-thinkpad.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  22 => 
  array (
    'id' => 23,
    'category_id' => 2,
    'name' => 'ASUS ZenBook 14 OLED',
    'slug' => 'asus-zenbook-14-oled',
    'description' => 'Ultra-portable laptop with stunning OLED display, NumberPad 2.0, Intel Core i7, and premium royal blue finish.',
    'price' => 390000,
    'stock_quantity' => 19,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/asus-zenbook.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 19:43:37',
  ),
  23 => 
  array (
    'id' => 24,
    'category_id' => 2,
    'name' => 'Acer Swift 3 SF314',
    'slug' => 'acer-swift-3-sf314',
    'description' => 'Lightweight and portable laptop with AMD Ryzen 7, full HD display, and all-day battery life. Perfect for students and professionals.',
    'price' => 240000,
    'stock_quantity' => 28,
    'low_stock_threshold' => 10,
    'image_path' => '/images/products/acer-swift.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-02-01 09:08:04',
  ),
  24 => 
  array (
    'id' => 25,
    'category_id' => 2,
    'name' => 'MSI GF63 Thin Gaming Laptop',
    'slug' => 'msi-gf63-thin-gaming',
    'description' => 'Affordable gaming laptop with NVIDIA RTX 4050, 144Hz display, RGB keyboard, and powerful cooling system.',
    'price' => 360000,
    'stock_quantity' => 12,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/msi-gaming.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  25 => 
  array (
    'id' => 26,
    'category_id' => 2,
    'name' => 'Razer Blade 15 Advanced',
    'slug' => 'razer-blade-15-advanced',
    'description' => 'Premium gaming laptop with RTX 4070, QHD 240Hz display, per-key RGB keyboard, and CNC aluminum unibody.',
    'price' => 840000,
    'stock_quantity' => 8,
    'low_stock_threshold' => 3,
    'image_path' => '/images/products/razer-blade.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  26 => 
  array (
    'id' => 27,
    'category_id' => 2,
    'name' => 'Microsoft Surface Laptop 5',
    'slug' => 'microsoft-surface-laptop-5',
    'description' => 'Elegant laptop with Alcantara keyboard deck, PixelSense touchscreen, 12th Gen Intel Core, and premium platinum finish.',
    'price' => 450000,
    'stock_quantity' => 16,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/microsoft-surface.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
  27 => 
  array (
    'id' => 28,
    'category_id' => 2,
    'name' => 'LG Gram 17 (2024)',
    'slug' => 'lg-gram-17-2024',
    'description' => 'Ultra-lightweight 17" laptop weighing just 2.98 lbs, with Intel 13th Gen processors, long battery life, and military-grade durability.',
    'price' => 510000,
    'stock_quantity' => 14,
    'low_stock_threshold' => 5,
    'image_path' => '/images/products/lg-gram.png',
    'is_active' => 1,
    'created_at' => '2026-01-30 10:22:00',
    'updated_at' => '2026-01-30 10:22:00',
  ),
)
        );

        // Table: carts
        DB::table('carts')->truncate();
        DB::table('carts')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'user_id' => 1,
    'created_at' => '2025-12-23 06:37:18',
    'updated_at' => '2025-12-23 06:37:18',
  ),
)
        );

        // Table: cart_items
        DB::table('cart_items')->truncate();
        DB::table('cart_items')->insert(
array (
  0 => 
  array (
    'id' => 3,
    'cart_id' => 1,
    'product_id' => 24,
    'quantity' => 1,
    'created_at' => '2026-01-30 10:31:11',
    'updated_at' => '2026-01-30 10:31:11',
  ),
)
        );

        // Table: orders
        DB::table('orders')->truncate();
        DB::table('orders')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'user_id' => 4,
    'total_amount' => 1439.989,
    'status' => 'shipped',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:02:33',
    'updated_at' => '2026-02-01 09:31:55',
    'payment_method' => 'stripe',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 1439.989,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  1 => 
  array (
    'id' => 2,
    'user_id' => 4,
    'total_amount' => 1439.989,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:07:13',
    'updated_at' => '2026-01-30 11:07:13',
    'payment_method' => 'cash_on_delivery',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 1439.989,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  2 => 
  array (
    'id' => 3,
    'user_id' => 4,
    'total_amount' => 2869.978,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:07:44',
    'updated_at' => '2026-01-30 11:07:44',
    'payment_method' => 'stripe',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 2869.978,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  3 => 
  array (
    'id' => 4,
    'user_id' => 4,
    'total_amount' => 2869.978,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:12:27',
    'updated_at' => '2026-01-30 11:12:27',
    'payment_method' => 'stripe',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 2869.978,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  4 => 
  array (
    'id' => 5,
    'user_id' => 4,
    'total_amount' => 2869.978,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:12:49',
    'updated_at' => '2026-01-30 11:12:49',
    'payment_method' => 'stripe',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 2869.978,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  5 => 
  array (
    'id' => 6,
    'user_id' => 4,
    'total_amount' => 2869.978,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 11:25:57',
    'updated_at' => '2026-01-30 11:25:57',
    'payment_method' => 'stripe',
    'payment_status' => 'pending',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 2869.978,
    'paid_at' => NULL,
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  6 => 
  array (
    'id' => 7,
    'user_id' => 4,
    'total_amount' => 310869.978,
    'status' => 'pending',
    'shipping_address' => '46/8 St.benedict\'s Street col-13, Colombo, western 01300',
    'phone' => '0773323826',
    'created_at' => '2026-01-30 19:43:37',
    'updated_at' => '2026-01-30 19:43:37',
    'payment_method' => 'card',
    'payment_status' => 'paid',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 310869.978,
    'paid_at' => '2026-01-30 19:43:37',
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
  7 => 
  array (
    'id' => 8,
    'user_id' => 4,
    'total_amount' => 1769.978,
    'status' => 'pending',
    'shipping_address' => '46/8 st benedicts street, colombo, western 01300',
    'phone' => '0773323825',
    'created_at' => '2026-02-01 09:08:04',
    'updated_at' => '2026-02-01 09:08:04',
    'payment_method' => 'card',
    'payment_status' => 'paid',
    'stripe_payment_intent_id' => NULL,
    'stripe_checkout_session_id' => NULL,
    'payment_amount' => 1769.978,
    'paid_at' => '2026-02-01 09:08:04',
    'sandbox_transaction_id' => NULL,
    'tracking_number' => NULL,
    'shipped_at' => NULL,
    'delivered_at' => NULL,
  ),
)
        );

        // Table: wishlists
        DB::table('wishlists')->truncate();
        DB::table('wishlists')->insert(
array (
  0 => 
  array (
    'id' => 1,
    'user_id' => 4,
    'product_id' => 24,
    'created_at' => '2026-01-31 21:49:54',
    'updated_at' => '2026-01-31 21:49:54',
  ),
)
        );

        Schema::enableForeignKeyConstraints();
    }
}
