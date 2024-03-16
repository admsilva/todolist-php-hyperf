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

namespace App\Services;

use App\Exception\RegisterException;
use App\Model\Model;
use App\Repositories\Repository;
use App\Services\Contracts\ServiceCRUDInterface;
use Exception;
use Hyperf\Database\Model\Collection;

abstract readonly class AbstractCRUDService implements ServiceCRUDInterface
{
    public function __construct(protected Repository $repository)
    {
        $this->repository->setModelName(static::MODEL_NAME);
    }

    public function findByUuid(string $uuid): Model
    {
        return $this->getByUuid($uuid);
    }

    public function listAll(): Collection
    {
        return $this->repository->listAll();
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function updateByUuid(string $uuid, array $data): bool
    {
        $register = $this->getByUuid($uuid);
        return $register->update($data);
    }

    /**
     * @throws Exception
     */
    public function deleteById(string $uuid): bool
    {
        $register = $this->getByUuid($uuid);
        return $register->delete();
    }

    public function where(array $filters): array|Collection
    {
        return $this->repository->where($filters);
    }

    protected function getByUuid(string $uuid): Model
    {
        $register = $this->repository->findByUuid($uuid);
        if ($register === null) {
            throw RegisterException::notFound($uuid);
        }
        return $register;
    }
}
