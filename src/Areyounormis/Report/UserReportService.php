<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Coefficient\CoefficientService;
use Areyounormis\ResourceData\ResourceDataRepositoryInterface;
use Areyounormis\User\User;

class UserReportService
{
    protected ResourceDataRepositoryInterface $siteDataService;
    protected CoefficientService $coefService;
    protected ReportRedisRepository $reportRedisRepository;
    protected ReportJob $reportJob;

    public function __construct(
        ResourceDataRepositoryInterface $siteDataService,
        CoefficientService $coefService,
        ReportRedisRepository $reportRedisRepository,
        ReportJob $userReportJob,
    ) {
        $this->siteDataService = $siteDataService;
        $this->coefService = $coefService;
        $this->reportRedisRepository = $reportRedisRepository;
        $this->reportJob = $userReportJob;
    }

    public function collectToQueue(string $userId): void
    {
        $this->delete($userId);
        $this->reportJob->collectUserReport($userId);
    }

    public function save(string $userId, array $data): void
    {
        $this->reportRedisRepository->saveUserReportData($userId, $data);
    }

    public function get(string $userId): array
    {
        return $this->reportRedisRepository->getUserReport($userId);
    }

    public function delete(string $userId): void
    {
        $this->reportRedisRepository->deleteUserReport($userId);
    }

    public function collectFacade(string $userId): UserReportFacade
    {
        $userReport = $this->collectUserReport($userId);
        return new UserReportFacade($userReport);
    }

    public function collectUserReport(string $userId): UserReport
    {
        $user = new User($userId, null);

        $siteData = $this->siteDataService->getByUserId($userId);

        return new UserReport(
            $user,
            $this->coefService->collectUserReportCoefficientValues($siteData->getVotes()),
            $siteData->getVoteSystem(),
            $siteData->getMovieVotes(),
        );
    }
}