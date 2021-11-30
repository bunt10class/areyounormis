<?php

declare(strict_types=1);

namespace Core;

use Closure;
use Core\Exceptions\InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

class Container
{
    /**
     * @var Closure[]
     */
    private array $definitions = [];
    private array $results = [];

    public function __construct(array $definitions)
    {
        foreach ($definitions as $key => $value) {
            if (is_string($key) && $value instanceof Closure) {
                $this->set($key, $value);
            }
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        if (!$this->hasResult($key)) {
            if ($this->has($key)) {
                $object = $this->definitions[$key]($this);
            } else {
                $object = $this->tryCreateNewObject($key);
            }

            $this->results[$key] = $object;
        }

        return $this->results[$key];
    }

    private function hasResult(string $key): bool
    {
        return array_key_exists($key, $this->results);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->definitions);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function tryCreateNewObject(string $key): object
    {
        try {
            return $this->createNewObject($key);
        } catch (ReflectionException $exception) {
            throw new InvalidArgumentException('Invalid key: ' . $key . ' received in Container');
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    private function createNewObject($key): object
    {
        $reflection = new ReflectionClass($key);

        $arguments=[];
        if ($constructor = $reflection->getConstructor()) {
            $arguments = $this->getArgumentsForMethod($constructor);
        }

        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getArgumentsForMethod(ReflectionMethod $constructor): array
    {
        $arguments = [];
        foreach ($constructor->getParameters() as $param) {
            $default = $this->getDefaultParamValue($param);
            if (is_null($default)) {
                $arguments[] = $this->get((string)$param->getType());
            } else {
                $arguments[] = $default;
            }
        }
        return $arguments;
    }

    private function getDefaultParamValue(ReflectionParameter $param): mixed
    {
        try {
            return $param->getDefaultValue();
        } catch (ReflectionException $exception) {
            return null;
        }
    }

    public function set(string $key, Closure $closure): void
    {
        if ($this->hasResult($key)) {
            unset($this->results[$key]);
        }

        $this->definitions[$key] = $closure;
    }
}