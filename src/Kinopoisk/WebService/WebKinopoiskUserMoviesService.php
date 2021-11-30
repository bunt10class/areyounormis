<?php

declare(strict_types=1);

namespace Kinopoisk\WebService;

use GuzzleHttp\Exception\GuzzleException;
use Kinopoisk\UserMoviesDto;
use Kinopoisk\KinopoiskUserMovieServiceInterface;
use Kinopoisk\WebService\Client\KinopoiskWebClient;
use Kinopoisk\WebService\UserMoviesPageParser\UserMoviesParser;

/**
 * todo рефакторинг после системы логирования и после решения с отправкой повторных запросов в случае каптчи
 */
class WebKinopoiskUserMoviesService implements KinopoiskUserMovieServiceInterface
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

    /**
     * @throws GuzzleException
     */
    public function getUserMoviesById(int $userId): UserMoviesDto
    {
        $userMovies = new UserMoviesDto();

        $page = 1;
        while (1) {
            $pageUserMovies = $this->getUserMoviesFromPage($userId, $page);
            if (is_null($pageUserMovies)) {
                break;
            }
            if ($pageUserMovies->isEmpty()) {
                break;
            }

            $userMovies->addMany($pageUserMovies->getUserMovies());

            $page++;
        }

        return $userMovies;
    }

    /**
     * @throws GuzzleException
     */
    protected function getUserMoviesFromPage(int $userId, int $page): ?UserMoviesDto
    {
        $response = $this->client->getUserVotesByPage($userId, $page);

        if ($response->isCaptcha()) {
            //todo log
            var_dump('json captcha');
        }

        if ($response->isSuccess() && !$response->isCaptcha()) {
            $parsingPage = $this->parser->parseUserMoviesPage($response->getContent());

            if ($parsingPage->isCaptcha()) {
                //todo log
                var_dump('html captcha');
            }

            $movies = $parsingPage->getUserMoviesDto();
        }

        return $movies ?? null;
    }
}