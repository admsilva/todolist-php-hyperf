<?php

namespace App\Repositories\QueryBuilder;

use App\Model\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Exception;
use Hyperf\Database\Model\Collection;

class QueryBuilderRepositoryStrategy implements RepositoryInterface
{
    /**
     * @var array
     */
    protected array $collection;
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param string $modelName
     * @return void
     * @throws Exception
     */
    public function setModelName(string $modelName): void
    {
        $modelString = 'App\\Model\\' . ucfirst($modelName);

        if (class_exists($modelString) === false) {
            throw new Exception("Class {$modelString} doesn`t exists");
        }

        $this->model = new $modelString();
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function save(object $entity): bool
    {
        $model = new $this->model((array) $entity);
        return $model->save();
    }

    /**
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        $model = new $this->model();
        return $model->find($uuid);
    }

    /**
     * @return Collection
     */
    public function listAll(): Collection
    {
        $model = new $this->model();
        return $model->all();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $model = new $this->model();
        return $model->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function update(string $uuid, array $data): bool
    {
        $model = $this->findByUuid($uuid);
        return $model->update($data);
    }

    /**
     * @param string $uuid
     * @return bool
     * @throws Exception
     */
    public function delete(string $uuid): bool
    {
        $model = $this->findByUuid($uuid);
        return $model->delete();
    }

    /**
     * @param array $filters
     * @return Model|null
     */
    public function first(array $filters): ?Model
    {
        $model = new $this->model();
        return $model->where($filters)->first();
    }
}