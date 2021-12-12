<?php

declare(strict_types=1);

namespace Areyounormis\UI\Http;

use Areyounormis\UI\Exceptions\InvalidUserIdRequestException;
use Core\Http\Request;

class UserReportRequest extends Request
{
    /**
     * @throws InvalidUserIdRequestException
     */
    protected function validate(): void
    {
        if (array_key_exists('user_id', $this->requestData) && $this->requestData['user_id']) {
            return;
        }

        throw new InvalidUserIdRequestException('обязателен для заполнения');
    }

    public function getUserId(): string
    {
        return $this->requestData['user_id'];
    }
}