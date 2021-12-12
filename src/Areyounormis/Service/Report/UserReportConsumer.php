<?php

declare(strict_types=1);

namespace Areyounormis\Service\Report;

use Core\Queue\ConsumerMain;
use Predis\Client;

class UserReportConsumer extends ConsumerMain
{
    protected UserReportService $service;

    public function __construct(
        UserReportService $service,
        Client $client,
    ) {
        $this->service = $service;

        parent::__construct($client);
    }

    protected function process(string $userId): void
    {
        $userReportFacade = $this->service->collectFacade($userId);
        $this->service->save($userId, $userReportFacade->getPrettyWithTops());
    }
}