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

namespace HyperfTest;

use Hyperf\Di\ClassLoader;
use Hyperf\Di\ScanHandler\ScanHandlerInterface;

class ClassLoaderCustom extends ClassLoader
{
    public static function init(?string $proxyFileDirPath = null, ?string $configDir = null, ?ScanHandlerInterface $handler = null): void
    {
        if (file_exists(BASE_PATH . '/.env')) {
            static::loadDotenv();
        }
    }
}
