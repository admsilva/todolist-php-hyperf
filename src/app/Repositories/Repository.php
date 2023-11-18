<?php

namespace App\Repositories;

use App\Model\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Hyperf\Database\Model\Collection;

class Repository implements RepositoryInterface
{
    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(protected RepositoryInterface $repository)
    {
    }

    /**
     * @param string $modelName
     * @return void
     */
    public function setModelName(string $modelName): void
    {
        $this->repository->setModelName($modelName);
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function save(object $entity): bool
    {
        return $this->repository->save($entity);
    }

    /**
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->repository->findByUuid($uuid);
    }

    /**
     * @return Collection
     */
    public function listAll(): Collection
    {
        return $this->repository->listAll();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function update(string $uuid, array $data): bool
    {
        return $this->repository->update($uuid, $data);
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool
    {
        return $this->repository->delete($uuid);
    }

    public function first(array $filters): ?Model
    {
        return $this->repository->first($filters);
    }
}