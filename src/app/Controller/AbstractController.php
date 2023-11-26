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

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use Hyperf\Swagger\Annotation as OA;

#[OA\Server(url: 'http://localhost:9510')]
abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    #[Inject]
    protected ContainerInterface $container;

    /**
     * @var RequestInterface
     */
    #[Inject]
    protected RequestInterface $request;

    /**
     * @var ResponseInterface
     */
    #[Inject]
    protected ResponseInterface $response;
}
