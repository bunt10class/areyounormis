<?php

declare(strict_types=1);

namespace Areyounormis\ClientRequest;

class ClientRequest
{
    protected string $endpoint;
    protected array $headers;

    public function __construct(string $endpoint, array $headers)
    {
        $this->endpoint = $endpoint;
        $this->headers = $headers;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}