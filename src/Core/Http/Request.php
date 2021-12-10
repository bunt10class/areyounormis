<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Exceptions\RequestException;
use Laminas\Diactoros\ServerRequest;

abstract class Request
{
    protected array $requestData;

    /**
     * @throws RequestException
     */
    public function __construct(ServerRequest $request)
    {
        $this->setRequestData($request);

        $this->validate();
    }

    public function setRequestData(ServerRequest $request): void
    {
        if ($request->getMethod() === 'GET') {
            $requestData = $request->getQueryParams();
        } else {
            $requestData = (array)$request->getParsedBody();
        }

        $this->requestData = $requestData;
    }

    /**
     * @throws RequestException
     */
    abstract protected function validate(): void;
}