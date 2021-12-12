<?php

declare(strict_types=1);

namespace Areyounormis\Service\Report;

use Areyounormis\Domain\Content\ContentVote;
use Areyounormis\Domain\Content\ContentVoteList;
use Areyounormis\Domain\Report\ReportConfig;
use Areyounormis\Domain\Report\UserResourceReport;
use Areyounormis\Service\Content\ContentCollector;
use Areyounormis\Service\Content\ContentVoteListCollector;

class UserResourceReportFacade
{
    protected UserResourceReport $report;
    protected ReportConfig $config;

    public function __construct(
        UserResourceReport $report,
        ReportConfig $config,
    )
    {
        $this->report = $report;
        $this->config = $config;
    }

    public function getPrettyWithTops(): array
    {
        return [
            'user' => $this->report->getUser()->toArray(),
            'votes_system' => $this->report->getVoteSystem()->toArray(),
            'coefficient_values' => $this->getPrettyCoefficientValues(),
            'content_number' => $this->report->getContentVoteList()->count(),
            'content_vote_list' => $this->getPrettyContentVoteListWithRates(),
        ];
    }

    protected function getPrettyCoefficientValues(): array
    {
        $result = [];

        foreach ($this->report->getCoefficientValues()->getItems() as $coefficientValue) {
            $result[] = $coefficientValue->toArray();
        }

        return $result;
    }

    protected function getPrettyContentVoteListWithRates(): array
    {
        $normRates = new ContentVoteList();
        $overRates = new ContentVoteList();
        $underRates = new ContentVoteList();

        $this->collectRates($normRates, $overRates, $underRates);

        return [
            'norm_rates' => $this->getPrettyContentVoteList($normRates),
            'over_rates' => $this->getPrettyContentVoteList($overRates),
            'under_rates' => $this->getPrettyContentVoteList($underRates),
        ];
    }

    protected function collectRates(
        ContentVoteList &$normRates,
        ContentVoteList &$overRates,
        ContentVoteList &$underRates,
    ): void {
        foreach ($this->report->getContentVoteList()->getItems() as $contentVote) {
            $vote = $contentVote->getVote();
            $moduleRelativeDiff = $vote->getModuleRelativeDiff();

            if ($moduleRelativeDiff <= $this->config->getMaxEqualityDiff()) {
                $normRates->addItem($contentVote);
            } elseif ($moduleRelativeDiff >= $this->config->getMinInterestDiff()) {
                $vote->getRelativeDiff() > 0 ? $overRates->addItem($contentVote) : $underRates->addItem($contentVote);
            }
        }

        $normRates = ContentVoteListCollector::sortByContentName($normRates);
        $overRates = ContentVoteListCollector::getTheFirstNumberMaxDiff($overRates, $this->config->getMaxOverRateNumber());
        $underRates = ContentVoteListCollector::getTheFirstNumberMaxDiff($underRates, $this->config->getMaxUnderRateNumber());
    }

    protected function getPrettyContentVoteList(ContentVoteList $list): array
    {
        $result = [];

        foreach ($list->getItems() as $contentVote) {
            $result[] = $this->getPrettyContentVote($contentVote);
        }

        return [
            'number' => $list->count(),
            'content_vote_list' => $result,
        ];
    }

    protected function getPrettyContentVote(ContentVote $contentVote): array
    {
        $vote = $contentVote->getVote();
        $content = $contentVote->getContent();

        return [
            'content' => [
                'name' => ContentCollector::getFullName($content),
                'link' => $content->getLink(),
            ],
            'rate' => [
                'user_vote' => $vote->getUserVote(),
                'resource_vote' => $vote->getResourceVote(),
                'absolute_diff' => $vote->getAbsoluteDiff(),
            ],
        ];
    }
}