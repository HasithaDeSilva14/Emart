<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

echo "=== Testing Bootstrap ===\n\n";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✓ Bootstrap successful!\n";
    echo "✓ Environment: " . app()->environment() . "\n";
    echo "✓ Config loaded: " . (config('app.name') ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "✗ Bootstrap failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
