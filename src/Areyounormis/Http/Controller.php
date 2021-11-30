<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie\Models\Http;

use Areyounormis\UserMovie\Models\Report\UserReportService;

class Controller
{
    protected UserReportService $dataService;

    public function __construct(UserReportService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function process(int $userId)
    {
        $this->dataService->getUserReportById($userId);

        return 'end';
    }
}