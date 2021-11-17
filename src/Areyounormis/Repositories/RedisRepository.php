<?php

declare(strict_types=1);

namespace Areyounormis\Repositories;

use Exception;
use Predis\Client;

class RedisRepository
{
    protected Client $redisClient;

    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        try {
            $this->redisClient = new Client([
                'host' => 'redis',
            ]);
        } catch (Exception $e) {
            echo 'error: ' . $e->getMessage();
            return;
        }
    }

    public function save(string $key, string $data): void
    {
        $this->redisClient->set($key, $data);
    }

    public function get(string $key)
    {
        return $this->redisClient->get($key);
    }
}