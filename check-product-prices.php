<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Current Product Prices ===\n\n";

$products = DB::table('products')
    ->select('id', 'name', 'price', 'category_id')
    ->orderBy('id')
    ->get();

foreach ($products as $product) {
    echo "ID: {$product->id}\n";
    echo "Name: {$product->name}\n";
    echo "Current Price: {$product->price}\n";
    echo "Formatted: " . format_currency($product->price) . "\n";
    echo "---\n";
}

echo "\nTotal products: " . count($products) . "\n";
