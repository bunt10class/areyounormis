<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Mocks;

class WithObjectAndDefaultNotObjectArgumentClass
{
    public InnerClass $object;
    public string $notObject;

    public function __construct(InnerClass $object, string $notObject = 'not_object')
    {
        $this->object = $object;
        $this->notObject = $notObject;
    }
}