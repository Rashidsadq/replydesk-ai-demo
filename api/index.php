<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

try {
    define('LARAVEL_START', microtime(true));

    // 1. Prepare writable /tmp storage directory structure for Vercel Lambda
    $storagePath = '/tmp/storage';
    $directories = [
        $storagePath . '/framework/views',
        $storagePath . '/framework/sessions',
        $storagePath . '/framework/cache/data',
        $storagePath . '/logs',
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // 2. Set environment variables
    putenv('APP_ENV=production');
    putenv('APP_DEBUG=true');
    putenv('APP_KEY=base64:k+GJlpYlO1Urpj9xPVTGF6PA/yvTLqQNnv53LnB3o64=');
    putenv('SESSION_DRIVER=cookie');
    putenv('CACHE_STORE=array');
    putenv('LOG_CHANNEL=stderr');
    putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');

    // 3. Load Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // 4. Bootstrap Application
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // 5. Force storage path to /tmp/storage
    $app->useStoragePath($storagePath);

    // 6. Handle Request
    $kernel = $app->make(Kernel::class);
    $request = Request::capture();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/html');
    echo "<h1>Vercel PHP Execution Error Trace</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
