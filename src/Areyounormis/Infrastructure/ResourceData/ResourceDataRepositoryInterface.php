<?php

declare(strict_types=1);

namespace Areyounormis\Infrastructure\ResourceData;

interface ResourceDataRepositoryInterface
{
    public function getByUserId(string $userId): ResourceDataDto;
}