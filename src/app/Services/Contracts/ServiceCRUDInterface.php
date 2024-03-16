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

namespace App\Services\Contracts;

use App\Model\Model;
use Hyperf\Database\Model\Collection;

interface ServiceCRUDInterface
{
    public function findByUuid(string $uuid): Model;

    public function listAll(): Collection;

    public function create(array $data): Model;

    public function updateByUuid(string $uuid, array $data): bool;

    public function deleteById(string $uuid): bool;
}
