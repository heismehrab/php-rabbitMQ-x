<?php

namespace HeIsMehrab\PhpRabbitMq\Services\RabbitMQ;

use Exception;

use PhpAmqpLib\Channel\AMQPChannel;
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
     * @param array $configFile
     *
     * @return RabbitMQService|AMQPChannel
     */
    public static function node(array $configFile)
    {
        if (is_null(static::$channel)) {
            new self($configFile);
        }

        return static::$channel;
    }

    /**
     * RabbitMQService constructor.
     *
     * @param array $configFile
     */
    private function __construct(array $configFile)
    {
        // Create Connection with RabbitMQ.
        static::$connection = new AMQPStreamConnection(
            $configFile['host'],
            $configFile['port'],
            $configFile['username'],
            $configFile['password']
        );

        static::$channel = static::$connection->channel();
    }

    /**
     * RabbitMQService destructor.
     *
     * @throws Exception
     */
    public static function closeConnections()
    {
        static::$channel->close();
        static::$connection->close();
    }
}