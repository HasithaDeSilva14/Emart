<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Profile Page Functionality Test ===\n\n";

// Test 1: Check if user exists
$user = \App\Models\User::first();
if (!$user) {
    echo "❌ No users found in database\n";
    exit(1);
}

echo "✓ User found: {$user->name} ({$user->email})\n\n";

// Test 2: Check routes
echo "Checking routes...\n";
$routes = Route::getRoutes();
$profileRoutes = [];
foreach ($routes as $route) {
    $name = $route->getName();
    if ($name && str_contains($name, 'profile')) {
        $profileRoutes[] = $name . ' => ' . $route->uri();
    }
}

if (empty($profileRoutes)) {
    echo "⚠ No profile routes found\n";
} else {
    foreach ($profileRoutes as $route) {
        echo "✓ $route\n";
    }
}

echo "\n";

// Test 3: Check if Jetstream is installed
if (class_exists('\Laravel\Jetstream\Jetstream')) {
    echo "✓ Jetstream is installed\n";
} else {
    echo "⚠ Jetstream not found\n";
}

// Test 4: Check profile photo storage
$photoPath = storage_path('app/public/profile-photos');
if (file_exists($photoPath)) {
    echo "✓ Profile photos directory exists\n";
} else {
    echo "⚠ Profile photos directory not found\n";
}

echo "\n=== Summary ===\n";
echo "Profile page should be accessible at: /user/profile\n";
echo "Make sure to run: php artisan storage:link (if not already done)\n";
