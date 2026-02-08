<!DOCTYPE html>
<html>
<head>
    <title>Test Products</title>
</head>
<body>
    <h1>Testing Product Display</h1>
    <?php
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    $products = App\Models\Product::active()->take(5)->get();
    echo "<p>Found " . $products->count() . " products</p>";
    foreach($products as $product) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<h3>" . $product->name . "</h3>";
        echo "<p>Price: $" . $product->price . "</p>";
        echo "<p>Stock: " . $product->stock_quantity . "</p>";
        echo "</div>";
    }
    ?>
</body>
</html>
