<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Model\Model;
use Hyperf\Database\Model\Collection;

interface ServiceCRUDInterface
{
    /**
     * @param string $uuid
     * @return Model
     */
    public function findByUuid(string $uuid): Model;

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
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function updateByUuid(string $uuid, array $data): bool;

    /**
     * @param string $uuid
     * @return bool
     */
    public function deleteById(string $uuid): bool;
}