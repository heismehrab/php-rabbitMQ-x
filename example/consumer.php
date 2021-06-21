<?php

use HeIsMehrab\PhpRabbitMq\Core\Consumer;

// This file is an example of working
// with this package.

$configuration = require_once __DIR__ . '/../src/Config/config.php';

$consumer = new Consumer($configuration);

$callBack = function ($message) {
    echo $message->body;
};

try {
    $consumer->listen('test_queue', '', $callBack);
} catch (Exception $e) {
}