<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class RegisterException extends ServerException
{
    public static function notFound(string $uuid): self
    {
        $message = sprintf('O registro [uuid: %s] nao existe.', $uuid);
        return new self(message: $message, code: 404);
    }
}