<?php

declare(strict_types=1);

namespace Core\Queue;

use Predis\Client;

class Producer
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function pushToQueue(string $name, string $payload)
    {
        $this->client->rpush($name, [$payload]);
    }
}