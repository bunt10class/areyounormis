<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportFacade;
use Areyounormis\Report\UserReportService;

class Action
{
    protected UserReportService $userReportService;

    public function __construct(
        UserReportService $userReportService,
    ) {
        $this->userReportService = $userReportService;
    }

    public function process(string $userId)
    {
        $userReport = $this->userReportService->collectUserReportByUserId($userId);

        $userReportFacade = new UserReportFacade(
            $userReport,
        );

        return $userReportFacade->getPrettyUserReport();
    }
}