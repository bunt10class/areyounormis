<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportFacade;
use Laminas\Diactoros\Response\JsonResponse;

class UserReportResponse extends JsonResponse
{
    public function __construct(UserReportFacade $report)
    {
        parent::__construct($report->getPrettyWithTops());
    }
}