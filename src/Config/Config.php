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
     * Keep the default exchange, that
     * must be the one the indexes of EXCHANGES array
     * defined by yours.
     *
     * @var string DEFAULT_EXCHANGE
     */
    public const DEFAULT_EXCHANGE = '';

    /**
     * An associative array witch defines the
     * exchanges and its related type and queues;
     * array indexes are exchange names and its values (an array of data)
     * is type and queue names.
     *
     * this config affected when you
     * start to work with RabbitMQ.
     *
     * type Null: for RabbitMQ instance without any exchanges.
     *
     * type Fanout: for RabbitMQ instance with fanout exchange.
     *
     * type Direct: for RabbitMQ instance with direct exchange.
     *
     * @var array EXCHANGES
     */
    public const EXCHANGES = [
//        'default' => [
//            'type' => self::EXCHANGE_TYPE_FANOUT,
//            'queues' => [
//                'Q1',
//                'Q2'
//            ],
//            'routingKeys' => []
//        ],
//
//        'notifications' => [
//            'type' => self::EXCHANGE_TYPE_DIRECT,
//            'queues' => [
//                'Q3',
//                'Q4'
//            ],
//            'routingKeys' => [
//                'high',
//                'low'
//            ]
//        ],
    ];

    /**
     * Keep array of queues.
     *
     * @var array $queues.
     */
    public const QUEUES = [
//        'Q1',
//        'Q2',
//        'Q3',
//        'Q4'
    ];
}