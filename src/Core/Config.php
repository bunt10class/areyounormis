<?php

declare(strict_types=1);

namespace Core;

use Core\Exceptions\InvalidArgumentConfigException;

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
     * @throws InvalidArgumentConfigException
     */
    public function get(string $key): mixed
    {
        $embedKeys = explode('.', $key);
        $key = array_shift($embedKeys);

        if (!$this->has($key)) {
            throw new InvalidArgumentConfigException();
        }

        $value = $this->params[$key];

        return $this->getThroughArrays($embedKeys, $value);
    }

    /**
     * @throws InvalidArgumentConfigException
     */
    protected function getThroughArrays(array $embedKeys, mixed $value): mixed
    {
        foreach ($embedKeys as $key) {
            if (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                throw new InvalidArgumentConfigException();
            }
        }

        return $value;
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