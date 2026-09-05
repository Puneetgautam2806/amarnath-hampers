<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Diagnostics Report</h2>";
echo "<b>PHP Version:</b> " . PHP_VERSION . "<br>";

$vendorAutoload = __DIR__ . '/../vendor/autoload.php';
echo "<b>Vendor autoload.php exists:</b> " . (file_exists($vendorAutoload) ? "<span style='color:green;'>YES</span>" : "<span style='color:red;'>NO (Missing!)</span>") . "<br>";

$envFile = __DIR__ . '/../.env';
echo "<b>.env file exists:</b> " . (file_exists($envFile) ? "<span style='color:green;'>YES</span>" : "<span style='color:red;'>NO (Missing!)</span>") . "<br>";

if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    echo "<b>.env File size:</b> " . strlen($envContent) . " bytes<br>";
}

// Test loading bootstrap
echo "<b>Testing bootstrap/app.php:</b> ";
try {
    if (file_exists($vendorAutoload)) {
        require_once $vendorAutoload;
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "<span style='color:green;'>SUCCESS (Laravel Loaded!)</span><br>";
    } else {
        echo "<span style='color:red;'>SKIPPED (vendor missing)</span><br>";
    }
} catch (Throwable $e) {
    echo "<span style='color:red;'>FAILED: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
