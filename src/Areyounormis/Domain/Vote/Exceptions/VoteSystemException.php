<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Vote\Exceptions;

class VoteSystemException extends VoteException
{
    public function __construct()
    {
        parent::__construct('Vote system invalid arguments', 400);
    }
}