<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use Exception;
use HeIsMehrab\PhpRabbitMq\Services\RabbitMQ\RabbitMQService;

/**
 * Class Consumer.
 * Use this class to integrate with
 * RabbitMQ node.
 *
 * @package HeIsMehrab\PhpRabbitMq\Core
 */
class Consumer extends BaseHandler
{
    public function __construct()
    {
        $this->node = RabbitMQService::node();
    }

    /**
     * Produce and message/task to Rabbit queue.
     *
     * @param string $queue
     * @param string $routingKey
     * @param callable $callback
     *
     * @return void
     *
     * @throws Exception
     */
    public function listen(
        string $queue = '',
        string $routingKey = '',
        callable $callback
    ) {
        // Declare Queues.
        $this->declareQueues();

        // Declare exchanges.
        $this->declareExchanges();

        // Bind queues and exchanges.
        $this->bindExchangesAndQueues();

        // Active qos for fair dispatching.
        $this->node->basic_qos(null, 1, null);

        // Consume message
        $this->node->basic_consume(
            $queue,
            '',
            false,
            false,
            false,
            false,
            $callback
        );

        while ($this->node->is_open()) {
            $this->node->wait();
        }

        // TODO. Handle memory usage and close
        // TODO. RabbitMQ connections if needed.
    }
}