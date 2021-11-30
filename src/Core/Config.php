<?php

declare(strict_types=1);

namespace Core;

use Core\Exceptions\InvalidArgumentException;

class Config
{
    private array $params = [];

    public function __construct(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_string($key)) {
                $this->set($key, $value);
            }
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException('Invalid key received in Config');
        }

        return $this->params[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->params);
    }

    public function set(string $key, mixed $value): void
    {
        $this->params[$key] = $value;
    }
}