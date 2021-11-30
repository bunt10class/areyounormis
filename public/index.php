<?php

use Areyounormis\UserMovie\Models\Http\Controller;
use Core\Config;
use Core\Container;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$config = new Config(require 'dist/parameters.php');
$container = new Container(require 'dist/definitions.php');

$myUserId = 4023229;

/** @var Controller $controller */
$controller = $container->get(Controller::class);
echo $controller->process($myUserId);