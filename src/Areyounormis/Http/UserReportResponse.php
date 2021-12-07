<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReport;
use Areyounormis\Report\UserReportFacade;
use Laminas\Diactoros\Response\JsonResponse;

class UserReportResponse extends JsonResponse
{
    public function __construct(UserReport $userReport, int $overRateNumber = 10, int $underRateNumber = 10)
    {
        $data = $this->getData($userReport, $overRateNumber, $underRateNumber);

        parent::__construct($data, 200, [], self::DEFAULT_JSON_FLAGS);
    }

    protected function getData(UserReport $userReport, int $overRateNumber, int $underRateNumber): array
    {
        $result = new UserReportFacade($userReport, $overRateNumber, $underRateNumber);

        return $result->getPrettyUserReport();
    }
}