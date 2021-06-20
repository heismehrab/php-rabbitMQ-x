<?php

namespace HeIsMehrab\PhpRabbitMq\Config;

/**
 * Class Config.
 * Define your Rabbit configuration like
 * exchanges, queues, binding and etc ...
 *
 * @package HeIsMehrab\PhpRabbitMq\Config
 */
class Config
{
    /**
     * Keep an exchange type.
     *
     * @var string EXCHANGE_TYPE_FANOUT
     */
    private const EXCHANGE_TYPE_FANOUT = 'fanout';

    /**
     * Keep an exchange type.
     *
     * @var string EXCHANGE_TYPE_DIRECT
     */
    private const EXCHANGE_TYPE_DIRECT = 'direct';

    /**
     * Keep an array exchange types (only supported in this package).
     *
     * @var array EXCHANGE_TYPES
     */
    public const EXCHANGE_TYPES = [
        null,
        self::EXCHANGE_TYPE_FANOUT,
        self::EXCHANGE_TYPE_DIRECT
    ];

    /**
     * Define the default type of your exchange,
     * for now you can use null, fanout and direct.
     *
     * Null: for RabbitMQ instance without any exchanges.
     *
     * Fanout: for RabbitMQ instance with fanout exchange,
     * witch use the values of array EXCHANGES (see the constants below),
     * if you define more than one index in that array, system will
     * merge the all its values together.
     *
     * Direct: for RabbitMQ instance with direct exchange,
     * witch use the EXCHANGES array (see the constants below),
     * assume its indexes as a exchange names and its values
     * as queue names.
     *
     * @var string EXCHANGE_TYPE
     */
    public const DEFAULT_EXCHANGE = null;

    /**
     * An associative array witch defines the
     * exchanges and its related queues;
     * array indexes are exchange names and its values (an array of queues)
     * is queue names.
     *
     * this config affected when you
     * start to work with RabbitMQ.
     *
     * this is array is useful for
     * exchanges with type DIRECT, so Leave this array empty if you dont want
     * to use DIRECT exchange
     *
     * @var array EXCHANGES
     */
    public const EXCHANGES = [
//        'default' => [
//            'Q1',
//            'Q2'
//        ]
    ];
}