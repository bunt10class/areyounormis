<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Core\Config;
use Core\Exceptions\InvalidArgumentConfigException;

class ConfigMock extends Config
{
    protected mixed $data;
    protected bool $isException;

    public function __construct(mixed $data = [], bool $isException = false)
    {
        $this->data = $data;
        $this->isException = $isException;

        parent::__construct([]);
    }

    public function get(string $key): mixed
    {
        if ($this->isException) {
            throw new InvalidArgumentConfigException();
        }
        return $this->data;
    }
}