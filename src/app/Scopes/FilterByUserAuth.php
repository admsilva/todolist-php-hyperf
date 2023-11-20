<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Exception\UserException;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Container;

class FilterByUserAuth implements Scope
{
    /**
     * @var Container
     */
    #[Inject]
    private Container $container;

    /**
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $authUser = $this->container->get('user');
        $userUuidAuth = $authUser?->uuid;
        if ($userUuidAuth === null) {
            throw UserException::userPasswordNotFound();
        }
        $builder->where('user_uuid', $userUuidAuth);
    }
}