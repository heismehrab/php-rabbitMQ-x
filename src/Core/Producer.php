<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use HeIsMehrab\PhpRabbitMq\Services\RabbitMQ\RabbitMQService;

/**
 * Class Producer.
 * Use this class to integrate with
 * RabbitMQ node.
 *
 * @package HeIsMehrab\PhpRabbitMq\Core
 */
class Producer extends BaseHandler
{

    /**
     * Producer constructor.
     */
    public function __construct()
    {
        $this->node = RabbitMQService::node();
    }

    /**
     * Produce messages/tasks to Rabbit queue.
     *
     * @param string $queue
     * Queue name or a routing key, depends on
     * your queue and exchange configuration.
     *
     * @return void
     *
     * @throws Exception
     */
    public function sendToQueue(string $queue = '')
    {
        // Declare Queues.
        $this->declareQueues();

        // Declare exchanges.
        $this->declareExchanges();

        // Format message with
        // active acknowledgement.
        $message = new AMQPMessage(
            $this->message,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $this->node
            ->basic_publish($message, $this->defaultExchange, $queue);

        // Remove un-used data.
        unset($message);
    }
}