<?php

declare(strict_types=1);

namespace App\Services;

use App\Exception\UserException;
use App\Model\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Hyperf\Collection\Arr;
use Hyperf\Database\Model\Collection;

readonly class UserService
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @param string $id
     * @return User
     */
    public function findUserById(string $id): User
    {
        return $this->getUserById($id);
    }

    /**
     * @return Collection
     */
    public function listAllUsers(): Collection
    {
        return $this->userRepository->listAll();
    }

    /**
     * @param array $data
     * @return User
     */
    public function createNewUser(array $data): User
    {
        $email = Arr::get($data, 'email');
        $user = $this->userRepository->getUserByEmail($email);
        if ($user !== null) {
            throw UserException::userAlreadyExists($user);
        }
        $data = $this->passwordHashed($data);
        return $this->userRepository->create($data);
    }

    /**
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function updateUserById(string $id, array $data): bool
    {
        $user = $this->getUserById($id);
        $data = $this->passwordHashed($data);
        return $user->update($data);
    }

    /**
     * @param string $id
     * @return bool
     * @throws Exception
     */
    public function deleteUserById(string $id): bool
    {
        $user = $this->getUserById($id);
        return $user->delete();
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
     * @param string $id
     * @return User
     */
    private function getUserById(string $id): User
    {
        $user = $this->userRepository->findById($id);
        if ($user === null) {
            throw UserException::userNotFound($id);
        }
        return $user;
    }
}