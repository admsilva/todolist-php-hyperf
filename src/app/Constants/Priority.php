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

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;
use ReflectionClass;

#[Constants]
class Priority extends AbstractConstants
{
    /**
     * @Message("Lowest")
     */
    public const string LOWEST = 'lowest';

    /**
     * @Message("Middle")
     */
    public const string MIDDLE = 'middle';

    /**
     * @Message("Highest")
     */
    public const string HIGHEST = 'highest';

    public static function values(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}
