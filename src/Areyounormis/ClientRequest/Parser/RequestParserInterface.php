<?php

declare(strict_types=1);

namespace Areyounormis\UserMovie\Models\ClientRequest\Parser;

use Areyounormis\UserMovie\Models\ClientRequest\RequestDto;

interface RequestParserInterface
{
    /**
     * @throws InvalidRequestInString
     */
    public function parse(string $parsedString): RequestDto;
}