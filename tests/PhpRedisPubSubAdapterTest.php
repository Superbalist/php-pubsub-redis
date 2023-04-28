<?php

namespace Tests;

use Mockery;
use Redis;
use PHPUnit\Framework\TestCase;
use Superbalist\PubSub\Redis\PhpRedisPubSubAdapter;

class PhpRedisPubSubAdapterTest extends TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    public function testGetClient()
    {
        $client = Mockery::mock(Redis::class);
        $adapter = new PhpRedisPubSubAdapter($client);
        $this->assertSame($client, $adapter->getClient());
    }

    public function testSubscribe()
    {
        $client = Mockery::mock(Redis::class);
        $client->shouldReceive('subscribe')
            ->once();

        $adapter = new PhpRedisPubSubAdapter($client);
        $adapter->subscribe('subscribe', function(){});
    }

    public function testPublish()
    {
        $client = Mockery::mock(Redis::class);
        $client->shouldReceive('publish')
            ->withArgs([
                'channel_name',
                '{"hello":"world"}',
            ])
            ->once();

        $adapter = new PhpRedisPubSubAdapter($client);
        $adapter->publish('channel_name', ['hello' => 'world']);
    }

    public function testPublishBatch()
    {
        $client = Mockery::mock(Redis::class);
        $client->shouldReceive('publish')
            ->withArgs([
                'channel_name',
                '"message1"',
            ])
            ->once();
        $client->shouldReceive('publish')
            ->withArgs([
                'channel_name',
                '"message2"',
            ])
            ->once();

        $adapter = new PhpRedisPubSubAdapter($client);
        $messages = [
            'message1',
            'message2',
        ];
        $adapter->publishBatch('channel_name', $messages);
    }
}
