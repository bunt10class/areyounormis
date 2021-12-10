<?php

return [
    'redis' => [
        'host' => 'redis',
    ],
    'report_storage_time' => 3600,
    'queue' => [
        'report' => 'report_queue',
    ],
    'coefficients' => require 'config/coefficients.php',
];