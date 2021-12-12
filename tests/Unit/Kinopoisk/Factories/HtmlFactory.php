<?php

declare(strict_types=1);

namespace Tests\Unit\Kinopoisk\Factories;

class HtmlFactory
{
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