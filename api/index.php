<?php

use Illuminate\Http\Request;

try {
    define('LARAVEL_START', microtime(true));

    // Clear stale bootstrap cache files if present
    @unlink(__DIR__ . '/../bootstrap/cache/packages.php');
    @unlink(__DIR__ . '/../bootstrap/cache/services.php');
    @unlink(__DIR__ . '/../bootstrap/cache/config.php');
    @unlink(__DIR__ . '/../bootstrap/cache/routes-v7.php');

    // Setup writable /tmp storage
    $storagePath = '/tmp/storage';
    foreach ([
        $storagePath . '/framework/views',
        $storagePath . '/framework/sessions',
        $storagePath . '/framework/cache/data',
        $storagePath . '/logs',
    ] as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // Setup SQLite database
    $dbPath = '/tmp/database.sqlite';
    if (!file_exists($dbPath) && file_exists(__DIR__ . '/../database/database.sqlite')) {
        @copy(__DIR__ . '/../database/database.sqlite', $dbPath);
    } elseif (!file_exists($dbPath)) {
        @touch($dbPath);
    }

    putenv('APP_ENV=production');
    putenv('APP_DEBUG=true');
    putenv('APP_KEY=base64:k+GJlpYlO1Urpj9xPVTGF6PA/yvTLqQNnv53LnB3o64=');
    putenv('DB_CONNECTION=sqlite');
    putenv('DB_DATABASE=' . $dbPath);
    putenv('SESSION_DRIVER=cookie');
    putenv('CACHE_STORE=array');
    putenv('LOG_CHANNEL=stderr');
    putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');

    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->useStoragePath($storagePath);

    // Register essential foundation service providers
    $app->register(new \Illuminate\Filesystem\FilesystemServiceProvider($app));
    $app->register(new \Illuminate\View\ViewServiceProvider($app));
    $app->register(new \Illuminate\Session\SessionServiceProvider($app));

    if (class_exists(\Livewire\LivewireServiceProvider::class)) {
        $app->register(new \Livewire\LivewireServiceProvider($app));
    }

    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/html');
    echo "<h1>Vercel Execution Exception Trace</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
