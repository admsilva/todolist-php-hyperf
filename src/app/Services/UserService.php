<?php

declare(strict_types=1);

namespace App\Services;

use App\Exception\UserException;
use App\Model\Model;
use Hyperf\Collection\Arr;
use Hyperf\Database\Model\Builder;

readonly class UserService extends AbstractService
{
    protected const MODEL_NAME = 'user';

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $email = Arr::get($data, 'email');
        $user = $this->getUserByEmail($email);
        if ($user !== null) {
            throw UserException::userAlreadyExists($user);
        }
        $data = $this->passwordHashed($data);
        return $this->repository->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function updateByUuid(string $uuid, array $data): bool
    {
        $user = $this->getByUuid($uuid);
        $data = $this->passwordHashed($data);
        return $user->update($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function passwordHashed(array $data): array
    {
        $passwordTextPlan = Arr::get($data, 'password');
        if ($passwordTextPlan === null) {
            throw UserException::userPasswordNotFound();
        }
        $passwordHashed = password_hash($passwordTextPlan, PASSWORD_DEFAULT);
        Arr::set($data, 'password', $passwordHashed);
        return $data;
    }

    /**
     * @param string $email
     * @return Builder|Model|null
     */
    private function getUserByEmail(string $email): Builder|Model|null
    {
        $filters = ['email' => $email];
        return $this->repository->first($filters);
    }
}