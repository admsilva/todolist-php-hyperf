<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class ModelException extends ServerException
{
    public static function notFound(string $modelClass): self
    {
        $message = sprintf('The class [model: %s] does not exist.', $modelClass);
        return new self(message: $message, code: 404);
    }
}
