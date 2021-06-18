<?php

namespace HeIsMehrab\PhpRabbitMq\Services\RabbitMQ;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use HeIsMehrab\PhpRabbitMq\Config\Env;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class RabbitMQService.
 * The connection between the app
 * and RabbitMQ node defined in here.
 *
 * @package HeIsMehrab\PhpRabbitMq\Services\RabbitMQ
 */
class RabbitMQService
{
    /**
     * Keep AMQPStreamConnection instance.
     * 
     * @var AMQPStreamConnection
     */
    private static $connection;

    /**
     * Keep AMQPStreamConnection channel.
     * 
     * @var static AMQPChannel
     */
    private static $channel;

    /**
     * Get an instance of Rabbit node,
     * SingleTone mode.
     *
     * @return RabbitMQService|AMQPChannel
     */
    public static function node()
    {
        if (is_null(static::$channel)) {
            new self();
        }

        return static::$channel;
    }

    /**
     * RabbitMQService constructor.
     */
    private function __construct()
    {
        // Create Connection with RabbitMQ.
        static::$connection = new AMQPStreamConnection(
            Env::RABBITMQ_HOST,
            Env::RABBITMQ_PORT,
            Env::RABBITMQ_DEFAULT_USER,
            Env::RABBITMQ_DEFAULT_PASSWORD
        );

        static::$channel = static::$connection->channel();
    }

    /**
     * RabbitMQService destructor.
     *
     * @throws Exception
     */
    public function __destruct()
    {
        static::$channel->close();
        static::$connection->close();
    }
}