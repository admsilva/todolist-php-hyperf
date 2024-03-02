<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Services\UserCRUDService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class OnlyAdminMiddleware implements MiddlewareInterface
{
    /**
     * @param Container $container
     * @param RequestInterface $request
     * @param HttpResponse $response
     * @param UserCRUDService $userService
     */
    public function __construct(
        protected Container $container,
        protected RequestInterface $request,
        protected HttpResponse $response,
        private UserCRUDService $userService
    )
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->container->get('user');
        $uuid = (string) $user?->uuid;
        $isAdmin = $this->userService->isAdminByUuid($uuid);
        if ($isAdmin === false) {
            return $this->response->json(['message' => 'Nao autorizado.'])->withStatus(403);
        }
        return $handler->handle($request);
    }
}