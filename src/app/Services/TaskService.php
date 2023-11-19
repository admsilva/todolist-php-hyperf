<?php

namespace App\Services;

use App\Services\Contracts\ServiceInterface;

readonly class TaskService extends AbstractService implements ServiceInterface
{
    /**
     * @const string
     */
    final protected const MODEL_NAME = 'task';
}