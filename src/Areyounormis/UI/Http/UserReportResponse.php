<?php

declare(strict_types=1);

namespace Areyounormis\UI\Http;

use Areyounormis\Service\Report\UserResourceReportFacade;
use Laminas\Diactoros\Response\JsonResponse;

class UserReportResponse extends JsonResponse
{
    public function __construct(UserResourceReportFacade $report)
    {
        parent::__construct($report->getPrettyWithTops());
    }
}