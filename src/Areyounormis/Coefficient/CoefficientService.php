<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

use Areyounormis\Coefficient\Exceptions\CoefficientException;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Coefficient\Exceptions\InvalidCoefficientValueException;
use Areyounormis\Vote\Votes;
use Areyounormis\Vote\VoteSystem;
use Core\Config;
use Webmozart\Assert\Assert;

class CoefficientService
{
    protected CoefficientCalculator $coefCalc;
    protected Config $config;

    public function __construct(
        CoefficientCalculator $coefCalc,
        Config $config,
    ) {
        $this->coefCalc = $coefCalc;
        $this->config = $config;
    }

    public function collectUserReportCoefficientValues(Votes $votes): CoefficientValues
    {
        $coefficientValues = new CoefficientValues();

        foreach (CoefficientHelper::TYPES as $type) {
            try {
                $coefficientValue = $this->calculateCoefficientValueByVotes($type, $votes);
            } catch (CoefficientException $exception) {
                continue;
            }
            $coefficientValues->addItem($coefficientValue);
        }

        return $coefficientValues;
    }

    /**
     * @throws CoefficientException
     */
    public function calculateCoefficientValueByVotes(string $type, Votes $votes): CoefficientValue
    {
        $value = $this->coefCalc->calculateValue($type, $votes);
        return $this->getCoefficientValue($type, $value);
    }

    /**
     * @throws CoefficientException
     */
    public function getCoefficientValue(string $type, float $value): CoefficientValue
    {
        $coefficient = $this->getConfigDataByType($type);
        $level = $this->defineLevel($coefficient['levels'], $value);

        return new CoefficientValue(
            new Coefficient($type, $coefficient['name'], $coefficient['description']),
            round($value, VoteSystem::PRECISION),
            new CoefficientLevel($level['color'], $level['description']),
        );
    }

    /**
     * @throws InvalidCoefficientConfigException
     * @throws InvalidCoefficientTypeException
     */
    protected function getConfigDataByType(string $type): array
    {
        CoefficientHelper::validateType($type);
        try {
            $configData = $this->config->get('coefficients.' . $type);
            $this->validateConfigDataStructure($configData);

            return $configData;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidCoefficientConfigException();
        }
    }

    /**
     * @throws \Webmozart\Assert\InvalidArgumentException
     */
    protected function validateConfigDataStructure(mixed $coefficient): void
    {
        Assert::isArray($coefficient);

        Assert::keyExists($coefficient, 'levels');
        Assert::isArray($coefficient['levels']);
        Assert::isNonEmptyList($coefficient['levels']);

        foreach ($coefficient['levels'] as $level) {
            Assert::isArray($level);
            Assert::keyExists($level, 'upper_limit');
            Assert::numeric($level['upper_limit']);
            Assert::keyExists($level, 'color');
            Assert::string($level['color']);
            Assert::keyExists($level, 'description');
            Assert::string($level['description']);
        }

        Assert::keyExists($coefficient, 'name');
        Assert::string($coefficient['name']);

        Assert::keyExists($coefficient, 'description');
        Assert::string($coefficient['description']);
    }

    /**
     * @throws InvalidCoefficientValueException
     */
    protected function defineLevel(array $levels, float $value): array
    {
        foreach ($levels as $level) {
            if ($value <= $level['upper_limit']) {
                return $level;
            }
        }

        throw new InvalidCoefficientValueException();
    }
}