<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\LoginRequest;
use App\Services\LoginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
class LoginController extends AbstractController
{
    /**
     * @var LoginService
     */
    #[Inject]
    private readonly LoginService $loginService;

    /**
     * @var ResponseInterface
     */
    #[Inject]
    protected ResponseInterface $response;

    /**
     * @param LoginRequest $request
     * @return Psr7ResponseInterface
     */
    #[PostMapping(path: "")]
    public function login(LoginRequest $request): Psr7ResponseInterface
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $token = $this->loginService->login($email, $password);
            return $this->response->json($token);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}