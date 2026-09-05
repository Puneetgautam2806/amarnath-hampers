<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-extract vendor.zip on shared hosting if vendor/autoload.php is missing
if (!file_exists(__DIR__ . '/../vendor/autoload.php') && file_exists(__DIR__ . '/../vendor.zip')) {
    $zip = new ZipArchive;
    if ($zip->open(__DIR__ . '/../vendor.zip') === TRUE) {
        $zip->extractTo(__DIR__ . '/../');
        $zip->close();
    }
}

// Clear any stale local dev bootstrap caches (prevents BoostServiceProvider not found)
$staleCaches = [
    __DIR__ . '/../bootstrap/cache/packages.php',
    __DIR__ . '/../bootstrap/cache/services.php',
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes-v7.php',
];
foreach ($staleCaches as $cacheFile) {
    if (file_exists($cacheFile)) {
        @unlink($cacheFile);
    }
}

// Ensure essential storage framework folders exist on shared hosting
$storageFolders = [
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../storage/framework/cache/data',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../bootstrap/cache',
];
foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        @mkdir($folder, 0777, true);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    die("<h1>Deployment in progress or vendor files extracting. Please refresh in a moment...</h1>");
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
