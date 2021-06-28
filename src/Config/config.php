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

    /**
     * An associative array witch defines the
     * exchanges and its related type and queues;
     * array indexes are exchange names and its values (an array of data)
     * is type and queue names.
     *
     * this config affected when you
     * start to work with RabbitMQ.
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
            'dead_letter_exchange' => [
                'name' => 'foo', // With exchange.
                'routing_key' => 'key1' // With routing key.
            ]
        ],

        'Q2' => [
            'dead_letter_exchange' => [
                'name' => 'bar', // With exchange.
                'routing_key' => '' // Without routing keys.
            ]
        ],

        'Q3' => [
            'dead_letter_exchange' => [] // Without exchange.
        ],

        'Q4' => [
            'dead_letter_exchange' => [] // Without exchange.
        ]
    ]
];