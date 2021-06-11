<?php

namespace HeIsMehrab\PhpRabbitMq\Services\RabbitMQ;

use Exception;
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
    public static $connection;

    /**
     * Keep AMQPStreamConnection channel.
     * 
     * @var static AMQPStreamConnection
     */
    public static $channel;

    /**
     * RabbitMQService constructor.
     */
    public function __construct()
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
     * @throws Exception
     */
    public function __destruct()
    {
        static::$channel->close();
        static::$connection->close();
    }
}