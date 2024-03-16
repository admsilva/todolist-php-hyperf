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

namespace App\Repositories\QueryBuilder;

use App\Exception\ModelException;
use App\Model\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Exception;
use Hyperf\Database\Model\Collection;

class QueryBuilderRepositoryStrategy implements RepositoryInterface
{
    protected array $collection;

    protected Model $model;

    /**
     * @throws Exception
     */
    public function setModelName(string $modelName): void
    {
        $modelClass = 'App\\Model\\' . ucfirst($modelName);
        if (class_exists($modelClass) === false) {
            throw ModelException::notFound($modelClass);
        }
        $this->model = new $modelClass();
    }

    public function save(object $entity): bool
    {
        $model = new $this->model((array) $entity);
        return $model->save();
    }

    public function findByUuid(string $uuid): ?Model
    {
        $model = new $this->model();
        return $model->find($uuid);
    }

    public function listAll(): Collection
    {
        $model = new $this->model();
        return $model->all();
    }

    public function create(array $data): Model
    {
        $model = new $this->model();
        return $model->create($data);
    }

    public function update(string $uuid, array $data): bool
    {
        $model = $this->findByUuid($uuid);
        return $model->update($data);
    }

    /**
     * @throws Exception
     */
    public function delete(string $uuid): bool
    {
        $model = $this->findByUuid($uuid);
        return $model->delete();
    }

    public function first(array $filters): ?Model
    {
        $model = new $this->model();
        return $model->where($filters)->first();
    }

    public function where(array $filters): array|Collection
    {
        $model = new $this->model();
        return $model->where($filters)->get();
    }
}
