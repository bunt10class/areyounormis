<?php

declare(strict_types=1);

namespace Kinopoisk\WebService\Client;

use Psr\Http\Message\ResponseInterface;

class WebResponseProcessor
{
    private const CAPTCHA_PRESENCE_CRITERIAS = [
        'type' => 'captcha',
    ];

    public function process(ResponseInterface $response): WebResponse
    {
        $content = $response->getBody()->getContents();

        $isSuccess = $response->getStatusCode() === 200;
        //todo log

        $isCaptcha = false;
        if ($this->isCaptcha($content)) {
            //todo log
            $isCaptcha = true;
        }

        return new WebResponse($isSuccess, $isCaptcha, $content);
    }

    protected function isCaptcha(string $content): bool
    {
        $content = (array)json_decode($content);

        foreach (self::CAPTCHA_PRESENCE_CRITERIAS as $field => $value) {
            if (
                array_key_exists($field, $content)
                && is_string($content[$field])
                && str_contains($content[$field], $value)
            ) {
                return true;
            }
        }

        return false;
    }
}