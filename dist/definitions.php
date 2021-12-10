<?php

use Core\Config;
use Core\Container;

return [
    /**
     * core
     */
    Config::class => function () {
        return new Config(require 'dist/parameters.php');
    },

    /**
     * areyounormis
     */
    \Core\Template\TemplateRenderer::class => function() {
        return new \Core\Template\TemplateRenderer('templates');
    },
    \Areyounormis\ClientRequest\Parser\RequestParserInterface::class => function (Container $container) {
        return $container->get(\Areyounormis\ClientRequest\Parser\CurlBashRequestParser::class);
    },
    \Kinopoisk\WebService\Client\RequestServiceInterface::class => function (Container $container) {
        return $container->get(\Areyounormis\ClientRequest\RequestService::class);
    },
    \Areyounormis\ResourceData\ResourceDataRepositoryInterface::class => function (Container $container) {
        return $container->get(\Areyounormis\ResourceData\KinopoiskResourceDataRepository::class);
    },

    /**
     * kinopoisk
     */
    \Kinopoisk\KinopoiskUserMovieServiceInterface::class => function (Container $container) {
        return $container->get(\Kinopoisk\WebService\WebUserMoviesService::class);
    },

    /**
     * external
     */
    \Predis\Client::class => function (Container $container) {
        /** @var Config $config */
        $config = $container->get(Config::class);
        return new \Predis\Client([
            'host' => $config->get('redis.host'),
        ]);
    },
];