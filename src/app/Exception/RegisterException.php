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

class RegisterException extends ServerException
{
    public static function notFound(string $uuid): self
    {
        $message = sprintf('The registry [uuid: %s] does not exist.', $uuid);
        return new self(message: $message, code: 404);
    }
}
