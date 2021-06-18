<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use PhpAmqpLib\Channel\AMQPChannel;
use HeIsMehrab\PhpRabbitMq\Services\RabbitMQ\RabbitMQService;

/**
 * Class Producer.
 * Use this class to integrate with
 * RabbitMQ node.
 *
 * @package HeIsMehrab\PhpRabbitMq\Core
 */
class Producer
{
    /**
     * Keep instance of RabbitMQ.
     *
     * @var RabbitMQService|AMQPChannel $node
     */
    private $node;

    /**
     * Keep the message/task.
     *
     * @var string $message
     */
    protected $message;

    /**
     * Producer constructor.
     */
    public function __construct()
    {
        $this->node = RabbitMQService::node();
    }

    /**
     * Set the message.
     *
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Produce and message/task to Rabbit queue.
     *
     * @param string|null $queue
     * @param string|null $exchange
     * @param string|null $exchangeType
     * @param string|null $topic
     */
    public function sendToQueue(
        string $queue = null,
        string $exchange = null,
        string $exchangeType = null,
        string $topic = null
    ) {
        //
    }
}