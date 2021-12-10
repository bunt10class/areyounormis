<?php

declare(strict_types=1);

namespace Core\Queue;

use Predis\Client;

abstract class ConsumerMain
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function run(): void
    {
        $payload = $this->popFromQueue();

        if (isset($payload)) {
            echo 'consumer ' . static::class . ' in progress with payload: ' . $payload . ' ... ';
            $this->process($payload);
            echo 'done' . PHP_EOL;
        }
    }

    private function popFromQueue(): string|null
    {
        return $this->client->lpop(static::class);
    }

    abstract protected function process(string $payload): void;
}