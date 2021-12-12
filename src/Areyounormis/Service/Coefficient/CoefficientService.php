<?php

declare(strict_types=1);

namespace Areyounormis\Service\Coefficient;

use Areyounormis\Infrastructure\Coefficient\Exceptions\CoefficientException;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientConfigException;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientTypeException;
use Areyounormis\Infrastructure\Coefficient\Exceptions\InvalidCoefficientValueException;
use Areyounormis\Infrastructure\Coefficient\CoefficientConfigRepository;
use Areyounormis\Domain\Coefficient\Coefficient;
use Areyounormis\Domain\Coefficient\CoefficientLevel;
use Areyounormis\Domain\Coefficient\CoefficientHelper;
use Areyounormis\Domain\Coefficient\CoefficientValue;
use Areyounormis\Domain\Coefficient\CoefficientValueList;
use Areyounormis\Domain\Vote\VoteList;

class CoefficientService
{
    protected CoefficientCalculator $coefCalc;
    protected CoefficientConfigRepository $coefConfigRepo;

    public function __construct(
        CoefficientCalculator $coefCalc,
        CoefficientConfigRepository $coefConfigRepo,
    ) {
        $this->coefCalc = $coefCalc;
        $this->coefConfigRepo = $coefConfigRepo;
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
        $value = $this->coefCalc->calculateValue($type, $votes);
        return $this->collectCoefficientValue($type, $value);
    }

    /**
     * @throws InvalidCoefficientConfigException
     * @throws InvalidCoefficientTypeException
     * @throws InvalidCoefficientValueException
     */
    public function collectCoefficientValue(string $type, float $value): CoefficientValue
    {
        $coefficient = $this->coefConfigRepo->getByType($type);
        $level = $this->defineLevel($coefficient['levels'], $value);

        return new CoefficientValue(
            new Coefficient($type, $coefficient['name'], $coefficient['description']),
            round($value, CoefficientHelper::PRECISION),
            new CoefficientLevel($level['color'], $level['description']),
        );
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