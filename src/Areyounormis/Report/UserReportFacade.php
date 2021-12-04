<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Movie\MovieHelper;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;

class UserReportFacade
{
    protected const VOTES_PRECISION = 2;
    protected const MIN_INTEREST_MODULE_RELATIVE_DIFF = 0.3;

    protected UserReport $userReport;
    protected int $overRateNumber;
    protected int $underRateNumber;

    public function __construct(
        UserReport $userReport,
        int $overRateNumber = 10,
        int $underRateNumber = 10,
    ) {
        $this->userReport = $userReport;
        $this->overRateNumber = $overRateNumber;
        $this->underRateNumber = $underRateNumber;
    }

    public function getPrettyUserReport(): array
    {
        return [
            'user' => $this->userReport->getUser()->toArray(),
            'votes_system' => $this->userReport->getVoteSystem()->toArray(),
            'coefficients' => $this->getPrettyCoefficients(),
            'movie_number' => $this->userReport->getMovieVotes()->count(),
            'movie_votes' => $this->getPrettyMovieVotesWithRates(),
        ];
    }

    protected function getPrettyCoefficients(): array
    {
        $result = [];

        foreach ($this->userReport->getCoefficients()->getItems() as $coefficient) {
            $result[] = $coefficient->toArray();
        }

        return $result;
    }

    protected function getPrettyMovieVotesWithRates(): array
    {
        $normRates = new MovieVotes();
        $overRates = new MovieVotes();
        $underRates = new MovieVotes();

        foreach ($this->userReport->getMovieVotes()->getItems() as $movieVote) {
            $vote = $movieVote->getVote();
            $moduleRelativeDiff = $vote->getModuleRelativeDiff();

            if ($moduleRelativeDiff <= $this->userReport->getVoteSystem()->getRelativeStep() / 2) {
                $normRates->addItem($movieVote);
            } elseif ($moduleRelativeDiff > self::MIN_INTEREST_MODULE_RELATIVE_DIFF) {
                $vote->getRelativeDiff() > 0 ? $overRates->addItem($movieVote) : $underRates->addItem($movieVote);
            }
        }

        $overRates = MovieVotesCollector::getTheFirstNumberMaxDiffMovieVotes($overRates, $this->overRateNumber);
        $underRates = MovieVotesCollector::getTheFirstNumberMaxDiffMovieVotes($underRates, $this->underRateNumber);

        return [
            'norm_rates' => $this->getPrettyMovieVotes($normRates),
            'over_rates' => $this->getPrettyMovieVotes($overRates),
            'under_rates' => $this->getPrettyMovieVotes($underRates),
        ];
    }

    protected function getPrettyMovieVotes(MovieVotes $movieVotes): array
    {
        $result = [];

        foreach ($movieVotes->getItems() as $movieVote) {
            $result[] = $this->getPrettyMovieVote($movieVote);
        }

        return [
            'number' => $movieVotes->count(),
            'movie_vote' => $result,
        ];
    }

    protected function getPrettyMovieVote(MovieVote $movieVote): array
    {
        $vote = $movieVote->getVote();
        $movie = $movieVote->getMovie();

        return [
            'movie' => [
                'name' => MovieHelper::getFullName($movie),
                'link' => $movie->getLink(),
            ],
            'rate' => [
                'user_vote' => round($vote->getUserVote(), self::VOTES_PRECISION),
                'site_vote' => round($vote->getSiteVote(), self::VOTES_PRECISION),
                'absolute_diff' => round($vote->getAbsoluteDiff(), self::VOTES_PRECISION),
            ],
        ];
    }
}