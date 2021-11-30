<?php

declare(strict_types=1);

namespace Tests\Unit\Core;

use Core\Config;
use Core\Exceptions\InvalidArgumentException;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    protected Generator $faker;
    protected Config $classUnderTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new Config([]);
        $this->faker = Factory::create();
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testCreateClassWithParams(): void
    {
        $key1 = 'key1';
        $value1 = 'value1';
        $key2 = 'key2';
        $value2 = 'value2';
        $params = [
            $key1 => $value1,
            $key2 => $value2,
        ];

        $classUnderTest = new Config($params);

        self::assertTrue($classUnderTest->has($key1));
        self::assertEquals($value1, $classUnderTest->get($key1));
        self::assertTrue($classUnderTest->has($key2));
        self::assertEquals($value2, $classUnderTest->get($key2));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetBool(): void
    {
        $key = 'some_key';
        $value = $this->faker->boolean();

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetString(): void
    {
        $key = 'some_key';
        $value = $this->faker->name;

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetInt(): void
    {
        $key = 'some_key';
        $value = $this->faker->numberBetween();

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetFloat(): void
    {
        $key = 'some_key';
        $value = $this->faker->randomFloat();

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetArray(): void
    {
        $key = 'some_key';
        $value = [
            'first' => 1,
            'second' => 2,
        ];

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetHasGetObject(): void
    {
        $key = 'some_key';
        $value = new \stdClass();

        $this->classUnderTest->set($key, $value);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testGetNotExistentKey(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->classUnderTest->get('some_key');
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testHasNotExistentKey(): void
    {
        $key = 'some_key';

        $result = $this->classUnderTest->has($key);

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group core
     * @group config
     */
    public function testSetAlreadyExistentKey(): void
    {
        $key = 'some_key';
        $value = 'value1';
        $this->classUnderTest->set($key, $value);
        $nextValue = 'value2';

        $this->classUnderTest->set($key, $nextValue);

        self::assertEquals($nextValue, $this->classUnderTest->get($key));
    }
}