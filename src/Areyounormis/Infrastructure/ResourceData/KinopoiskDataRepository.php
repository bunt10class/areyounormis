<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\ResourceData;

use Areyounormis\Domain\Content\Content;
use Areyounormis\Domain\Content\ContentVote;
use Areyounormis\Domain\Content\ContentVoteList;
use Areyounormis\Domain\Vote\Vote;
use Areyounormis\Domain\Vote\VoteList;
use Areyounormis\Domain\Vote\VoteSystem;
use Areyounormis\Domain\Vote\Exceptions\VoteException;
use Areyounormis\Domain\Vote\Factories\VoteFactory;
use Areyounormis\Domain\Vote\Factories\VoteSystemFactory;
use Kinopoisk\Helpers\KinopoiskHelper;
use Kinopoisk\Dto\KinopoiskUserMovie;
use Kinopoisk\KinopoiskUserMovieServiceInterface;

class KinopoiskDataRepository implements ResourceDataRepositoryInterface
{
    protected KinopoiskUserMovieServiceInterface $kinopoiskUserMovieService;

    public function __construct(KinopoiskUserMovieServiceInterface $userMovieService)
    {
        $this->kinopoiskUserMovieService = $userMovieService;
    }

    public function getByUserId(string $userId): ResourceDataDto
    {
        // todo $userId not numeric exception - invalid userid
        $userMovies = $this->kinopoiskUserMovieService->getUserMoviesById((int)$userId);

        $voteSystem = VoteSystemFactory::makeForKinopoisk();
        $voteList = new VoteList();
        $contentVoteList = new ContentVoteList();

        foreach ($userMovies->getItems() as $userMovie) {
            $vote = $this->tryMakeVote($voteSystem, $userMovie);
            if (!$vote) {
                continue;
            }
            $contentVote = $this->makeContentVote($vote, $userMovie);

            $voteList->addItem($vote);
            $contentVoteList->addItem($contentVote);
        }

        return new ResourceDataDto(
            $voteSystem,
            $voteList,
            $contentVoteList,
        );
    }

    protected function makeContentVote(Vote $vote, KinopoiskUserMovie $userMovie): ?ContentVote
    {
        $content = new Content(
            $userMovie->getRuName(),
            $userMovie->getEnName(),
            KinopoiskHelper::HOST . $userMovie->getLink(),
        );

        return new ContentVote($content, $vote);
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