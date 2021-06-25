<?php

return [

    /* ------------------------ RABBITMQ AUTHORIZATION  ------------------------ */
    'host' => '',
    'port' => '',
    'username' => '',
    'password' => '',

    /* ------------------------ RABBITMQ QOS CONFIGURATION ------------------------ */

    /**
     * TRUE will affect on channel,
     * FALSE will affected on consumers.
     */
    'global' => false,

    'prefetch_size' => null,

    /**
     * number of tasks/jobs that comes to channel
     * or picked up by consumers according to *global* (see index global above).
     */
    'prefetch_count' => 5,

    /* ------------------------ RABBITMQ EXCHANGE CONFIGURATION ------------------------ */

    /**
     * Keep the default exchange, that
     * must be the one the indexes of EXCHANGES array
     * defined by yours.
     */
    'default_exchange' => '',

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
     */
    'exchanges' => [
        'default' => [
            'type' => 'fanout',
            'queues' => [
                'Q1' => [], // Without any routing key.
                'Q2' => [] // Without any routing key.
            ],
        ],

        'notifications' => [
            'type' => 'direct',
            'queues' => [
                'Q3' => [ // With routing keys.
                    'high',
                    'low'
                ],

                'Q4' => [ // With routing keys.
                    'high'
                ]
            ]
        ]
    ],

    /* ------------------------ RABBITMQ QUEUE CONFIGURATION ------------------------ */

    /**
     * Queues are place in here,
     * defined queues must be same with declared ones
     * in *exchanges* array (see index exchanges above)
     */
    'queues' => [
        'Q1' => [
            'exchange' => [
                'name' => 'foo',
                'routing_keys' => [ // With routing keys.
                    'key1',
                    'key2'
                ]
            ]
        ],

        'Q2' => [
            'exchange' => [
                'name' => 'bar',
                'routing_keys' => [ // With routing keys.
                    'key1'
                ]
            ]
        ],

        'Q3' => [
            'exchange' => [] // Without exchange.
        ],

        'Q4' => [
            'exchange' => [] // Without exchange.
        ]
    ]
];