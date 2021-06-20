<?php

namespace HeIsMehrab\PhpRabbitMq\Core;

use Exception, InvalidArgumentException;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

use HeIsMehrab\PhpRabbitMq\Config\Config;
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

        $this->node->basic_publish($message, $this->defaultExchange, $queue);

        // Remove un-used data.
        unset($message);
    }

    /**
     * Declare defined queues.
     *
     * @throws Exception
     *
     * @return void
     */
    private function declareQueues()
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
    private function declareExchanges() : void
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
}