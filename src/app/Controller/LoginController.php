<?php

namespace App\Controller;

use App\Services\LoginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[Controller]
class LoginController extends AbstractController
{
    #[Inject]
    private readonly LoginService $loginService;

    #[Inject]
    protected ResponseInterface $response;

    #[PostMapping(path: "")]
    public function login(RequestInterface $request): Psr7ResponseInterface
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