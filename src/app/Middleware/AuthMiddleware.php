<?php

declare(strict_types=1);

namespace App\Middleware;

use Firebase\JWT\JWT;
use Hyperf\Collection\Arr;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Container;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

readonly class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected string $jwtSecretKey;

    /**
     * @param Container $container
     * @param RequestInterface $request
     * @param HttpResponse $response
     */
    public function __construct(
        protected Container $container,
        protected RequestInterface  $request,
        protected HttpResponse $response
    ) {
        $this->jwtSecretKey = getenv('JWT_SECRET_KEY');
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->request->getHeader('Authorization');

        if (empty($token)) {
            return $this->response->json(['message' => 'Token de autenticação ausente'])->withStatus(401);
        }

        try {
            $key = new Key($this->jwtSecretKey, 'HS256');
            $token = Arr::first($token);
            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($token, $key);
            $this->container->set('user', $decoded);
        } catch (Throwable $throwable) {
            return $this->response->json(['message' => $throwable->getMessage()])->withStatus(401);
        }

        return $handler->handle($request);
    }
}