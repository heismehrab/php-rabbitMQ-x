<?php

use HeIsMehrab\PhpRabbitMq\Core\Producer;

// This file is an example of working
// with this package.

$producer = new Producer();

$producer->setDefaultExchange('');

$producer->setMessage(json_encode([
    'success' => true,
    'time' => time()
]));

try {
    $producer->sendToQueue('test_queue');
} catch (Exception $e) {
    echo $e->getMessage();
}
