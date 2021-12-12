<?php

declare(strict_types=1);

namespace Areyounormis\Service\Report;

use Areyounormis\Domain\Report\ReportConfigFactory;
use Areyounormis\Domain\Report\UserResourceReport;
use Areyounormis\Service\Coefficient\CoefficientService;
use Areyounormis\Infrastructure\Report\ReportDataRedisRepository;
use Areyounormis\Infrastructure\ResourceData\ResourceDataRepositoryInterface;
use Areyounormis\Domain\User\User;

class UserReportService
{
    protected ResourceDataRepositoryInterface $resourceDataRepo;
    protected CoefficientService $coefService;
    protected ReportDataRedisRepository $reportDataRedisRepo;
    protected ReportJob $reportJob;

    public function __construct(
        ResourceDataRepositoryInterface $siteDataService,
        CoefficientService $coefService,
        ReportDataRedisRepository $reportRedisRepository,
        ReportJob $userReportJob,
    ) {
        $this->resourceDataRepo = $siteDataService;
        $this->coefService = $coefService;
        $this->reportDataRedisRepo = $reportRedisRepository;
        $this->reportJob = $userReportJob;
    }

    public function collectToQueue(string $userId): void
    {
        $this->delete($userId);
        $this->reportJob->collectUserReport($userId);
    }

    public function save(string $userId, array $data): void
    {
        $this->reportDataRedisRepo->saveUserReport($userId, $data);
    }

    public function get(string $userId): array
    {
        return $this->reportDataRedisRepo->getUserReport($userId);
    }

    public function delete(string $userId): void
    {
        $this->reportDataRedisRepo->deleteUserReport($userId);
    }

    public function collectFacade(string $userId): UserResourceReportFacade
    {
        $userReport = $this->collectUserReport($userId);

        $reportConfig = ReportConfigFactory::makeDefault($userReport->getVoteSystem());

        return new UserResourceReportFacade($userReport, $reportConfig);
    }

    public function collectUserReport(string $userId): UserResourceReport
    {
        $user = new User($userId, null);

        $resourceData = $this->resourceDataRepo->getByUserId($userId);

        return new UserResourceReport(
            $user,
            $this->coefService->collectUserReportCoefficientValues($resourceData->getVoteList()),
            $resourceData->getVoteSystem(),
            $resourceData->getContentVoteList(),
        );
    }
}