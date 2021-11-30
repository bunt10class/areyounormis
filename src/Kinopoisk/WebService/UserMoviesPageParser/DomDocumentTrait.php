<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\UserMoviesPageParser;

use DOMDocument;
use DOMElement;

trait DomDocumentTrait
{
    private string $controlBytesForRussian = "\xEF\xBB\xBF";

    public function getDomDocument(string $html): DOMDocument
    {
        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($this->controlBytesForRussian . $html, LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();

        return $dom;
    }

    public function getDomElement(string $html = '', string $tag = 'div'): DOMElement
    {
        return $this->getDomDocument('<' . $tag . '>' . $html . '</' . $tag . '>')->firstElementChild;
    }
}