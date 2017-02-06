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

$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});
