<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Mocks;

class WithNotObjectArgumentClass
{
    protected string $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }

    public function getArgument(): string
    {
        return $this->argument;
    }
}