<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\TaskRequest;
use App\Resource\TaskResource;
use App\Services\TaskService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TaskController extends AbstractController
{
    /**
     * @var TaskService
     */
    #[Inject]
    private readonly TaskService $taskService;

    /**
     * @var ResponseInterface
     */
    #[Inject]
    protected ResponseInterface $response;

    /**
     * @return Psr7ResponseInterface
     */
    #[GetMapping(path: "list")]
    public function listAllTasks(): Psr7ResponseInterface
    {
        try {
            $tasks = $this->taskService->listAll();
            return $this->response->json(['data' => $tasks]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    /**
     * @param string $uuid
     * @return Psr7ResponseInterface
     */
    #[GetMapping(path: "{uuid}")]
    public function getTaskByUuid(string $uuid): Psr7ResponseInterface
    {
        try {
            $task = $this->taskService->findByUuid($uuid);
            return (new TaskResource($task))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    /**
     * @param TaskRequest $request
     * @return Psr7ResponseInterface
     */
    #[PostMapping(path: "")]
    public function createTask(TaskRequest $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $task = $this->taskService->create($data);
            return (new TaskResource($task))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    /**
     * @param string $uuid
     * @param TaskRequest $request
     * @return Psr7ResponseInterface
     */
    #[PutMapping(path: "{uuid}")]
    public function updateTask(string $uuid, TaskRequest $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $isUpdated = $this->taskService->updateByUuid($uuid, $data);
            return $this->response->json(['updated' => $isUpdated]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    /**
     * @param string $uuid
     * @return Psr7ResponseInterface
     */
    #[DeleteMapping(path: "{uuid}")]
    public function deleteTask(string $uuid): Psr7ResponseInterface
    {
        try {
            $isDeleted = $this->taskService->deleteById($uuid);
            return $this->response->json(['deleted' => $isDeleted]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}