<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Mocks;

use DOMDocument;
use DOMElement;
use Kinopoisk\WebService\UserMoviesPageParser\DomDocumentTrait;
use Kinopoisk\WebService\UserMoviesPageParser\MovieListSearcher;

class MovieListSearcherMock extends MovieListSearcher
{
    use DomDocumentTrait;

    protected ?DOMElement $movieList;

    public function __construct(bool $isMovieList = true)
    {
        if ($isMovieList) {
            $this->movieList = $this->getDomElement('');
        } else {
            $this->movieList = null;
        }
    }

    public function findByClass(DOMDocument $dom): ?DOMElement
    {
        return $this->movieList;
    }
}