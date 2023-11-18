<?php

namespace App\Services;

use App\Exception\RegisterException;
use App\Model\Model;
use App\Repositories\Repository;
use Exception;
use Hyperf\Database\Model\Collection;

abstract readonly class AbstractService
{
    /**
     * @param Repository $repository
     */
    public function __construct(protected Repository $repository)
    {
        $this->repository->setModelName(static::MODEL_NAME);
    }

    /**
     * @param string $uuid
     * @return Model
     */
    public function findByUuid(string $uuid): Model
    {
        return $this->getByUuid($uuid);
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
    public function updateByUuid(string $uuid, array $data): bool
    {
        $register = $this->getByUuid($uuid);
        return $register->update($data);
    }

    /**
     * @param string $uuid
     * @return bool
     * @throws Exception
     */
    public function deleteById(string $uuid): bool
    {
        $register = $this->getByUuid($uuid);
        return $register->delete();
    }

    /**
     * @param string $uuid
     * @return Model
     */
    protected function getByUuid(string $uuid): Model
    {
        $register = $this->repository->findByUuid($uuid);
        if ($register === null) {
            throw RegisterException::notFound($uuid);
        }
        return $register;
    }
}