<?php

use Core\Container;
use Core\Exceptions\InvalidArgumentContainerException;
use Core\Queue\QueueWorker;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = new Container(require 'dist/definitions.php');

$consumers = [];
foreach (require 'dist/consumers.php' as $consumerClassName) {
    try {
        $consumers[] = $container->get($consumerClassName);
    } catch (InvalidArgumentContainerException $exception) {
        // todo log
        echo 'queue-worker error: ' . $exception->getMessage();
        continue;
    }
}

$queueWorker = new QueueWorker($consumers);
$queueWorker->run();
