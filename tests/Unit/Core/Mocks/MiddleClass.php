<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Mocks;

class MiddleClass
{
    protected InnerClass $exampleClass;

    public function __construct(InnerClass $exampleClass)
    {
        $this->exampleClass = $exampleClass;
    }
}