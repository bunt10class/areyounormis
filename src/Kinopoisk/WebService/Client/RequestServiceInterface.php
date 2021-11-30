<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

interface RequestServiceInterface
{
    public function getHeaders(): array;
}