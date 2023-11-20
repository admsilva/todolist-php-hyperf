<?php

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
    public const LOWEST = 'lowest';

    /**
     * @Message("Middle")
     */
    public const MIDDLE = 'middle';

    /**
     * @Message("Highest")
     */
    public const HIGHEST = 'highest';

    /**
     * @return array
     */
    public static function values(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}