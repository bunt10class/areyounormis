<?php

declare(strict_types=1);

namespace Areyounormis\Movie;

class Movie
{
    protected ?string $ruName;
    protected ?string $enName;
    protected ?string $link;

    public function __construct(?string $ruName, ?string $enName, ?string $link)
    {
        $this->ruName = $ruName;
        $this->enName = $enName;
        $this->link = $link;
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
}