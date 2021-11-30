<?php

use Core\Container;

return [
    /**
     * areyounormis
     */
    \Areyounormis\UserMovie\Models\ClientRequest\Parser\RequestParserInterface::class => function () {
        return new \Areyounormis\UserMovie\Models\ClientRequest\Parser\CurlBashRequestParser();
    },

    /**
     * kinopoisk
     */
    \Kinopoisk\KinopoiskUserMovieServiceInterface::class => function (Container $container) {
        return $container->get(\Kinopoisk\WebUserMoviesService::class);
    },
    \Kinopoisk\WebService\Client\RequestServiceInterface::class => function (Container $container) {
        return $container->get(\Areyounormis\UserMovie\Models\ClientRequest\RequestService::class);
    },

    /**
     * external
     */
    \Predis\Client::class => function () {
        return new \Predis\Client([
            'host' => 'redis',
        ]);
    },
];