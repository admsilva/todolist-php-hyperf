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

use App\Request\LoginRequest;
use App\Services\LoginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Swagger\Annotation as SA;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Throwable;

#[AutoController]
class LoginController extends AbstractController
{
    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    private readonly LoginService $loginService;

    #[PostMapping(path: '')]
    #[SA\Post(path: '/login/login', summary: 'POST login', tags: ['Api/Login'])]
    public function login(LoginRequest $request): Psr7ResponseInterface
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $token = $this->loginService->login($email, $password);
            return $this->response->json(['data' => $token]);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }
    }
}
