<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

try {
    define('LARAVEL_START', microtime(true));

    // 1. Setup writable /tmp storage
    $storagePath = '/tmp/storage';
    foreach ([
        $storagePath . '/cache',
        $storagePath . '/framework/views',
        $storagePath . '/framework/sessions',
        $storagePath . '/framework/cache/data',
        $storagePath . '/logs',
    ] as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // 2. Setup SQLite database
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

    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // 3. Force all storage and bootstrap manifest paths into writable /tmp/storage
    $app->useStoragePath($storagePath);
    $app->useBootstrapPath($storagePath);

    // 4. Capture Request & Handle Execution
    $request = Request::capture();
    $app->instance('request', $request);

    /** @var Kernel $kernel */
    $kernel = $app->make(Kernel::class);
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/html');
    echo "<h1>Vercel Execution Exception Trace</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
