<?php

include __DIR__ . '/../vendor/autoload.php';

$client = new \Redis();
$client->connect('redis', 6379);

$adapter = new \Superbalist\PubSub\Redis\PhpRedisPubSubAdapter($client);

$adapter->publish('my_channel', 'HELLO WORLD');
$adapter->publish('my_channel', ['hello' => 'world']);
$adapter->publish('my_channel', 1);
$adapter->publish('my_channel', false);
