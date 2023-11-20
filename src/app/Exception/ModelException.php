<?php

declare(strict_types=1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class ModelException extends ServerException
{
    /**
     * @param string $modelClass
     * @return self
     */
    public static function notFound(string $modelClass): self
    {
        $message = sprintf('The class [model: %s] does not exist.', $modelClass);
        return new self(message: $message, code: 404);
    }
}