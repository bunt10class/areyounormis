<?php

declare(strict_types=1);

namespace Areyounormis\UI\Http;

use Areyounormis\Service\Report\UserReportService;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;

class ApiController
{
    protected UserReportService $userReportService;

    public function __construct(
        UserReportService $userReportService,
    ) {
        $this->userReportService = $userReportService;
    }

    public function getUserReportById(ServerRequest $request): JsonResponse
    {
        $userId = $request->getQueryParams()['user_id'];
        $report = $this->userReportService->collectFacade($userId);

        return new UserReportResponse($report);
    }
}