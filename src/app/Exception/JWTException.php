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

class JWTException extends ServerException
{
    public static function passwordNotMatch(): self
    {
        return new self(message: 'Authentication failed.', code: 400);
    }
}
