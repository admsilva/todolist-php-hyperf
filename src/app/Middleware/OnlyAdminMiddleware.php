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

namespace App\Middleware;

use App\Services\UserCRUDService;
use Hyperf\Di\Container;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class OnlyAdminMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected Container $container,
        protected RequestInterface $request,
        protected HttpResponse $response,
        private UserCRUDService $userService
    ) {
    }

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
