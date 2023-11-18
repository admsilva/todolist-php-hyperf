<?php

namespace App\Controller;

use App\Services\TaskService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
class TaskController extends AbstractController
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    #[RequestMapping(path: "list", methods: "get")]
    public function listAllTasks(ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $users = $this->taskService->listAll();
            return $response->json($users);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{uuid}", methods: "get")]
    public function getTaskByUuid(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $user = $this->taskService->findByUuid($uuid);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "", methods: "post")]
    public function createTask(RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $user = $this->taskService->create($data);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{uuid}", methods: "put")]
    public function updateTask(string $uuid, RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $isUpdated = $this->taskService->updateByUuid($uuid, $data);
            return $response->json(['updated' => $isUpdated]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[RequestMapping(path: "{uuid}", methods: "delete")]
    public function deleteTask(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $isDeleted = $this->taskService->deleteById($uuid);
            return $response->json(['deleted' => $isDeleted]);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}