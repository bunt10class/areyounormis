<?php

declare(strict_types=1);

namespace Areyounormis\Service\Coefficient;

use Areyounormis\Domain\Coefficient\Coefficient;
use Areyounormis\Domain\Coefficient\CoefficientLevel;
use Areyounormis\Domain\Coefficient\CoefficientHelper;
use Areyounormis\Domain\Coefficient\CoefficientValue;
use Areyounormis\Domain\Coefficient\CoefficientValueList;
use Areyounormis\Domain\Vote\VoteList;
use Areyounormis\Infrastructure\Coefficient\CoefficientConfigRepository;
use Areyounormis\Service\Coefficient\Exceptions\CoefficientException;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Service\Coefficient\Exceptions\InvalidCoefficientValueException;


class CoefficientService
{
    protected CoefficientCalculator $calculator;
    protected CoefficientConfigRepository $configRepo;
    protected CoefficientValidator $validator;

    public function __construct(
        CoefficientCalculator $calculator,
        CoefficientConfigRepository $coefConfigRepo,
        CoefficientValidator $validator,
    ) {
        $this->calculator = $calculator;
        $this->configRepo = $coefConfigRepo;
        $this->validator = $validator;
    }

    public function collectUserReportCoefficientValues(VoteList $votes): CoefficientValueList
    {
        $coefficientValues = new CoefficientValueList();

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
    public function calculateCoefficientValueByVotes(string $type, VoteList $votes): CoefficientValue
    {
        $value = $this->calculator->calculateValue($type, $votes);
        return $this->collectCoefficientValue($type, $value);
    }

    /**
     * @throws InvalidCoefficientConfigException
     * @throws InvalidCoefficientTypeException
     * @throws InvalidCoefficientValueException
     */
    public function collectCoefficientValue(string $type, float $value): CoefficientValue
    {
        $coefficient = $this->getByType($type);
        $level = $this->defineLevel($coefficient['levels'], $value);

        return new CoefficientValue(
            new Coefficient($type, $coefficient['name'], $coefficient['description']),
            round($value, CoefficientHelper::PRECISION),
            new CoefficientLevel($level['color'], $level['description']),
        );
    }

    /**
     * @throws InvalidCoefficientTypeException
     * @throws InvalidCoefficientConfigException
     */
    protected function getByType(string $type): array
    {
        $this->validator->validateType($type);

        try {
            $coefficient = $this->configRepo->getByType($type);
            $this->validator->validateConfigData($coefficient);

            return $coefficient;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidCoefficientConfigException();
        }
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