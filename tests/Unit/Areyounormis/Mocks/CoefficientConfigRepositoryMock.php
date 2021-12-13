<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Areyounormis\Infrastructure\Coefficient\CoefficientConfigRepository;
use Core\Exceptions\InvalidArgumentConfigException;

class CoefficientConfigRepositoryMock extends CoefficientConfigRepository
{
    protected mixed $data;
    protected bool $isException;

    public function __construct(mixed $data = [], bool $isException = false)
    {
        $this->data = $data;
        $this->isException = $isException;
    }

    public function getByType(string $type): array
    {
        if ($this->isException) {
            throw new InvalidArgumentConfigException();
        }
        return $this->data;
    }
}