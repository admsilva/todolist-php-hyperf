<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class JWTException extends ServerException
{
    public static function passwordNotMatch(): self
    {
        return new self(message: 'Nao foi possivel autenticar.', code: 400);
    }
}