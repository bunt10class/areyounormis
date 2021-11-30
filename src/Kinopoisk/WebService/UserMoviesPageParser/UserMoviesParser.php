<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

class UserMoviesParser
{
    use DomDocumentTrait;

    protected CaptchaDetector $captchaDetector;
    protected MovieListSearcher $movieListSearcher;
    protected MovieListParser $movieListParser;

    public function __construct(
        CaptchaDetector $captchaDetector,
        MovieListSearcher $movieListSearcher,
        MovieListParser $movieListParser,
    ) {
        $this->captchaDetector = $captchaDetector;
        $this->movieListSearcher = $movieListSearcher;
        $this->movieListParser = $movieListParser;
    }

    public function parseUserMoviesPage(string $html): UserMoviesPage
    {
        $dom = $this->getDomDocument($html);

        $isCaptcha = $this->captchaDetector->isCaptcha($dom);

        if (!$isCaptcha && $movieList = $this->movieListSearcher->findByClass($dom)) {
            $movies = $this->movieListParser->getUserMoviesDto($movieList);
        }

        return new UserMoviesPage($isCaptcha, $movies ?? null);
    }
}