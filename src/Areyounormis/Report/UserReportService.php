<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Coefficient\CoefficientHelper;
use Areyounormis\Coefficient\Coefficients;
use Areyounormis\Coefficient\CoefficientService;
use Areyounormis\Coefficient\Exceptions\CoefficientException;
use Areyounormis\SiteData\SiteDataServiceInterface;
use Areyounormis\User\User;
use Areyounormis\Vote\Votes;

class UserReportService
{
    protected SiteDataServiceInterface $siteDataService;
    protected CoefficientService $coefService;

    public function __construct(
        SiteDataServiceInterface $siteDataService,
        CoefficientService $coefService,
    ) {
        $this->siteDataService = $siteDataService;
        $this->coefService = $coefService;
    }

    public function collectUserReportByUserId(string $userId): UserReport
    {
        $user = new User($userId, null);

        $siteData = $this->siteDataService->getByUserId($userId);

        return new UserReport(
            $user,
            $this->collectCoefficients($siteData->getVotes()),
            $siteData->getVoteSystem(),
            $siteData->getMovieVotes(),
        );
    }

    public function collectCoefficients(Votes $votes): Coefficients
    {
        $coefficients = new Coefficients();

        foreach (CoefficientHelper::TYPES as $type) {
            try {
                $coefficient = $this->coefService->calculateCoefficientByVotes($type, $votes);
            } catch (CoefficientException $exception) {
                var_dump($exception->getMessage(), $type);
                continue;
            }
            $coefficients->addItem($coefficient);
        }

        return $coefficients;
    }
}