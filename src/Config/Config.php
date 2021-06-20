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
     * Define the default type of your exchange,
     * for now you can use null, fanout, dire
     *
     * @var string EXCHANGE_TYPE
     */
    public const EXCHANGE_TYPE = 'DIRECT';

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