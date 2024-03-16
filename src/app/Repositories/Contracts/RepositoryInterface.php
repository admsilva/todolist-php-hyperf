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

namespace App\Repositories\Contracts;

use App\Model\Model;
use Hyperf\Database\Model\Collection;

interface RepositoryInterface
{
    public function setModelName(string $modelName): void;

    public function findByUuid(string $uuid): ?Model;

    public function listAll(): Collection;

    public function create(array $data): Model;

    public function save(object $entity): bool;

    public function update(string $uuid, array $data): bool;

    public function delete(string $uuid): bool;

    public function first(array $filters): ?Model;

    public function where(array $filters): array|Collection;
}
