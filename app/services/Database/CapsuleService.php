<?php

namespace app\services\Database;

use Illuminate\Database\Capsule\Manager;

/**
 * Class CapsuleService
 * @package app\services\Database
 */
class CapsuleService extends Manager
{
    const INSTANCE_NAME = 'AppDatabase';
}