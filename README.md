# php-pubsub-redis

A Redis adapter for the [php-pubsub](https://github.com/Superbalist/php-pubsub) package.

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/php-pubsub-redis/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/php-pubsub-redis)
[![StyleCI](https://styleci.io/repos/67252513/shield?branch=master)](https://styleci.io/repos/67252513)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/php-pubsub-redis.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-pubsub-redis)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/php-pubsub-redis.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-pubsub-redis)


## Installation

```bash
composer require superbalist/php-pubsub-redis
```
    
## Usage

```php
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host' => '127.0.0.1',
    'port' => 6379,
    'database' => 0,
    'read_write_timeout' => 0
]);

$adapter = new \Superbalist\PubSub\Redis\RedisPubSubAdapter($client);

// consume messages
// note: this is a blocking call
$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});

// publish messages
$adapter->publish('my_channel', 'HELLO WORLD');
$adapter->publish('my_channel', ['hello' => 'world']);
$adapter->publish('my_channel', 1);
$adapter->publish('my_channel', false);

// publish multiple messages
$messages = [
    'message 1',
    'message 2',
];
$adapter->publishBatch('my_channel', $messages);
```

## Examples

The library comes with [examples](examples) for the adapter and a [Dockerfile](Dockerfile) for
running the example scripts.

Run `make up`.

You will start at a `bash` prompt in the `/opt/php-pubsub` directory.

If you need another shell to publish a message to a blocking consumer, you can run `docker-compose run php-pubsub-redis /bin/bash`

To run the examples:
```bash
$ php examples/RedisConsumerExample.php
$ php examples/RedisPublishExample.php (in a separate shell)
```
