<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use Exception, InvalidArgumentException;

use PhpAmqpLib\Channel\AMQPChannel;

use HeIsMehrab\PhpRabbitMq\Config\Config;
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
     * Keep exchanges.
     *
     * @var array $exchanges
     */
    public $exchanges = Config::EXCHANGES;

    /**
     * Keep exchange type.
     *
     * @var string $defaultExchange
     */
    public $defaultExchange = Config::DEFAULT_EXCHANGE;

    /**
     * Keep queues.
     *
     * @var string $queues
     */
    public $queues = Config::QUEUES;

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
     * Set the exchanges.
     *
     * @param array $exchanges
     *
     * @return void
     */
    public function setExchanges(array $exchanges)
    {
        $this->exchanges = $exchanges;
    }

    /**
     * Set the default exchange.
     *
     * @param string $name
     *
     * @return void
     */
    public function setDefaultExchange(string $name)
    {
        $this->defaultExchange = $name;
    }

    /**
     * Set the queues.
     *
     * @param string $queues
     *
     * @return void
     */
    public function setQueues(string $queues)
    {
        $this->queues = $queues;
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
        if (! is_array($this->queues)) {
            $errorMessage = 'argument queues must be array, not %s';

            throw new InvalidArgumentException(sprintf($errorMessage, gettype($this->queues)));
        }

        if (! count($this->queues)) {
            $errorMessage = 'argument queues can not be empty or Null';

            throw new Exception($errorMessage);
        }

        foreach ($this->queues as $queue) {
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
        if (count($this->exchanges)) {

            foreach ($this->exchanges as $name => $data) {
                $this->node->exchange_declare(
                    $name,
                    $data['type'],
                    false,
                    false,
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
        if (count($this->exchanges)) {

            foreach ($this->exchanges as $name => $data) {

                foreach ($data['queues'] as $queue) {

                    // bind with routing key.
                    if (count($data['routingKeys'])) {

                        foreach ($data['routingKeys'] as $routingKey) {
                            $this->node->queue_bind($queue, $name, $routingKey);
                        }

                        continue;
                    }

                    // Bind without routing key.
                    $this->node->queue_bind($queue, $name, '');
                }
            }
        }
    }
}