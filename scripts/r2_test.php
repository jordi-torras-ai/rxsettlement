<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$disk = Illuminate\Support\Facades\Storage::disk('r2');
$path = 'documents/r2-smoke-test.txt';

try {
    $put = $disk->put($path, 'ok ' . date('c'));
    echo 'put:' . ($put ? 'true' : 'false') . PHP_EOL;
} catch (Throwable $e) {
    echo 'put error: ' . $e->getMessage() . PHP_EOL;
    if ($e->getPrevious()) {
        echo 'previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
    }
}

try {
    $exists = $disk->exists($path);
    echo 'exists:' . ($exists ? 'yes' : 'no') . PHP_EOL;
} catch (Throwable $e) {
    echo 'exists error: ' . $e->getMessage() . PHP_EOL;
    if ($e->getPrevious()) {
        echo 'previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
    }
}

try {
    $size = $disk->size($path);
    echo 'size:' . $size . PHP_EOL;
} catch (Throwable $e) {
    echo 'size error: ' . $e->getMessage() . PHP_EOL;
    if ($e->getPrevious()) {
        echo 'previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
    }
}
