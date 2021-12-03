<?php

declare(strict_types=1);

namespace Areyounormis\User;

class User
{
    private string $id;
    private ?string $login;

    public function __construct(string $id, ?string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'login' => $this->getLogin(),
        ];
    }
}