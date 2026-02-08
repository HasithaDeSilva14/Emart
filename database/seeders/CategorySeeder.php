<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Smartphones',
                'description' => 'Latest smartphones and mobile devices',
            ],
            [
                'name' => 'Laptops',
                'description' => 'High-performance laptops and notebooks',
            ],
            [
                'name' => 'Tablets',
                'description' => 'Tablets and iPad devices',
            ],
            [
                'name' => 'Accessories',
                'description' => 'Phone cases, chargers, and other accessories',
            ],
            [
                'name' => 'Audio',
                'description' => 'Headphones, earbuds, and speakers',
            ],
            [
                'name' => 'Wearables',
                'description' => 'Smartwatches and fitness trackers',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
