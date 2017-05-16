<?php

include __DIR__ . '/../vendor/autoload.php';

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host' => 'redis',
    'port' => 6379,
    'database' => 0,
    'read_write_timeout' => 0,
]);

$adapter = new \Superbalist\PubSub\Redis\RedisPubSubAdapter($client);

$adapter->publish('my_channel', 'HELLO WORLD');
$adapter->publish('my_channel', ['hello' => 'world']);
$adapter->publish('my_channel', 1);
$adapter->publish('my_channel', false);
