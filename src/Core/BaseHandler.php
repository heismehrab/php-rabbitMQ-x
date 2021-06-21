<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use PhpAmqpLib\Channel\AMQPChannel;

use {Exception, InvalidArgumentException};

use HeIsMehrab\PhpRabbitMq\Services\RabbitMQ\RabbitMQService;

/**
 * Class BaseHandler.
 * Define queues, exchanges and setters,
 * useful for both Producers and Consumers instances.
 *
 * @package HeIsMehrab\PhpRabbitMq\Core
 */
abstract class BaseHandler
{
    /**
     * Keep instance of RabbitMQ.
     *
     * @var RabbitMQService|AMQPChannel $node
     */
    protected $node;

    /**
     * Keep the message/task.
     *
     * @var string $message
     */
    public $message;

    /**
     * Get RabbitMQ configuration.
     *
     * @return array|null
     */
    public static function getConfigurations(): ?array
    {
        return null;
    }

    /**
     * Set the message.
     *
     * @param string $message
     *
     * @return void
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Declare defined queues.
     *
     * @throws Exception
     *
     * @return void
     */
    protected function declareQueues()
    {
        $queues = static::getConfigurations()['queues'];

        if (! is_array($queues)) {
            $errorMessage = 'argument queues must be array, not %s';

            throw new InvalidArgumentException(sprintf($errorMessage, gettype($queues)));
        }

        if (! count($queues)) {
            $errorMessage = 'argument queues can not be empty or Null';

            throw new Exception($errorMessage);
        }

        foreach ($queues as $queue) {
            $this->node->queue_declare(
                $queue,
                false,
                true,
                false,
                false
            );
        }
    }

    /**
     * Declare defined exchanges.
     *
     * @return void
     */
    protected function declareExchanges() : void
    {
        $exchanges = static::getConfigurations()['exchanges'];

        if (count($exchanges)) {

            foreach ($exchanges as $name => $data) {
                $this->node->exchange_declare(
                    $name,
                    $data['type'],
                    false,
                    true,
                    false
                );
            }
        }
    }

    /**
     * Bind queues and exchanges together.
     *
     * @return void
     */
    protected function bindExchangesAndQueues()
    {
        $exchanges = static::getConfigurations()['exchanges'];

        if (count($exchanges)) {

            foreach ($exchanges as $exchangeName => $details) {

                foreach ($details['queues'] as $queueName => $routingKeys) {

                    // bind with routing key.
                    if (count($routingKeys)) {

                        foreach ($routingKeys as $routingKey) {
                            $this->node->queue_bind($queueName, $exchangeName, $routingKey);
                        }

                        continue;
                    }

                    // Bind without routing key.
                    $this->node->queue_bind($queueName, $exchangeName);
                }
            }
        }
    }
}