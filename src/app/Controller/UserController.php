<?php

namespace App\Controller;

use App\Services\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[RequestMapping(path: "list", methods: "get")]
    public function listAllUsers(ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $users = $this->userService->listAll();
            return $response->json($users);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{uuid}", methods: "get")]
    public function getUserByUuid(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $user = $this->userService->findByUuid($uuid);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "", methods: "post")]
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

    #[RequestMapping(path: "{uuid}", methods: "put")]
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

    #[RequestMapping(path: "{uuid}", methods: "delete")]
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