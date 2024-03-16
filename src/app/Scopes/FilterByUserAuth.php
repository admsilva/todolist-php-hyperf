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

namespace App\Scopes;

use App\Exception\UserException;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Container;

class FilterByUserAuth implements Scope
{
    #[Inject]
    private Container $container;

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
