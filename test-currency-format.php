<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Testing Currency Formatting ===\n\n";

// Test various amounts
$amounts = [
    1234.56,
    12345.67,
    123456.78,
    1234567.89,
    150000.00,
    2500.50,
];

foreach ($amounts as $amount) {
    echo "Amount: $amount\n";
    echo "Formatted: " . format_currency($amount) . "\n";
    echo "---\n";
}
