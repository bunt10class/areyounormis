<?php

declare(strict_types=1);

namespace Areyounormis\UserRate\Exceptions;

class UserRateVoteException extends UserRateException
{
    public function __construct()
    {
        parent::__construct('Vote is outside of boundaries', 400);
    }
}