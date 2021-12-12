<?php

declare(strict_types=1);

namespace Areyounormis\Service\Report;

use Core\Queue\Producer;

class ReportJob
{
    protected Producer $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function collectUserReport(string $userId): void
    {
        $this->producer->pushToQueue(UserReportConsumer::class, $userId);
    }
}