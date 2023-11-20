<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\Profile;
use App\Model\Model;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;

readonly class RegisterService
{
    /**
     * @var UserService
     */
    #[Inject]
    private UserService $userService;

    /**
     * @param array $data
     * @return Model
     */
    public function register(array $data): Model
    {
        Arr::set($data, 'profile', Profile::GUEST);
        return $this->userService->create($data);
    }
}