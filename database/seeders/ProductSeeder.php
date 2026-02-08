<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Smartphones
            [
                'category' => 'Smartphones',
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system',
                'price' => 999.99,
                'stock_quantity' => 50,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Smartphones',
                'name' => 'Samsung Galaxy S24',
                'description' => 'Flagship Samsung phone with AI features and stunning display',
                'price' => 899.99,
                'stock_quantity' => 45,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Smartphones',
                'name' => 'Google Pixel 8',
                'description' => 'Pure Android experience with excellent camera',
                'price' => 699.99,
                'stock_quantity' => 8,
                'low_stock_threshold' => 10,
            ],
            
            // Laptops
            [
                'category' => 'Laptops',
                'name' => 'MacBook Pro 16"',
                'description' => 'Powerful laptop with M3 Pro chip for professionals',
                'price' => 2499.99,
                'stock_quantity' => 25,
                'low_stock_threshold' => 5,
            ],
            [
                'category' => 'Laptops',
                'name' => 'Dell XPS 15',
                'description' => 'Premium Windows laptop with stunning display',
                'price' => 1799.99,
                'stock_quantity' => 30,
                'low_stock_threshold' => 8,
            ],
            [
                'category' => 'Laptops',
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Business laptop with excellent keyboard and durability',
                'price' => 1599.99,
                'stock_quantity' => 20,
                'low_stock_threshold' => 5,
            ],
            
            // Tablets
            [
                'category' => 'Tablets',
                'name' => 'iPad Pro 12.9"',
                'description' => 'Professional tablet with M2 chip and ProMotion display',
                'price' => 1099.99,
                'stock_quantity' => 35,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Tablets',
                'name' => 'Samsung Galaxy Tab S9',
                'description' => 'Premium Android tablet with S Pen included',
                'price' => 799.99,
                'stock_quantity' => 28,
                'low_stock_threshold' => 8,
            ],
            
            // Accessories
            [
                'category' => 'Accessories',
                'name' => 'USB-C Fast Charger',
                'description' => '65W fast charging adapter with USB-C cable',
                'price' => 39.99,
                'stock_quantity' => 100,
                'low_stock_threshold' => 20,
            ],
            [
                'category' => 'Accessories',
                'name' => 'Phone Case Premium',
                'description' => 'Protective case with military-grade drop protection',
                'price' => 29.99,
                'stock_quantity' => 150,
                'low_stock_threshold' => 30,
            ],
            [
                'category' => 'Accessories',
                'name' => 'Wireless Charging Pad',
                'description' => '15W fast wireless charger for all Qi-enabled devices',
                'price' => 49.99,
                'stock_quantity' => 75,
                'low_stock_threshold' => 15,
            ],
            
            // Audio
            [
                'category' => 'Audio',
                'name' => 'AirPods Pro 2',
                'description' => 'Premium wireless earbuds with active noise cancellation',
                'price' => 249.99,
                'stock_quantity' => 60,
                'low_stock_threshold' => 15,
            ],
            [
                'category' => 'Audio',
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise cancelling headphones',
                'price' => 399.99,
                'stock_quantity' => 40,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Audio',
                'name' => 'JBL Flip 6',
                'description' => 'Portable Bluetooth speaker with powerful sound',
                'price' => 129.99,
                'stock_quantity' => 55,
                'low_stock_threshold' => 12,
            ],
            
            // Wearables
            [
                'category' => 'Wearables',
                'name' => 'Apple Watch Series 9',
                'description' => 'Advanced smartwatch with health and fitness features',
                'price' => 399.99,
                'stock_quantity' => 45,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Wearables',
                'name' => 'Samsung Galaxy Watch 6',
                'description' => 'Feature-rich smartwatch for Android users',
                'price' => 299.99,
                'stock_quantity' => 38,
                'low_stock_threshold' => 10,
            ],
            [
                'category' => 'Wearables',
                'name' => 'Fitbit Charge 6',
                'description' => 'Fitness tracker with heart rate and sleep monitoring',
                'price' => 159.99,
                'stock_quantity' => 7,
                'low_stock_threshold' => 10,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'low_stock_threshold' => $productData['low_stock_threshold'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
