<?php

namespace app\services\Database;

use app\components\DatabaseComponent;
use app\components\DatabaseInterface;
use app\services\Config\ConfigService;

/**
 * Class DatabaseSecondaryService
 * @package app\services\Database
 */
class DatabaseSecondaryService extends DatabaseComponent implements DatabaseInterface
{
    const INSTANCE_NAME = 'AppDatabaseSecondary';
    const CONNECTION_NAME = 'AppDatabaseSecondary';

    protected function init()
    {
        parent::init();
        $this->setDatabaseConfig( $this->config->database->databases[ self::CONNECTION_NAME ]->toArray() );
        $this->setConnectionName( self::CONNECTION_NAME );
    }
}