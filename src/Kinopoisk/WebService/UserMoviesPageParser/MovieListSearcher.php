<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use DOMDocument;
use DOMElement;

class MovieListSearcher
{
    public function findByClass(DOMDocument $dom): ?DOMElement
    {
        $elements = $dom->getElementsByTagName(ParserHelper::MOVIE_LIST_ELEMENT_TAG);

        return $this->findFromElementsByClass($elements);
    }
    
    protected function findFromElementsByClass(iterable $elements): ?DOMElement
    {
        foreach ($elements as $element) {
            if (!$element instanceof DOMElement) {
                continue;
            }
            if ($element->getAttribute('class') === ParserHelper::MOVIE_LIST_ELEMENT_CLASS) {
                return $element;
            }
        }

        return null;
    }

    /**
     * второй способ поиска элемента MovieList (не используется)
     * todo проверить какой их способов быстрее
     */
    public function findByChildren(DOMDocument $dom): ?DOMElement
    {
        $tableElement = $dom->getElementById(ParserHelper::VOTE_LIST_ELEMENT_ID);
        if (!$tableElement) {
            return null;
        }

        $elements = [$tableElement];
        foreach (ParserHelper::MOVIE_LIST_ELEMENT_TAGS_LOCATION_FROM_VOTE_LIST as $tag) {
            $elements = $this->getElementsChildrenWithTag($elements, $tag);
        }

        return $this->findFromElementsByClass($elements);
    }

    protected function getElementsChildrenWithTag(array $elements, string $tag): array
    {
        $children = [];
        foreach ($elements as $element) {
            if ($element instanceof DOMElement) {
                foreach ($element->childNodes as $childNode) {
                    if ($childNode->nodeName === $tag) {
                        $children[] = $childNode;
                    }
                }
            }
        }
        return $children;
    }
}