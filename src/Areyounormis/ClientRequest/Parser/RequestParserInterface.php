<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest\Parser;

use Areyounormis\ClientRequest\ClientRequest;

interface RequestParserInterface
{
    /**
     * @throws InvalidRequestInString
     */
    public function parse(string $parsedString): ClientRequest;
}