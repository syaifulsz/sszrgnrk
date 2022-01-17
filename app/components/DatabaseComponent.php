<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\components\configs\Config;
use app\services\Config\ConfigService;
use app\services\Service;
use app\services\Database\CapsuleService;

/**
 * Class DatabaseComponent
 * @package app\components
 */
class DatabaseComponent extends ComponentAbstract implements DatabaseInterface
{
    const CAPSULE_INSTANCE_NAME = 'AppDatabaseCapsuleManager';

    /**
     * @var Service
     */
    public $service;

    /**
     * @var Config
     */
    public $config;

    /**
     * @var CapsuleService
     */
    public $capsule;

    /**
     * @var array
     */
    public $databaseConfig = [];

    /**
     * @param array $config
     */
    public function setDatabaseConfig( array $config )
    {
        $this->databaseConfig = array_merge( $this->databaseConfig, $config );
    }

    /**
     * @return array
     */
    public function getDatabaseConfig()
    {
        return $this->databaseConfig;
    }

    protected function init()
    {
        parent::init();
        $this->service = Service::getInstance();
        $this->config = $this->service->getService( ConfigService::INSTANCE_NAME )->getConfigs();
        
        // var_dump( $this->config->database->databases );
        
        $this->databaseConfig = array_merge( self::MYSQL_CONNECTION_CONFIG_DEFAULT, $this->config->database->databases[ self::DATABASE_DEFAULT_NAME ]->toArray() );

        if ( !$this->capsule = $this->service->getService( self::CAPSULE_INSTANCE_NAME ) ) {
            $capsule = new CapsuleService();
            $this->service->addService( $capsule, [], self::CAPSULE_INSTANCE_NAME );
            $this->capsule = $capsule;
        }
    }

    /**
     * @var string
     */
    public $connectionName = self::DATABASE_DEFAULT_NAME;
    public function setConnectionName( string $name )
    {
        $this->connectionName = $name;
    }

    public function setup()
    {
        $this->capsule->addConnection( $this->getDatabaseConfig(), $this->connectionName );
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
}