<?php

declare(strict_types=1);

namespace App\Services;

use App\Exception\UserException;
use App\Model\Model;
use App\Services\Contracts\ServiceInterface;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Container;

readonly class TaskService extends AbstractService implements ServiceInterface
{
    /**
     * @var Container
     */
    #[Inject]
    private Container $container;

    /**
     * @const string
     */
    final protected const MODEL_NAME = 'task';

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $data = $this->setUserUuidAuth($data);
        return $this->repository->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return bool
     */
    public function updateByUuid(string $uuid, array $data): bool
    {
        $data = $this->setUserUuidAuth($data);
        $register = $this->getByUuid($uuid);
        return $register->update($data);
    }

    /**
     * @param array $data
     * @return array
     */
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