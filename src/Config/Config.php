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
     * Keep and exchange type
     *
     * @var string EXCHANGE_TYPE_FANOUT
     */
    private const EXCHANGE_TYPE_FANOUT = 'fanout';

    /**
     * Keep and exchange type
     *
     * @var string EXCHANGE_TYPE_FANOUT
     */
    private const EXCHANGE_TYPE_DIRECT = 'direct';

    /**
     * Keep and exchange types (only supported for this package).
     *
     * @var array EXCHANGE_TYPES
     */
    private const EXCHANGE_TYPES = [
        null,
        self::EXCHANGE_TYPE_FANOUT,
        self::EXCHANGE_TYPE_DIRECT
    ];

    /**
     * Define the default type of your exchange,
     * for now you can use NULL, FANOUT and DIRECT.
     *
     * null: for a Rabbit instance without any exchange.
     *
     * fanout: for a Rabbit instance with fanout type,
     * witch use the EXCHANGES array without its indexes (see the EXCHANGES constant below),
     * if you define more than one index for that array, system will
     * merge the values together.
     *
     * direct: for a Rabbit instance with direct type,
     * witch use the EXCHANGES array (see the EXCHANGES constant below)
     *
     * @var string EXCHANGE_TYPE
     */
    public const EXCHANGE_TYPE = 'DIRECT';

    /**
     * An associative array witch defines the
     * exchanges and its related queues;
     * array indexes are exchange names and its values (an array of queues)
     * contain queue names.
     *
     * this config affected when you start
     * to work with RabbitMQ.
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