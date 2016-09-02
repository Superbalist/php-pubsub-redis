<?php

namespace Tests\Mocks;

class MockRedisPubSubLoop extends \ArrayIterator
{
    public function __construct()
    {
        $message1 = new \stdClass();
        $message1->kind = 'subscribe';
        $message1->payload = null;

        $message2 = new \stdClass();
        $message2->kind = 'message';
        $message2->payload = '{ "hello": "world" }';

        parent::__construct([$message1, $message2]);
    }
}
