<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\Coefficient;

use Core\Config;
use Core\Exceptions\InvalidArgumentConfigException;

class CoefficientConfigRepository
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @throws InvalidArgumentConfigException
     */
    public function getByType(string $type): array
    {
        return $this->config->get('coefficients.' . $type);
    }
}