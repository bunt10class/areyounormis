<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use DOMDocument;
use DOMElement;
use DOMNodeList;

class CaptchaDetector
{
    private const CAPTCHA_PRESENCE_CRITERIAS_BY_TAGS = [
        'title' => [
            'value' => 'Ой',
        ],
        'script' => [
            'attributes' => [
                'src' => 'captcha',
            ],
        ],
    ];

    public function isCaptcha(DOMDocument $dom): bool
    {
        foreach (self::CAPTCHA_PRESENCE_CRITERIAS_BY_TAGS as $tag => $properties) {
            $elements = $dom->getElementsByTagName($tag);

            if ($this->isInElements($elements, $properties)) {
                return true;
            }
        }

        return false;
    }

    protected function isInElements(DOMNodeList $elements, array $properties): bool
    {
        /** @var DOMElement $element */
        foreach ($elements as $element) {
            if (
                array_key_exists('value', $properties)
                && $this->isInElementsValues($element, $properties['value'])
            ) {
                return true;
            }

            if (
                array_key_exists('attributes', $properties)
                && $this->isInElementsAttributes($element, $properties['attributes'])
            ) {
                return true;
            }
        }

        return false;
    }

    protected function isInElementsValues(DOMElement $element, string $value): bool
    {
        if (str_contains($element->nodeValue, $value)) {
            return true;
        }

        return false;
    }

    protected function isInElementsAttributes(DOMElement $element, array $attributes): bool
    {
        foreach ($attributes as $attribute => $value) {
            if (str_contains($element->getAttribute($attribute), $value)) {
                return true;
            }
        }

        return false;
    }
}