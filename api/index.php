<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

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

// 3. Populate $_ENV and $_SERVER for Vercel serverless environment
$envVars = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'APP_KEY' => 'base64:k+GJlpYlO1Urpj9xPVTGF6PA/yvTLqQNnv53LnB3o64=',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $dbPath,
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'CACHE_DRIVER' => 'array',
    'LOG_CHANNEL' => 'stderr',
    'VIEW_COMPILED_PATH' => $storagePath . '/framework/views',
];

foreach ($envVars as $key => $val) {
    putenv("{$key}={$val}");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

require __DIR__ . '/../vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Force all storage and bootstrap manifest paths into writable /tmp/storage
$app->useStoragePath($storagePath);
$app->useBootstrapPath($storagePath);

// 5. Capture Request & Bind to app
$request = Request::capture();
$app->instance('request', $request);

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// 6. Set explicit fallback configs before handling request
config([
    'session.driver' => 'cookie',
    'session.lifetime' => 120,
    'session.expire_on_close' => false,
    'session.encrypt' => false,
    'session.path' => '/',
    'session.domain' => null,
    'session.secure' => true,
    'session.http_only' => true,
    'session.same_site' => 'lax',
    'cache.default' => 'array',
    'logging.default' => 'stderr',
    'database.default' => 'sqlite',
    'database.connections.sqlite.database' => $dbPath,
]);

// 7. Handle Request
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
