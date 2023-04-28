<?php

namespace Superbalist\PubSub\Redis;

use Redis;
use Superbalist\PubSub\PubSubAdapterInterface;
use Superbalist\PubSub\Utils;

class PhpRedisPubSubAdapter implements PubSubAdapterInterface
{
    /**
     * @var Redis
     */
    protected $client;

    /**
     * @param Redis $client
     */
    public function __construct(Redis $client)
    {
        $this->client = $client;
    }

    /**
     * Return the Redis client.
     *
     * @return Redis
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Subscribe a handler to a channel.
     *
     * @param string $channel
     * @param callable $handler
     */
    public function subscribe($channel, callable $handler)
    {
        $this->client->subscribe([$channel], function($instance, $channelName, $message) use ($handler) { 
            call_user_func($handler, Utils::unserializeMessagePayload($message));
        });
    }

    /**
     * Publish a message to a channel.
     *
     * @param string $channel
     * @param mixed $message
     */
    public function publish($channel, $message)
    {
        $this->client->publish($channel, Utils::serializeMessage($message));
    }

    /**
     * Publish multiple messages to a channel.
     *
     * @param string $channel
     * @param array $messages
     */
    public function publishBatch($channel, array $messages)
    {
        foreach ($messages as $message) {
            $this->publish($channel, $message);
        }
    }
}
