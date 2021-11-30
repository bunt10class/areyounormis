<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use DOMElement;
use Kinopoisk\UserMovieDto;
use Kinopoisk\UserMoviesDto;

/**
 * todo систематизировать: подумать как разнести по разным классам получение разных данных
 */
class MovieListParser
{
    public function getUserMoviesDto(DOMElement $moviesList): UserMoviesDto
    {
        $movies = new UserMoviesDto();

        foreach ($moviesList->childNodes as $movieListChild) {
            if (!$movieListChild instanceof DOMElement) {
                continue;
            }

            if ($this->isMovieElement($movieListChild)) {
                $movies->addOne($this->parseMovieData($movieListChild));
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

    protected function parseMovieData(DOMElement $movie): UserMovieDto
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
                        $voteDate = trim($childNode->nodeValue);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_USER_VOTE:
                        $userVote = (int)trim($childNode->nodeValue);
                        break;
                }
            }
        }
        return new UserMovieDto(
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
                        $data['ru_name'] = trim($childNode->nodeValue);
                        $data['link'] = $this->getLinkFromRuName($childNode);
                        break;
                    case ParserHelper::MOVIE_ELEMENT_CLASS_EN_NAME:
                        $data['en_name'] = trim($childNode->nodeValue);
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
                return trim($childNode->getAttribute('href'));
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

            if ($childNode->tagName === 'b') {
                $data['kp_vote'] = (float)trim($childNode->nodeValue);
            }

            if ($childNode->tagName === 'span') {
                if (array_key_exists('vote_number', $data)) {
                    $durationArray = explode(' ', trim($childNode->nodeValue));
                    $data['duration_in_minutes'] = (int)$durationArray[0];
                } else {
                    $data['vote_number'] = (int)trim($childNode->nodeValue, '()');
                }
            }
        }

        return $data;
    }
}