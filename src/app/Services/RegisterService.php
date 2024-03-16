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

use App\Constants\Profile;
use App\Model\Model;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;

readonly class RegisterService
{
    #[Inject]
    private UserCRUDService $userService;

    public function register(array $data): Model
    {
        Arr::set($data, 'profile', Profile::GUEST);
        return $this->userService->create($data);
    }
}
