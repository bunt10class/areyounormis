<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Mocks;

class OuterClass
{
    protected MiddleClass $middleClass;

    public function __construct(MiddleClass $middleClass)
    {
        $this->middleClass = $middleClass;
    }
}