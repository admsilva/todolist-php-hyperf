<?php

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

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
}