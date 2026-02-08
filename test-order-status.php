<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Testing Order Status Update ===\n\n";

// Get first order
$order = \App\Models\Order::first();

if (!$order) {
    echo "No orders found in database\n";
    exit;
}

echo "Order ID: {$order->id}\n";
echo "Current Status: {$order->status}\n\n";

// Try to update status
echo "Attempting to update status to 'processing'...\n";
$order->status = 'processing';
$saved = $order->save();

echo "Save result: " . ($saved ? 'SUCCESS' : 'FAILED') . "\n";

// Refresh from database
$order->refresh();
echo "Status after refresh: {$order->status}\n\n";

// Try different status
echo "Attempting to update status to 'shipped'...\n";
$order->status = 'shipped';
$saved = $order->save();

echo "Save result: " . ($saved ? 'SUCCESS' : 'FAILED') . "\n";

// Refresh from database
$order->refresh();
echo "Status after refresh: {$order->status}\n\n";

// Check database directly
$dbStatus = \DB::table('orders')->where('id', $order->id)->value('status');
echo "Direct DB query status: {$dbStatus}\n";
