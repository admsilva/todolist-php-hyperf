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

namespace App\Services;

use App\Exception\JWTException;
use App\Exception\UserException;
use App\Repositories\Contracts\RepositoryInterface;
use Firebase\JWT\JWT;

class LoginService
{
    private string $jwtSecretKey;

    public function __construct(private readonly RepositoryInterface $repository)
    {
        $this->jwtSecretKey = getenv('JWT_SECRET_KEY');
        $this->repository->setModelName('user');
    }

    public function login(string $email, string $password): array
    {
        $filters = ['email' => $email];
        $user = $this->repository->first($filters);

        if ($user === null) {
            throw UserException::userEmailNotFound($email);
        }

        if (password_verify($password, $user->password) === false) {
            throw JWTException::passwordNotMatch();
        }

        $tokenPayload = [
            'uuid' => $user->uuid,
            'email' => $user->email,
            'iat' => time(),
        ];

        $token = JWT::encode($tokenPayload, $this->jwtSecretKey, 'HS256');

        return ['token' => $token];
    }
}
