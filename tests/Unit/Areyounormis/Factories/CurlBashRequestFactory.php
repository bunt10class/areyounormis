<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Factories;

class CurlBashRequestFactory
{
    public function getValid(string $endpoint, array $headers): string
    {
        $strings =  [$this->getFirstString($endpoint)];
        foreach ($headers as $key => $value) {
            if (is_string($key) && is_string($value)) {
                $strings[] = $this->getHeaderString($key, $value);
            }
        }

        return implode(PHP_EOL, $strings);
    }

    protected function getFirstString(string $endpoint): string
    {
        return 'curl \'' . $endpoint . '\' \\';
    }

    protected function getHeaderString(string $key, string $value): string
    {
        return '  -H \'' . $key . ': ' . $value . '\' \\';
    }

    public function getInvalidWithoutAnyQuotationMark(): string
    {
        return 'curl';
    }

    public function getInvalidWithoutEndpointClosedQuotationMark(): string
    {
        return 'curl \'some_endpoint \\';
    }

    public function getInvalidWithoutHeaderColon(): string
    {
        return $this->getFirstString('some_endpoint') . PHP_EOL . '  -H \'header_key header_value\' \\';
    }

    public function getInvalidWithoutHeaderClosedQuotationMark(): string
    {
        return $this->getFirstString('some_endpoint') . PHP_EOL . '  -H \'header_key: header_value \\';
    }
}