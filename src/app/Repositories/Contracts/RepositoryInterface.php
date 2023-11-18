<?php

namespace App\Repositories\Contracts;

use App\Model\Model;
use Hyperf\Database\Model\Collection;

interface RepositoryInterface
{
    /**
     * @param string $modelName
     * @return void
     */
    public function setModelName(string $modelName): void;

    /**
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model;

    /**
     * @return Collection
     */
    public function listAll(): Collection;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param object $entity
     * @return bool
     */
    public function save(object $entity): bool;

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function update(string $uuid, array $data): bool;

    /**
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool;

    /**
     * @param array $filters
     * @return Model|null
     */
    public function first(array $filters): ?Model;
}