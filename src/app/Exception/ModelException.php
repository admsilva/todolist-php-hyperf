<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class ModelException extends ServerException
{
    public static function notFound(string $modelClass): self
    {
        $message = sprintf('A classe [model: %s] nao existe.', $modelClass);
        return new self(message: $message, code: 404);
    }
}