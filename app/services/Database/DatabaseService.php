<?php

namespace app\services\Database;

use app\components\DatabaseComponent;
use app\components\DatabaseInterface;

/**
 * Class DatabaseService
 * @package app\services\Database
 */
class DatabaseService extends DatabaseComponent implements DatabaseInterface
{
    const INSTANCE_NAME = 'AppDatabase';
    const CONNECTION_NAME = self::DATABASE_DEFAULT_NAME;
}