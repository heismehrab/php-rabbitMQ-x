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
     * Keep RabbitMQ configuration.
     *
     * @var null|array
     */
    private static $configuration = null;

    /**
     * Producer constructor.
     *
     * @param array $configFile
     */
    public function __construct(array $configFile)
    {
        static::$configuration = $configFile;

        $this->node = RabbitMQService::node($configFile);
    }

    /**
     * Get RabbitMQ configuration.
     *
     * @return array|null
     */
    public static function getConfigurations(): ?array
    {
        return static::$configuration;
    }

    /**
     * Produce messages/tasks to Rabbit queue.
     *
     * @param string $queueOrRoutingKey
     * Queue name or a routing key, depends on
     * your queue and exchange configuration.
     *
     * @param string $exchange
     *
     * @return void
     *
     * @throws Exception
     */
    public function sendToQueue(string $queueOrRoutingKey = '', string $exchange = '')
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
            ->basic_publish($message, $exchange, $queueOrRoutingKey);

        // Remove un-used data.
        unset($message);
    }
}