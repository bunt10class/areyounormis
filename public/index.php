<?php

use Areyounormis\Http\WebController;
use Core\Container;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = new Container(require 'dist/definitions.php');

$start = microtime(true);

$request = ServerRequestFactory::fromGlobals();

/** @var WebController $controller */
$controller = $container->get(WebController::class);
$response = match ($request->getUri()->getPath()) {
    '/generate' => $controller->generateUserReport($request),
    '/get' => $controller->getUserReport($request),
    '/delete' => $controller->deleteUserReport($request),
    '/generate-get' => $controller->generateGetUserReport($request),
    default => new HtmlResponse('Invalid path', 404),
};

$processingTime = round(microtime(true) - $start, 2);

$emitter = new SapiEmitter();
$emitter->emit($response->withHeader('X-processing-time', $processingTime));
