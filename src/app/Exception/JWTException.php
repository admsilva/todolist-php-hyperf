<?php

declare(strict_types=1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class JWTException extends ServerException
{
    /**
     * @return self
     */
    public static function passwordNotMatch(): self
    {
        return new self(message: 'Authentication failed.', code: 400);
    }
}