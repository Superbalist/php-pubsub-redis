<?php

include __DIR__ . '/../vendor/autoload.php';

$client = new \Redis();
$client->connect('redis', 6379);

$adapter = new \Superbalist\PubSub\Redis\PhpRedisPubSubAdapter($client);

$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});
