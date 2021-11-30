<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest\Parser;

use Areyounormis\ClientRequest\RequestDto;

interface RequestParserInterface
{
    /**
     * @throws InvalidRequestInString
     */
    public function parse(string $parsedString): RequestDto;
}