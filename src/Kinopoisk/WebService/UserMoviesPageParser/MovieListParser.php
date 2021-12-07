<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use DOMElement;
use Kinopoisk\KinopoiskUserMovie;
use Kinopoisk\KinopoiskUserMovies;

/**
 * todo систематизировать: подумать как разнести по разным классам получение разных данных
 */
class MovieListParser
{
    public function getUserMoviesDto(DOMElement $moviesList): KinopoiskUserMovies
    {
        $movies = new KinopoiskUserMovies();

        foreach ($moviesList->childNodes as $movieListChild) {
            if (!$movieListChild instanceof DOMElement) {
                continue;
            }

            if ($this->isMovieElement($movieListChild)) {
                $movies->addItem($this->parseMovieData($movieListChild));
            }
        }

        return $movies;
    }

    protected function isMovieElement(DOMElement $movieElement): bool
    {
        $elementClass = $movieElement->getAttribute('class');

        if (
            $movieElement->nodeName === ParserHelper::MOVIE_ELEMENT_TAG
            && in_array($elementClass, ParserHelper::MOVIE_ELEMENT_CLASSES)
        ) {
            return true;
        }
        return false;
    }

    protected function parseMovieData(DOMElement $movie): KinopoiskUserMovie
    {
        $info = [];

        foreach ($movie->childNodes as $childNode) {
            if (!$childNode instanceof DOMElement) {
                continue;
            }

            if ($childNode->tagName === ParserHelper::MOVIE_ELEMENT_ENTITY_TAG) {
                switch ($childNode->getAttribute('class')) {
                    case ParserHelper::MOVIE_ELEMENT_CLASS_INFO:
                        $info = $this->getInfo($childNode);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_DATE:
                        $voteDate = $this->trimNodeValue($childNode->nodeValue);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_USER_VOTE:
                        $userVote = (int)$this->trimNodeValue($childNode->nodeValue);
                        break;
                }
            }
        }
        return new KinopoiskUserMovie(
            $info['ru_name'] ?? null,
            $info['en_name'] ?? null,
            $info['link'] ?? null,
            $info['kp_vote'] ?? null,
            $info['vote_number'] ?? null,
            $info['duration_in_minutes'] ?? null,
            $voteDate ?? null,
            $userVote ?? null,
        );
    }

    protected function getInfo(DOMElement $movie): array
    {
        $data = [];
        foreach ($movie->childNodes as $childNode) {
            if (!$childNode instanceof DOMElement) {
                continue;
            }

            if ($childNode->tagName === ParserHelper::MOVIE_ELEMENT_ENTITY_TAG) {
                switch ($childNode->getAttribute('class')) {
                    case ParserHelper::MOVIE_ELEMENT_CLASS_RU_NAME:
                        $data['ru_name'] = $this->trimNodeValue($childNode->nodeValue);
                        $data['link'] = $this->getLinkFromRuName($childNode);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_EN_NAME:
                        $data['en_name'] = $this->trimNodeValue($childNode->nodeValue);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_RATING:
                        $rating = $this->getRating($childNode);
                        $data['kp_vote'] = $rating['kp_vote'] ?? null;
                        $data['vote_number'] = $rating['vote_number'] ?? null;
                        $data['duration_in_minutes'] = $rating['duration_in_minutes'] ?? null;
                        break;
                }
            }
        }

        return $data;
    }

    protected function getLinkFromRuName(DOMElement $ruName): ?string
    {
        foreach ($ruName->childNodes as $childNode) {
            if (!$childNode instanceof DOMElement) {
                continue;
            }

            if ($childNode->tagName === 'a') {
                return $this->trimNodeValue($childNode->getAttribute('href'));
            }
        }
        return null;
    }

    protected function getRating(DOMElement $rating): array
    {
        $data = [];

        foreach ($rating->childNodes as $childNode) {
            if (!$childNode instanceof DOMElement) {
                continue;
            }
            $nodeValue = $this->trimNodeValue($childNode->nodeValue);

            if ($childNode->tagName === 'b') {
                $data['kp_vote'] = (float)$nodeValue;
            }

            if ($childNode->tagName === 'span') {
                if (array_key_exists('vote_number', $data)) {
                    $durationArray = explode(' ', $nodeValue);
                    $data['duration_in_minutes'] = (int)$durationArray[0];
                } else {
                    $data['vote_number'] = (int)trim($nodeValue, '()');
                }
            }
        }

        return $data;
    }

    protected function trimNodeValue(string $value): string
    {
        return trim(html_entity_decode($value), " \t\n\r\0\x0B\xC2\xA0");
    }
}