<?php

namespace App\Exception;

use App\Model\User;
use Hyperf\Server\Exception\ServerException;

class UserException extends ServerException
{
    public static function userNotFound(string $id): self
    {
        $message = sprintf('O usuario [id: %s] nao existe.', $id);
        return new self(
            message: $message,
            code: 404
        );
    }

    public static function userAlreadyExists(User $user): self
    {
        $message = sprintf('Usuario [email: %s] ja existe.', $user->email);
        return new self(
            message: $message,
            code: 400
        );
    }

    public static function userPasswordNotFound(): self
    {
        return new self(
            message: 'Senha nao foi definida.',
            code: 400
        );
    }
}