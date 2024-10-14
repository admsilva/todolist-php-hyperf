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
use App\Request\TaskRequest;
use App\Resource\TaskResource;
use App\Services\TaskCRUDService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[AutoController]
#[Middleware(AuthMiddleware::class)]
class TaskController extends AbstractController
{
    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    private readonly TaskCRUDService $taskService;

    #[GetMapping(path: 'list')]
    public function listAllTasks(): Psr7ResponseInterface
    {
        try {
            $tasks = $this->taskService->listAll();
            return $this->response->json(['data' => $tasks]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[GetMapping(path: '{uuid}')]
    public function getTaskByUuid(string $uuid): Psr7ResponseInterface
    {
        try {
            $task = $this->taskService->findByUuid($uuid);
            return (new TaskResource($task))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }

    #[PostMapping(path: '')]
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

    #[PutMapping(path: '{uuid}')]
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

    #[DeleteMapping(path: '{uuid}')]
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
