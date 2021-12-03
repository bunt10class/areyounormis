<?php

use Areyounormis\Coefficient\CoefficientHelper;

return [
    CoefficientHelper::NORM_TYPE => [
        'levels' => require 'norm_coefficient_levels.php',
        'description' => '',
    ],
    CoefficientHelper::OVER_UNDER_RATE_TYPE => [
        'levels' => require 'over_under_rate_coefficient_levels.php',
        'description' => '',
    ],
];