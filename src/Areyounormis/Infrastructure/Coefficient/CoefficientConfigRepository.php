<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\Coefficient;

use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Core\Config;

class CoefficientConfigRepository
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @throws InvalidCoefficientTypeException
     * @throws InvalidCoefficientConfigException
     */
    public function getByType(string $type): array
    {
        CoefficientValidator::validateType($type);

        try {
            $coefficient = $this->config->get('coefficients.' . $type);

            CoefficientValidator::validateConfigData($coefficient);

            return $coefficient;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidCoefficientConfigException();
        }
    }
}