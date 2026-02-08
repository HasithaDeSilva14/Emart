<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Converting Product Prices to LKR ===\n\n";

// Approximate USD to LKR conversion rate
$conversionRate = 300;

// Price mapping for realistic LKR prices
$priceUpdates = [
    // Phones
    1 => 399000,    // iPhone 15 Pro
    2 => 350000,    // Samsung Galaxy S24
    3 => 280000,    // Google Pixel 8
    
    // Laptops
    4 => 750000,    // MacBook Pro 16"
    5 => 540000,    // Dell XPS 15
    6 => 480000,    // Lenovo ThinkPad X1
    
    // Tablets
    7 => 330000,    // iPad Pro 12.9"
    8 => 240000,    // Samsung Galaxy Tab S9
    
    // Accessories
    9 => 12000,     // USB-C Fast Charger
    10 => 9000,     // Phone Case Premium
    11 => 15000,    // Wireless Charging Pad
    12 => 75000,    // AirPods Pro 2
    13 => 120000,   // Sony WH-1000XM5
    14 => 39000,    // JBL Flip 6
    15 => 120000,   // Apple Watch Series 9
    16 => 90000,    // Samsung Galaxy Watch 6
    17 => 48000,    // Fitbit Charge 6
    
    // More Laptops
    18 => 280000,   // Asus Tuf A-15
    19 => 750000,   // MacBook Pro 16" M3 Max
    20 => 570000,   // Dell XPS 15 9530
    21 => 480000,   // HP Spectre x360 14
    22 => 525000,   // Lenovo ThinkPad X1 Carbon Gen 11
    23 => 390000,   // ASUS ZenBook 14 OLED
    24 => 240000,   // Acer Swift 3 SF314
    25 => 360000,   // MSI GF63 Thin Gaming Laptop
    26 => 840000,   // Razer Blade 15 Advanced
    27 => 450000,   // Microsoft Surface Laptop 5
    28 => 510000,   // LG Gram 17 (2024)
];

$updated = 0;

foreach ($priceUpdates as $productId => $newPrice) {
    $product = DB::table('products')->where('id', $productId)->first();
    
    if ($product) {
        DB::table('products')
            ->where('id', $productId)
            ->update(['price' => $newPrice]);
        
        echo "✓ Updated: {$product->name}\n";
        echo "  Old: Rs. " . number_format($product->price, 2) . "\n";
        echo "  New: Rs. " . number_format($newPrice, 2) . "\n";
        echo "---\n";
        
        $updated++;
    }
}

echo "\n=== Summary ===\n";
echo "Products updated: $updated\n";
echo "\nAll prices have been converted to realistic Sri Lankan Rupee amounts!\n";
