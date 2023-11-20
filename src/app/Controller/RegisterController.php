<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\RegisterRequest;
use App\Services\RegisterService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Throwable;

#[Controller]
class RegisterController extends AbstractController
{
    /**
     * @var RegisterService
     */
    #[Inject]
    private readonly RegisterService $registerService;

    /**
     * @var ResponseInterface
     */
    #[Inject]
    protected ResponseInterface $response;

    /**
     * @param RegisterRequest $request
     * @return Psr7ResponseInterface
     */
    #[PostMapping(path: "")]
    public function login(RegisterRequest $request): Psr7ResponseInterface
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