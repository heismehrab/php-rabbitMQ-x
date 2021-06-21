<?php

use HeIsMehrab\PhpRabbitMq\Core\Producer;

// This file is an example of working
// with this package.

$configuration = require_once __DIR__ . '/../src/Config/config.php';

$producer = new Producer($configuration);

$producer->setMessage(json_encode([
    'success' => true,
    'time' => time()
]));

try {
    $producer->sendToQueue('test_queue', 'log');
} catch (Exception $e) {
    echo $e->getMessage();
}
