# php-rabbitMQ-x package
<br>

<p align="center">
<a href="https://packagist.org/packages/heismehrab/php-rabbitmq-x"><img src="https://poser.pugx.org/heismehrab/php-rabbitmq-x/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/heismehrab/php-rabbitmq-x"><img src="https://poser.pugx.org/heismehrab/php-rabbitmq-x/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/heismehrab/php-rabbitmq-x"><img src="https://poser.pugx.org/heismehrab/php-rabbitmq-x/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/heismehrab/php-rabbitmq-x"><img src="https://poser.pugx.org/heismehrab/php-rabbitmq-x/composerlock" alt="License"></a>
</p>

This package basically designed to communicate with your Rabbitmq instance to consume/produce messages.

You must be familiar with basic titles of Rabbitmq to understand how this packages works and how it behaves with Rabbitmq processes.

We suggest that you visit the [official website of Rabbitmq](https://rabbitmq.com) if you are not familiar with the whole Rabbitmq cycle, or you can visit 
[example oriented](https://www.rabbitmq.com/getstarted.html) samples of Rabbitmq if you already familiar with it.

## Installation.

Before anything, developer has to know that package uses php `>= 7.0` and 
<span style="color: red"> ONLY </span> features of Rabbitmq which supported by the package explains in below:

| titles | Features/Types | version |
| :---         |     :---:      |          ---: |
| Queues   | `DLX`, `exchange-bindings`     | `0.9.0`, `1.0.0`    |
| Exchanges     | `Fanout`, `direct`, `routing-keys`       | `0.9.0`, `1.0.0`      |
| QOS (Fair dispatching)     | `prefetch-size`, `prefetch-count`       | `0.9.0`, `1.0.0`      |

<br>
Note that the package always declare queues as <span style="color: lightskyblue"> durable </span> and do only <span style="color: lightskyblue"> manual acknowledgment </span> for messages/tasks,
so you have to handle some conditions according to acknowledgments in your Consumer callback;
We do this to be sure that all messages/tasks will be safe and they are not discarded during Rabbitmq dispatching or consumer crashes.  

<br>

install via composer:

```bash
$ composer require heismehrab/php-rabbitmq-x
```

After installing the package, we need to have a configuration file which the both producer and consumer workers needs it to start the process.

This configuration file keeps the details of all `Rabbitmq authentication`, `Queues`, `Exchanges`, `Dead letter exchanges`, `exchange and queue bindings` and `QOS tuning settings`;

You can see and use the structure of original config file in below:

```php
[

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
``` 
<br>

For more examples of the configuration file, you can check the [original file](./src/Config/config.php) which placed in package root directory.

## How the package works?
When we get an instance of a Producer/Consumer and inject the configuration file into that,
the service will start validate the file and then declare the queues, exchanges, etc... which explained in above table;
finally we have a configured Rabbitmq instance which is ready to handle messages/tasks. 

## Examples.

some samples that describe how a Producer and Consumer works:

#### Producer:

```php
use HeIsMehrab\PhpRabbitMq\Core\Producer;

$configuration = require_once '/path/to/the/config-file';

$producer = new Producer($configuration);

try {
    for ($i = 1; $i <= 5; $i ++) {
        $message = json_encode([
            'success' => true,
            'time' => time(),
            'number' => $i
        ]);
    
        // Set a json encoded array of data via setMessage() method.
        $producer->setMessage($message);

        // According to default configuration file,
        // a message will send to a exchange with name `notifications`
        // with 'high' routing key. 
        $producer->sendToQueue('high', 'notifications');
    }

    $producer->closeConnections();
} catch (Exception $e) {
    echo $e->getMessage();
}
```
<br>

#### Consumer:

```php
use HeIsMehrab\PhpRabbitMq\Core\Consumer;

$configuration = require_once '/path/to/the/config-file';

$consumer = new Consumer($configuration);

$callBack = function ($message) {
    // The payload of the message that producer sent to Rabbitmq.
    $body = json_decode($message->body);
    
    var_dump($body);
    // some logics...
    
    $message->ack($message->delivery_info['delivery_tag']);
};

try {
    $consumer->listen('Q1', $callBack);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

To be sure that Producer service closes the connections to Rabbitmq after sending messages/tasks,
you can call the `closeConnections()` method, this method is available in both Producer and Consumer instances;
note the Consumer call this method by its own, so you don't need to do that in manual for Consumer services.

<br>

```php 
$producer->closeConnections();
```

you can also take a look at [here](./example) directory of package to see more example oriented samples.