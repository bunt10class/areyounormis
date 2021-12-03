<?php

declare(strict_types=1);

namespace Areyounormis\SiteData;

interface SiteDataServiceInterface
{
    public function getByUserId(string $userId): SiteData;
}