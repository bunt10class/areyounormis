<?php

declare(strict_types=1);

namespace Kinopoisk\WebService;

use Kinopoisk\KinopoiskUserMovies;
use Kinopoisk\KinopoiskUserMovieServiceInterface;
use Kinopoisk\WebService\Client\KinopoiskWebClient;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesParser;

/**
 * todo рефакторинг после системы логирования и после решения с отправкой повторных запросов в случае каптчи
 */
class WebUserMoviesService implements KinopoiskUserMovieServiceInterface
{
    protected KinopoiskWebClient $client;
    protected UserMoviesParser $parser;

    public function __construct(
        KinopoiskWebClient $client,
        UserMoviesParser $parser,
    ) {
        $this->client = $client;
        $this->parser = $parser;
    }

    public function getUserMoviesById(int $userId): KinopoiskUserMovies
    {
        $userMovies = new KinopoiskUserMovies();

        $page = 1;
        while (1) {
            $pageUserMovies = $this->getUserMoviesFromPage($userId, $page);
            if (is_null($pageUserMovies)) {
                break;
            }
            if ($pageUserMovies->isEmpty()) {
                break;
            }

            $userMovies->addItems($pageUserMovies->getItems());

            $page++;
        }

        return $userMovies;
    }

    protected function getUserMoviesFromPage(int $userId, int $page): ?KinopoiskUserMovies
    {
        $response = $this->client->getUserVotesByPage($userId, $page);

        if ($response->isCaptcha()) {
            //todo log
//            var_dump('json captcha');
        }

        if ($response->isSuccess() && !$response->isCaptcha()) {
            $parsingPage = $this->parser->parseUserMoviesPage($response->getContent());

            if ($parsingPage->isCaptcha()) {
                //todo log
//                var_dump('html captcha');
            }

            $movies = $parsingPage->getUserMoviesDto();
        }

        return $movies ?? null;
    }
}