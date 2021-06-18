<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use PhpAmqpLib\Channel\AMQPChannel;
use HeIsMehrab\PhpRabbitMq\Services\RabbitMQ\RabbitMQService;

/**
 * Class Consumer.
 * Use this class to integrate with
 * RabbitMQ node.
 *
 * @package HeIsMehrab\PhpRabbitMq\Core
 */
class Consumer
{
    /**
     * Keep instance of RabbitMQ.
     *
     * @var RabbitMQService|AMQPChannel $node
     */
    private $node;

    public function __construct()
    {
        $this->node = RabbitMQService::node();
    }

    /**
     * Produce and message/task to Rabbit queue.
     *
     * @param string|null $queue
     * @param string|null $exchange
     * @param string|null $exchangeType
     * @param string|null $topic
     * @param callable $callBack
     */
    public function listen(
        string $queue = null,
        string $exchange = null,
        string $exchangeType = null,
        string $topic = null,
        callable $callBack
    ) {
        //
    }
}