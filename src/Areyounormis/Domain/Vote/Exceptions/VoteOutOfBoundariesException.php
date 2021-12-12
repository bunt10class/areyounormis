<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote\Exceptions;

class VoteOutOfBoundariesException extends VoteException
{
    public function __construct()
    {
        parent::__construct('Vote is outside of vote system boundaries', 400);
    }
}