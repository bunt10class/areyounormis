<?php

declare(strict_types=1);

namespace Areyounormis\Report;

use Core\Config;
use Predis\Client;

class ReportRedisRepository
{
    protected const USER_REPORT_KEY = 'user_report';

    protected Client $client;
    protected Config $config;

    public function __construct(
        Client $client,
        Config $config,
    ) {
        $this->client = $client;
        $this->config = $config;
    }

    public function saveUserReport(string $userId, array $report): void
    {
        $key = $this->collectUserReportKey($userId);
        $this->client->set($key, serialize($report));
        $this->client->expire($key, $this->config->get('report_storage_time'));
    }

    public function getUserReport(string $userId): array
    {
        $report = $this->client->get($this->collectUserReportKey($userId));
        if (is_null($report)) {
            return [];
        }

        $report = unserialize($report);
        if (!is_array($report)) {
            return [];
        }

        return $report;
    }

    public function deleteUserReport(string $userId): void
    {
        $this->client->del($this->collectUserReportKey($userId));
    }

    protected function collectUserReportKey(string $userId): string
    {
        return self::USER_REPORT_KEY . '_' . $userId;
    }
}