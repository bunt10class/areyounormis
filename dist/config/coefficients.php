<?php

use Areyounormis\Coefficient\CoefficientHelper;

return [
    CoefficientHelper::NORM_TYPE => [
        'levels' => require 'norm_coefficient_levels.php',
        'name' => 'Коэффициент нормальности',
        'description' => 'Насколько в среднем твои оценки приближены к оценкам портала (от 0 до 1)',
    ],
    CoefficientHelper::OVER_UNDER_RATE_TYPE => [
        'levels' => require 'over_under_rate_coefficient_levels.php',
        'name' => 'Коэффициент пере-недо-оценки',
        'description' => 'Насколько в среднем твои оценки завышены или занижены по отношению к оценкам портала (от -1 до 1)',
    ],
];