<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DTest extends TestCase
{
    public function testQ(): void
    {
        self::assertTrue(true);
    }
    public function testFalse(): void
    {
        self::assertFalse(false);
    }
}