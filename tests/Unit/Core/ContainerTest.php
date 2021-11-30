<?php

declare(strict_types=1);

namespace Tests\Unit\Core;

use Core\Container;
use Core\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Unit\Core\Mocks\AnotherClass;
use Tests\Unit\Core\Mocks\InnerClass;
use Tests\Unit\Core\Mocks\OuterClass;
use Tests\Unit\Core\Mocks\SomeClass;
use Tests\Unit\Core\Mocks\SomeClassInterface;
use Tests\Unit\Core\Mocks\WithDefaultArgumentsClass;
use Tests\Unit\Core\Mocks\WithNotObjectArgumentClass;
use Tests\Unit\Core\Mocks\WithObjectAndDefaultNotObjectArgumentClass;

class ContainerTest extends TestCase
{
    protected Container $classUnderTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new Container([]);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testCreateClassWithDefinitions(): void
    {
        $key1 = SomeClass::class;
        $value1 = new SomeClass();
        $key2 = AnotherClass::class;
        $value2 = new AnotherClass();
        $definitions = [
            $key1 => function () use ($value1) {
                return $value1;
            },
            $key2 => function () use ($value2) {
                return $value2;
            },
        ];

        $classUnderTest = new Container($definitions);

        self::assertTrue($classUnderTest->has($key1));
        self::assertSame($value1, $classUnderTest->get($key1));
        self::assertTrue($classUnderTest->has($key2));
        self::assertSame($value2, $classUnderTest->get($key2));
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testCreateClassWithValueNotClosure(): void
    {
        $key = SomeClass::class;
        $definitions = [
            $key => new SomeClass(),
        ];

        $classUnderTest = new Container($definitions);

        self::assertFalse($classUnderTest->has($key));
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testSetHasGetObjectWithArgument(): void
    {
        $key = 'some_key';
        $argument = 'some_argument';
        $closure = function () use ($argument) {
            return new WithNotObjectArgumentClass($argument);
        };

        $this->classUnderTest->set($key, $closure);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertInstanceOf(WithNotObjectArgumentClass::class, $class = $this->classUnderTest->get($key));
        self::assertEquals($argument, $class->getArgument());
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testSetHasGetNotObject(): void
    {
        $key = 'some_key';
        $value = 'some_argument';
        $closure = function () use ($value) {
            return $value;
        };

        $this->classUnderTest->set($key, $closure);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertEquals($value, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testSetHasGetObjectByInterface(): void
    {
        $key = SomeClassInterface::class;
        $closure = function (Container $container) {
            return $container->get(SomeClass::class);
        };

        $this->classUnderTest->set($key, $closure);

        self::assertTrue($this->classUnderTest->has($key));
        self::assertInstanceOf(SomeClass::class, $this->classUnderTest->get($key));
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testSetNewObjectAfterGetting(): void
    {
        $key = 'some_key';
        $value1 = new stdClass();
        $closure1 = function () use ($value1) {
            return $value1;
        };
        $this->classUnderTest->set($key, $closure1);
        $this->classUnderTest->get($key);

        $value2 = new stdClass();
        $closure2 = function () use ($value2) {
            return $value2;
        };

        $this->classUnderTest->set($key, $closure2);

        self::assertNotSame($value1, $this->classUnderTest->get($key));
        self::assertSame($value2, $this->classUnderTest->get($key));
    }
    
    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetNotExistentKey(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->classUnderTest->get('some_key');
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testHasNotExistentKey(): void
    {
        $result = $this->classUnderTest->has('some_key');

        self::assertFalse($result);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetSingletonDefinition(): void
    {
        $key = 'some_key';
        $closure = function () {
            return new stdClass();
        };
        $this->classUnderTest->set($key, $closure);

        $value1 = $this->classUnderTest->get($key);
        $value2 = $this->classUnderTest->get($key);

        self::assertNotNull($value1);
        self::assertNotNull($value2);
        self::assertSame($value1, $value2);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetObjectByClassName(): void
    {
        $className = InnerClass::class;

        $value = $this->classUnderTest->get($className);

        self::assertInstanceOf($className, $value);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testFailedGetObjectByInvalidClassName(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->classUnderTest->get('not_class_name');
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetObjectByClassNameWithTwoDepthArgument(): void
    {
        $className = OuterClass::class;

        $value = $this->classUnderTest->get($className);

        self::assertInstanceOf($className, $value);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetExceptionByClassNameWithNotObjectArgument(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->classUnderTest->get(WithNotObjectArgumentClass::class);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetObjectByClassNameWithDefaultNotObjectArguments(): void
    {
        $className = WithDefaultArgumentsClass::class;

        /** @var WithDefaultArgumentsClass $value */
        $value = $this->classUnderTest->get($className);

        self::assertInstanceOf($className, $value);
        self::assertEquals(true, $value->bool);
        self::assertEquals('some_string', $value->string);
        self::assertEquals(123, $value->int);
        self::assertEquals(1.23, $value->float);
        self::assertEquals(['value1', 'value2'], $value->array);
    }

    /**
     * @group unit
     * @group core
     * @group container
     */
    public function testGetObjectByClassNameWithObjectArgumentAndDefaultNotObjectArguments(): void
    {
        $className = WithObjectAndDefaultNotObjectArgumentClass::class;

        /** @var WithObjectAndDefaultNotObjectArgumentClass $value */
        $value = $this->classUnderTest->get($className);

        self::assertInstanceOf($className, $value);
        self::assertInstanceOf(InnerClass::class, $value->object);
        self::assertEquals('not_object', $value->notObject);
    }
}