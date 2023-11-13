<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Model\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param string $id
     * @return User|null
     */
    public function findById(string $id): ?User
    {
        return User::find($id);
    }

    /**
     * @return Collection
     */
    public function listAll(): Collection
    {
        return User::all();
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        return User::find($id)->update($data);
    }

    /**
     * @param string $id
     * @return bool
     * @throws Exception
     */
    public function delete(string $id): bool
    {
        return User::find($id)->delete();
    }

    /**
     * @param string $email
     * @return Builder|Model|null
     */
    public function getUserByEmail(string $email): Builder|Model|null
    {
        return User::where('email', $email)->first();
    }
}