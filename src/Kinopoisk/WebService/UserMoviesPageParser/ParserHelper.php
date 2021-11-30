<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

class ParserHelper
{
    public const MOVIE_LIST_ELEMENT_TAG = 'div';
    public const MOVIE_LIST_ELEMENT_CLASS = 'profileFilmsList';

    public const VOTE_LIST_ELEMENT_TAG = 'table';
    public const VOTE_LIST_ELEMENT_ID = 'list';
    public const MOVIE_LIST_ELEMENT_TAGS_LOCATION_FROM_VOTE_LIST = ['tr', 'td', 'div', 'div'];

    public const MOVIE_ELEMENT_TAG = 'div';
    public const MOVIE_ELEMENT_CLASSES = ['item', 'item even'];

    public const MOVIE_ELEMENT_ENTITY_TAG = 'div';
    public const MOVIE_ELEMENT_CLASS_INFO = 'info';
    public const MOVIE_ELEMENT_CLASS_RU_NAME = 'nameRus';
    public const MOVIE_ELEMENT_CLASS_EN_NAME = 'nameEng';
    public const MOVIE_ELEMENT_CLASS_RATING = 'rating';
    public const MOVIE_ELEMENT_CLASS_DATE = 'date';
    public const MOVIE_ELEMENT_CLASS_USER_VOTE = 'vote';
}