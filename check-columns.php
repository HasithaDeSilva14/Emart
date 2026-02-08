<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$columns = DB::select('PRAGMA table_info(orders)');

echo "Orders table columns:\n";
foreach($columns as $col) {
    echo "  {$col->name} - {$col->type}\n";
}
