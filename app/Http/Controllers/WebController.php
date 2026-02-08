<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

/**
 * WebController
 * 
 * Handles public-facing pages that don't use Livewire components.
 * Currently only serves the home page.
 */
class WebController extends Controller
{
    /**
     * Display the home page with featured products and categories
     */
    public function home()
    {
        // Get featured products (most ordered products)
        $featuredProducts = Product::where('is_active', true)
            ->withSum('orderItems as total_ordered', 'quantity')
            ->orderByDesc('total_ordered')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                // Ensure total_ordered is 0 if null (standard behavior)
                $product->total_ordered = $product->total_ordered ?? 0;
                return $product;
            });

        // Get all categories with product count
        $categories = Category::withCount('products')
            ->get()
            ->filter(function($category) {
                return $category->products_count > 0;
            });

        return view('home', compact('featuredProducts', 'categories'));
    }
}
