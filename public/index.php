<?php

use Areyounormis\Http\WebController;
use Core\Container;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = new Container(require 'dist/definitions.php');

//exec("php public/queue-worker.php > storage/logs/queue-worker.log 2>&1 &");

$start = microtime(true);

$request = ServerRequestFactory::fromGlobals();

/** @var WebController $controller */
$controller = $container->get(WebController::class);

$path = $request->getUri()->getPath();
$response = match ($request->getMethod()) {
    'GET' => match ($path) {
        '/' => $controller->index(),
        '/get' => $controller->getUserReport($request),

        '/delete' => $controller->deleteUserReport($request),
        '/collect-get' => $controller->collectUserReport($request),
        default => $controller->getPageNotExist(),
    },
    'POST' => match ($path) {
        '/collect' => $controller->collectUserReportToQueue($request),
        default => $controller->getPageNotExist(),
    },
};

$processingTime = round(microtime(true) - $start, 2);

$emitter = new SapiEmitter();
$emitter->emit($response->withHeader('X-processing-time', $processingTime));
