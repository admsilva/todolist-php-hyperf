<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Services\TaskService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TaskController extends AbstractController
{
    #[Inject]
    private readonly TaskService $taskService;

    #[GetMapping(path: "list")]
    public function listAllTasks(ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $users = $this->taskService->listAll();
            return $response->json($users);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[GetMapping(path: "{uuid}")]
    public function getTaskByUuid(string $uuid, ResponseInterface $response): Psr7ResponseInterface
    {
        try {
            $user = $this->taskService->findByUuid($uuid);
            return $response->json($user);
        } catch (Throwable $throwable) {
            return $response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PostMapping(path: "")]
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

    #[PutMapping(path: "{uuid}")]
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

    #[DeleteMapping(path: "{uuid}")]
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