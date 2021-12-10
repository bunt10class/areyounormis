<?php

declare(strict_types=1);

namespace Areyounormis\ResourceData;

use Areyounormis\Movie\Movie;
use Areyounormis\Movie\MovieVote;
use Areyounormis\Movie\MovieVotes;
use Areyounormis\Vote\Exceptions\VoteException;
use Areyounormis\Vote\Vote;
use Areyounormis\Vote\VoteFactory;
use Areyounormis\Vote\Votes;
use Areyounormis\Vote\VoteSystem;
use Areyounormis\Vote\VoteSystemFactory;
use Kinopoisk\KinopoiskHelper;
use Kinopoisk\KinopoiskUserMovie;
use Kinopoisk\KinopoiskUserMovieServiceInterface;

class KinopoiskResourceDataRepository implements ResourceDataRepositoryInterface
{
    protected KinopoiskUserMovieServiceInterface $kinopoiskUserMovieService;

    public function __construct(KinopoiskUserMovieServiceInterface $userMovieService)
    {
        $this->kinopoiskUserMovieService = $userMovieService;
    }

    public function getByUserId(string $userId): SiteData
    {
        // todo $userId not numeric exception - invalid userid
        $userMovies = $this->kinopoiskUserMovieService->getUserMoviesById((int)$userId);

        $voteSystem = VoteSystemFactory::makeForKinopoisk();
        $votes = new Votes();
        $movieVotes = new MovieVotes();

        foreach ($userMovies->getItems() as $userMovie) {
            $vote = $this->tryMakeVote($voteSystem, $userMovie);
            if (!$vote) {
                continue;
            }
            $movieVote = $this->makeMovieVote($vote, $userMovie);

            $votes->addItem($vote);
            $movieVotes->addItem($movieVote);
        }

        return new SiteData(
            $voteSystem,
            $votes,
            $movieVotes,
        );
    }

    protected function makeMovieVote(Vote $vote, KinopoiskUserMovie $userMovie): ?MovieVote
    {
        $movie = new Movie(
            $userMovie->getRuName(),
            $userMovie->getEnName(),
            KinopoiskHelper::HOST . $userMovie->getLink(),
        );

        return new MovieVote($movie, $vote);
    }

    protected function tryMakeVote(VoteSystem $voteSystem, KinopoiskUserMovie $userMovie): ?Vote
    {
        $userVote = $userMovie->getUserVote();
        $siteVote = $userMovie->getKpVote();
        if (
            is_null($userVote) || $userVote < 1 || $userVote > 10 ||
            is_null($siteVote) || $siteVote < 1 || $siteVote > 10
        ) {
            return null;
        }

        try {
            return VoteFactory::make($voteSystem, (float)$userVote, $siteVote);
        } catch (VoteException $exception) {
            //todo log
            return null;
        }
    }
}