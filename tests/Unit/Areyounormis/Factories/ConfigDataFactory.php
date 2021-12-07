<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

class ConfigDataFactory
{
    public static function getCoefficientConfigData($levels = [], $name = '', $description = ''): array
    {
        $levelData = [];
        foreach ($levels as $level) {
            $levelData[] = [
                'upper_limit' => $level['upper_limit'] ?? 0.0,
                'color' => $level['color'] ?? '',
                'description' => $level['description'] ?? '',
            ];
        }
        return [
            'levels' => $levelData,
            'name' => $name,
            'description' => $description,
        ];
    }
}