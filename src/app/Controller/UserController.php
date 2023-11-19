<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Middleware\OnlyAdminMiddleware;
use App\Services\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
#[Middlewares([AuthMiddleware::class, OnlyAdminMiddleware::class])]
class UserController extends AbstractController
{
    #[Inject]
    private readonly UserService $userService;

    #[GetMapping(path: "list")]
    public function listAllUsers(ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $users = $this->userService->listAll();
            return $response->json($users);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[GetMapping(path: "{uuid}")]
    public function getUserByUuid(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $user = $this->userService->findByUuid($uuid);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PostMapping(path: "")]
    public function createUser(RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $user = $this->userService->create($data);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PutMapping(path: "{uuid}")]
    public function updateUser(string $uuid, RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $isUpdated = $this->userService->updateByUuid($uuid, $data);
            return $response->json(['updated' => $isUpdated]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[DeleteMapping(path: "{uuid}")]
    public function deleteUser(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $isDeleted = $this->userService->deleteById($uuid);
            return $response->json(['deleted' => $isDeleted]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}