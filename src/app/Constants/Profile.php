<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;
use ReflectionClass;

#[Constants]
class Profile extends AbstractConstants
{
    /**
     * @Message("Administrator")
     */
    public const ADMIN = 'admin';

    /**
     * @Message("Guest")
     */
    public const GUEST = 'guest';

    /**
     * @return array
     */
    public static function values(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}