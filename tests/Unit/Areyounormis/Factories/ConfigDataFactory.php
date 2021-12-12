<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

class ConfigDataFactory
{
    public static function getCoefficientConfigData(
        array $levels = [],
        mixed $name = '',
        mixed $description = '',
    ): array {
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

    public static function getDefaultCoefficientConfigData(): array
    {
        $level = [
            'upper_limit' => 1,
            'color' => 'some_color',
            'description' => 'some_level_description',
        ];
        return self::getCoefficientConfigData([$level], 'some_name', 'some_description');
    }
}