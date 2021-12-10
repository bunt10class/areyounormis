<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Movie\MovieHelper;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;
use Areyounormis\Movie\MovieVotesCollector;

class UserReportFacade
{
    protected const VOTES_PRECISION = 2;
    protected const MIN_INTEREST_MODULE_RELATIVE_DIFF = 0.3;

    protected UserReport $userReport;

    public function __construct(UserReport $userReport)
    {
        $this->userReport = $userReport;
    }

    public function getPrettyWithTops(int $overRateNumber = 10, int $underRateNumber = 10): array
    {
        return [
            'user' => $this->userReport->getUser()->toArray(),
            'votes_system' => $this->userReport->getVoteSystem()->toArray(),
            'coefficient_values' => $this->getPrettyCoefficientValues(),
            'movie_number' => $this->userReport->getMovieVotes()->count(),
            'movie_votes' => $this->getPrettyMovieVotesWithRates($overRateNumber, $underRateNumber),
        ];
    }

    protected function getPrettyCoefficientValues(): array
    {
        $result = [];

        foreach ($this->userReport->getCoefficientValues()->getItems() as $coefficientValue) {
            $result[] = $coefficientValue->toArray();
        }

        return $result;
    }

    protected function getPrettyMovieVotesWithRates(int $overRateNumber, int $underRateNumber): array
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

        $normRates = MovieVotesCollector::sortMovieVotesByMovieName($normRates);
        $overRates = MovieVotesCollector::getTheFirstNumberMaxDiffMovieVotes($overRates, $overRateNumber);
        $underRates = MovieVotesCollector::getTheFirstNumberMaxDiffMovieVotes($underRates, $underRateNumber);

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
            'movie_votes' => $result,
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