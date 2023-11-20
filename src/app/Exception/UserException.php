<?php

declare(strict_types=1);

namespace App\Exception;

use App\Model\User;
use Hyperf\Server\Exception\ServerException;

class UserException extends ServerException
{
    /**
     * @param User $user
     * @return self
     */
    public static function userAlreadyExists(User $user): self
    {
        $message = sprintf('The user [email: %s] already exists.', $user->email);
        return new self(message: $message, code: 400);
    }

    /**
     * @param string $email
     * @return self
     */
    public static function userEmailNotFound(string $email): self
    {
        $message = sprintf('The user [email: %s] does not exist.', $email);
        return new self(message: $message, code: 400);
    }

    /**
     * @return self
     */
    public static function userPasswordNotFound(): self
    {
        return new self(message: 'Password has not been set.', code: 400);
    }
}