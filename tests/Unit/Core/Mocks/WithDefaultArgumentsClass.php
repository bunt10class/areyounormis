<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Mocks;

class WithDefaultArgumentsClass
{
    public bool $bool;
    public string $string;
    public int $int;
    public float $float;
    public array $array;

    public function __construct(
        bool $bool = true,
        string $string = 'some_string',
        int $int = 123,
        float $float = 1.23,
        array $array = ['value1', 'value2'],
    ) {
        $this->bool = $bool;
        $this->string = $string;
        $this->int = $int;
        $this->float = $float;
        $this->array = $array;
    }
}