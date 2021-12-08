<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Coefficient\Coefficients;
use Areyounormis\Coefficient\CoefficientService;
use Areyounormis\Movie\Movie;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;
use Areyounormis\SiteData\SiteDataServiceInterface;
use Areyounormis\User\User;
use Areyounormis\Vote\Vote;
use Areyounormis\Vote\VoteSystem;
use Areyounormis\Vote\VoteSystemFactory;

class UserReportService
{
    protected SiteDataServiceInterface $siteDataService;
    protected CoefficientService $coefService;
    protected ReportRedisRepository $reportRedisRepository;

    public function __construct(
        SiteDataServiceInterface $siteDataService,
        CoefficientService $coefService,
        ReportRedisRepository $reportRedisRepository,
    ) {
        $this->siteDataService = $siteDataService;
        $this->coefService = $coefService;
        $this->reportRedisRepository = $reportRedisRepository;
    }

    public function collectUserReportFacade(string $userId): UserReportFacade
    {
        $userReport = $this->collectUserReport($userId);
        return new UserReportFacade($userReport);
    }

    public function generateSaveUserReport(string $userId): void
    {
        $userReport = $this->collectUserReport($userId);
        $userReportFacade = new UserReportFacade($userReport);

        $this->reportRedisRepository->saveUserReport($userId, $userReportFacade->getPrettyUserReport());
    }

    public function deleteUserReport(string $userId): void
    {
        $this->reportRedisRepository->deleteUserReport($userId);
    }

    public function getUserReport(string $userId): array
    {
        return $this->reportRedisRepository->getUserReport($userId);
    }

    public function collectUserReport(string $userId): UserReport
    {
        $user = new User($userId, null);

        $siteData = $this->siteDataService->getByUserId($userId);

        return new UserReport(
            $user,
            $this->coefService->collectUserReportCoefficients($siteData->getVotes()),
            $siteData->getVoteSystem(),
            $siteData->getMovieVotes(),
        );
    }
}