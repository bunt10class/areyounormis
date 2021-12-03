<?php

use Areyounormis\Http\Action;
use Areyounormis\Report\UserReportService;
use Core\Container;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$container = new Container(require 'dist/definitions.php');

$myUserId = '4023229';
$action = new Action($container->get(UserReportService::class), $container);
$result = $action->process($myUserId);

echo "<pre>";
var_dump($result);
echo "</pre>";
