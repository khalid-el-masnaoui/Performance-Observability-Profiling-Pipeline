<?php

require_once __DIR__ . '/vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;

// ---------------------------
// Redis (for SPX trigger)
// ---------------------------
$redis = new Redis();
$redis->connect('redis');

// ---------------------------
// Normalize route (CRITICAL)
// ---------------------------
function normalize_route($uri)
{
    $path = parse_url($uri, PHP_URL_PATH);

    // Replace IDs (numbers) → :id
    $path = preg_replace('#/\\d+#', '/:id', $path);

    // Replace UUIDs → :uuid
    $path = preg_replace(
        '#[0-9a-fA-F-]{36}#',
        ':uuid',
        $path
    );

    return $path ?: '/';
}

$route = normalize_route($_SERVER['REQUEST_URI']);

// ---------------------------
// Prometheus Metrics
// ---------------------------
$registry = new CollectorRegistry(new APC());

$histogram = $registry->getOrRegisterHistogram(
    'app',
    'request_duration_seconds',
    'Request duration',
    ['method', 'route', 'status'],
    [0.01, 0.05, 0.1, 0.3, 0.5, 1, 2, 5, 8, 10, 15, 20]
);
