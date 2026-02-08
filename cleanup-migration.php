<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Cleaning up failed migration...\n";
DB::statement('DROP TABLE IF EXISTS orders_new');
echo "Dropped orders_new table (if existed)\n";

echo "\nNow run: php artisan migrate\n";
