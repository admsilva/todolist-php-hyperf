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
    public function list(ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $users = $this->userService->listAllUsers();
            return $response->json($users);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{id}", methods: "get")]
    public function getUserById(string $id, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $user = $this->userService->findUserById($id);
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
            $user = $this->userService->createNewUser($data);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{id}", methods: "put")]
    public function updateUser(string $id, RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $isUpdated = $this->userService->updateUserById($id, $data);
            return $response->json(['updated' => $isUpdated]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{id}", methods: "delete")]
    public function deleteUser(string $id, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $isDeleted = $this->userService->deleteUserById($id);
            return $response->json(['deleted' => $isDeleted]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}