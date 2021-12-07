<?php

declare(strict_types=1);

namespace Areyounormis\Movie;

class MovieHelper
{
    protected const DEFAULT_FULL_NAME = 'Без названия';

    public static function getFullName(Movie $movie): string
    {
        $enName = $movie->getEnName();
        if ($ruName = $movie->getRuName()) {
            $fullName = $ruName;

            if ($enName) {
                $fullName .= ' (' . $enName . ')';
            }
        } else {
            if ($enName) {
                $fullName = $enName;
            } else {
                $fullName = self::DEFAULT_FULL_NAME;
            }
        }

        return $fullName;
    }
}