<?php

declare(strict_types=1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class RegisterException extends ServerException
{
    /**
     * @param string $uuid
     * @return self
     */
    public static function notFound(string $uuid): self
    {
        $message = sprintf('The registry [uuid: %s] does not exist.', $uuid);
        return new self(message: $message, code: 404);
    }
}