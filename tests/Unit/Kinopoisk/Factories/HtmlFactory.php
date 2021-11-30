<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Factories;

use Faker\Factory;
use Faker\Generator;

class HtmlFactory
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function collectElement(
        string $tag,
        array $attributes = [],
        string $inside = '',
        $pairedTag = true
    ): string {
        $result = '<' . $tag;

        foreach ($attributes as $field => $value) {
            $result .= ' ' . $field . '="' . $value . '"';
        }

        $result .= '>';

        if ($pairedTag) {
            $result .= $inside . '</' . $tag . '>';
        }

        return $result;
    }
}