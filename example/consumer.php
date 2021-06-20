<?php

use HeIsMehrab\PhpRabbitMq\Core\Consumer;

// This file is an example of working
// with this package.

$consumer = new Consumer();

$callBack = function ($message) {
    echo $message->body;
};

try {
    $consumer->listen('test_queue', '', $callBack);
} catch (Exception $e) {
}