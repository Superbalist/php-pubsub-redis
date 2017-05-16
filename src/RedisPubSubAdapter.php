<?php

namespace Superbalist\PubSub\Redis;

use Predis\Client;
use Superbalist\PubSub\PubSubAdapterInterface;
use Superbalist\PubSub\Utils;

class RedisPubSubAdapter implements PubSubAdapterInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Return the Redis client.
     *
     * @return Client
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
        $loop = $this->client->pubSubLoop();

        $loop->subscribe($channel);

        foreach ($loop as $message) {
            /** @var \stdClass $message */
            if ($message->kind === 'message') {
                call_user_func($handler, Utils::unserializeMessagePayload($message->payload));
            }
        }

        unset($loop);
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
