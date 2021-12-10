<?php

declare(strict_types=1);

namespace Areyounormis\ResourceData;

interface ResourceDataRepositoryInterface
{
    public function getByUserId(string $userId): SiteData;
}