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

use App\Model\User;
use Hyperf\Server\Exception\ServerException;

class UserException extends ServerException
{
    public static function userAlreadyExists(User $user): self
    {
        $message = sprintf('The user [email: %s] already exists.', $user->email);
        return new self(message: $message, code: 400);
    }

    public static function userEmailNotFound(string $email): self
    {
        $message = sprintf('The user [email: %s] does not exist.', $email);
        return new self(message: $message, code: 400);
    }

    public static function userPasswordNotFound(): self
    {
        return new self(message: 'Password has not been set.', code: 400);
    }
}
