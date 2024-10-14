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

use App\Request\RegisterRequest;
use App\Resource\UserResource;
use App\Services\RegisterService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[AutoController]
class RegisterController extends AbstractController
{
    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    private readonly RegisterService $registerService;

    #[PostMapping(path: '')]
    public function login(RegisterRequest $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $user = $this->registerService->register($data);
            return (new UserResource($user))->toResponse();
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}
