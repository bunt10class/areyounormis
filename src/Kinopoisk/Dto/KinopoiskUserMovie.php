<?php

declare(strict_types=1);

namespace Kinopoisk\Dto;

class KinopoiskUserMovie
{
    protected ?string $ruName;
    protected ?string $enName;
    protected ?string $link;
    protected ?float $kpVote;
    protected ?int $voteNumber;
    protected ?int $durationInMinutes;
    protected ?string $voteDate;
    protected ?int $userVote;

    public function __construct(
        ?string $ruName,
        ?string $enName,
        ?string $link,
        ?float $kpVote,
        ?int $voteNumber,
        ?int $durationInMinutes,
        ?string $voteDate,
        ?int $userVote
    ) {
        $this->ruName = $ruName;
        $this->enName = $enName;
        $this->link = $link;
        $this->kpVote = $kpVote;
        $this->voteNumber = $voteNumber;
        $this->durationInMinutes = $durationInMinutes;
        $this->voteDate = $voteDate;
        $this->userVote = $userVote;
    }

    public function getRuName(): ?string
    {
        return $this->ruName;
    }

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getKpVote(): ?float
    {
        return $this->kpVote;
    }

    public function getVoteNumber(): ?int
    {
        return $this->voteNumber;
    }

    public function getDurationInMinutes(): ?int
    {
        return $this->durationInMinutes;
    }

    public function getVoteDate(): ?string
    {
        return $this->voteDate;
    }

    public function getUserVote(): ?int
    {
        return $this->userVote;
    }
}