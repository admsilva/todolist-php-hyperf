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
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\QueryBuilder\QueryBuilderRepositoryStrategy;

return [RepositoryInterface::class => QueryBuilderRepositoryStrategy::class];
