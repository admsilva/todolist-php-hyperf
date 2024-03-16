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

namespace App\Repositories;

use App\Model\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Hyperf\Database\Model\Collection;

class Repository implements RepositoryInterface
{
    public function __construct(protected RepositoryInterface $repository)
    {
    }

    public function setModelName(string $modelName): void
    {
        $this->repository->setModelName($modelName);
    }

    public function save(object $entity): bool
    {
        return $this->repository->save($entity);
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->repository->findByUuid($uuid);
    }

    public function listAll(): Collection
    {
        return $this->repository->listAll();
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(string $uuid, array $data): bool
    {
        return $this->repository->update($uuid, $data);
    }

    public function delete(string $uuid): bool
    {
        return $this->repository->delete($uuid);
    }

    public function first(array $filters): ?Model
    {
        return $this->repository->first($filters);
    }

    public function where(array $filters): array|Collection
    {
        return $this->repository->where($filters);
    }
}
