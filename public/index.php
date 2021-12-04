<?php

use Areyounormis\Http\Action;
use Areyounormis\Report\UserReportService;
use Core\Container;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = new Container(require 'dist/definitions.php');

$myUserId = '4023229';

$start = microtime(true);

$action = new Action($container->get(UserReportService::class));
$result = $action->process($myUserId);

echo 'time: ' . round(microtime(true) - $start, 2);

echo "<pre>";
var_dump($result);
echo "</pre>";
