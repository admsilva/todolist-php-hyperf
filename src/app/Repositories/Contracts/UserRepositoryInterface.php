<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Model\User;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

interface UserRepositoryInterface
{
    /**
     * @param string $id
     * @return User|null
     */
    public function findById(string $id): ?User;

    /**
     * @return Collection
     */
    public function listAll(): Collection;

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool;

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;

    public function getUserByEmail(string $email): Builder|Model|null;
}