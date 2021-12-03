<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Areyounormis\Movie\MovieHelper;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;

class UserReportFacade
{
    protected const VOTES_PRECISION = 3;

    protected UserReport $userReport;
    protected int $overRateNumber;
    protected int $underRateNumber;

    public function __construct(
        UserReport $userReport,
    ) {
        $this->userReport = $userReport;
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

            if ($vote->getModuleRelativeDiff() <= $this->userReport->getVoteSystem()->getRelativeStep() / 2) {
                $normRates->addItem($movieVote);
            } elseif ($vote->getRelativeDiff() > 0) {
                $overRates->addItem($movieVote);
            } else {
                $underRates->addItem($movieVote);
            }
        }

        return [
            'norm_rates' => $this->getPrettyMovieVotes($normRates),
            'over_rates' => $this->getPrettyMovieVotes($overRates),
            'under_rates' => $this->getPrettyMovieVotes($underRates),
        ];
    }

    protected function getPrettyMovieVotes(MovieVotes $movieVotes): array
    {
        $result = [];

        foreach ($movieVotes as $movieVote) {
            $result[] = $this->getPrettyMovieVote($movieVote);
        }

        return $result;
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