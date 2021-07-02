<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use Exception, ErrorException;

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
    /**
     * Keep RabbitMQ configuration.
     *
     * @var null|array
     */
    private static $configuration = null;

    /**
     * Consumer constructor.
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
     * @return array
     */
    public static function getConfigurations(): array
    {
        return static::$configuration;
    }

    /**
     * Listen and consume messages/tasks from Rabbitmq.
     *
     * @param string $queue
     * Specifies the queue which consumer
     * should listen to.
     *
     * @param callable $callback
     * The callable that consumer runs
     * after getting a new message.
     *
     * @return void
     *
     * @throws ErrorException|Exception
     */
    public function listen(string $queue = '', callable $callback)
    {
        // Declare Queues.
        $this->declareQueues();

        // Declare exchanges.
        $this->declareExchanges();

        // Bind queues and exchanges.
        $this->bindExchangesAndQueues();

        // Active qos for fair dispatching.
        $this->node->basic_qos(
                static::$configuration['prefetch_size'],
                static::$configuration['prefetch_count'],
                static::$configuration['global']
        );

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

        // Close Rabbitmq channel and connection.
        $this->closeConnections();

        // TODO. Handle memory usage.
    }

    /**
     * Close Rabbitmq channel and connection.
     *
     * @return void
     */
    public function closeConnections()
    {
        try {
            RabbitMQService::closeConnections();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}