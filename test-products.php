<?php

use App\Models\Product;
use App\Livewire\Products\ProductList;

// Test the component directly
$component = new ProductList();
$view = $component->render();
$products = $view->getData()['products'];

echo "Total products: " . $products->total() . PHP_EOL;
echo "Products on page: " . $products->count() . PHP_EOL;
echo "First product: " . ($products->first() ? $products->first()->name : 'None') . PHP_EOL;
