<?php

declare(strict_types=1);

namespace Areyounormis\Coefficient;

class Coefficient
{
    protected string $type;
    protected string $name;
    protected string $description;
    protected float $value;
    protected string $levelColor;
    protected string $levelDescription;

    public function __construct(
        string $type,
        string $name,
        string $description,
        float $value,
        string $levelColor = CoefficientHelper::DEFAULT_LEVEL_COLOR,
        string $levelDescription = '',
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->value = $value;
        $this->levelColor = $levelColor;
        $this->levelDescription = $levelDescription;
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

    public function getValue(): float
    {
        return $this->value;
    }

    public function getLevelColor(): string
    {
        return $this->levelColor;
    }

    public function getLevelDescription(): string
    {
        return $this->levelDescription;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'value' => $this->getValue(),
            'level_color' => $this->getLevelColor(),
            'level_description' => $this->getLevelDescription(),
        ];
    }
}