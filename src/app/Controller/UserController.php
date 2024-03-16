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

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Middleware\OnlyAdminMiddleware;
use App\Request\UserRequest;
use App\Resource\UserResource;
use App\Services\UserCRUDService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
#[Middlewares([AuthMiddleware::class, OnlyAdminMiddleware::class])]
class UserController extends AbstractController
{
    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    private readonly UserCRUDService $userService;

    #[GetMapping(path: 'list')]
    public function listAllUsers(): Psr7ResponseInterface
    {
        try {
            $users = $this->userService->listAll();
            return $this->response->json(['data' => $users]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[GetMapping(path: '{uuid}')]
    public function getUserByUuid(string $uuid): Psr7ResponseInterface
    {
        try {
            $user = $this->userService->findByUuid($uuid);
            return (new UserResource($user))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PostMapping(path: '')]
    public function createUser(UserRequest $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $user = $this->userService->create($data);
            return (new UserResource($user))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PutMapping(path: '{uuid}')]
    public function updateUser(string $uuid, UserRequest $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $isUpdated = $this->userService->updateByUuid($uuid, $data);
            return $this->response->json(['updated' => $isUpdated]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[DeleteMapping(path: '{uuid}')]
    public function deleteUser(string $uuid): Psr7ResponseInterface
    {
        try {
            $isDeleted = $this->userService->deleteById($uuid);
            return $this->response->json(['deleted' => $isDeleted]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}
