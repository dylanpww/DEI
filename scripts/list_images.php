<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::whereNotNull('image')->get(['product_ID','name','image'])->toArray();
echo "PRODUCTS_WITH_IMAGE:\n";
echo json_encode($products, JSON_PRETTY_PRINT) . "\n";

$dir = __DIR__ . '/../storage/app/public/products';
$files = [];
if (is_dir($dir)) {
    foreach (scandir($dir) as $f) {
        if ($f === '.' || $f === '..') continue;
        $files[] = ['name' => $f, 'size' => filesize($dir . '/' . $f)];
    }
}

echo "FILES_IN_STORAGE:\n";
echo json_encode($files, JSON_PRETTY_PRINT) . "\n";
