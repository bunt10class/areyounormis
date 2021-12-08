<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportService;
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
        $userReport = $this->userReportService->collectUserReport($userId);

        return new UserReportResponse($userReport);
    }
}