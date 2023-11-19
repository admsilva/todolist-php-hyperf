<?php

namespace App\Controller;

use App\Services\RegisterService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

#[Controller]
class RegisterController extends AbstractController
{
    #[Inject]
    private readonly RegisterService $registerService;

    #[Inject]
    protected ResponseInterface $response;

    #[PostMapping(path: "")]
    public function login(RequestInterface $request): Psr7ResponseInterface
    {
        try {
            $data = $request->all();
            $user = $this->registerService->register($data);
            return $this->response->json($user);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}