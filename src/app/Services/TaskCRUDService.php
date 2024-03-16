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

use App\Exception\UserException;
use App\Model\Model;
use App\Services\Contracts\ServiceCRUDInterface;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Container;

readonly class TaskCRUDService extends AbstractCRUDService implements ServiceCRUDInterface
{
    /**
     * @const string
     */
    final protected const string MODEL_NAME = 'task';

    #[Inject]
    private Container $container;

    public function create(array $data): Model
    {
        $data = $this->setUserUuidAuth($data);
        return $this->repository->create($data);
    }

    public function updateByUuid(string $uuid, array $data): bool
    {
        $data = $this->setUserUuidAuth($data);
        $register = $this->getByUuid($uuid);
        return $register->update($data);
    }

    private function setUserUuidAuth(array $data): array
    {
        $authUser = $this->container->get('user');
        $userUuidAuth = $authUser?->uuid;
        if ($userUuidAuth === null) {
            throw UserException::userPasswordNotFound();
        }
        Arr::set($data, 'user_uuid', $authUser->uuid);
        return $data;
    }
}
