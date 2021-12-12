<?php

declare(strict_types=1);

namespace Areyounormis\Domain\Coefficient;

class Coefficient
{
    protected string $type;
    protected string $name;
    protected string $description;

    public function __construct(
        string $type,
        string $name,
        string $description,
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}