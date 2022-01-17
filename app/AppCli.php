<?php

namespace app;

use app\services\Config\ConfigService;
use app\services\Database\DatabaseService;
use app\services\Database\DatabaseSecondaryService;
use app\services\Cache\MemcachedService;
use app\services\Router\RouterCliService;
use app\services\Service;

/**
 * Class AppCli
 * @package app
 *
 * @method static AppCli getInstance
 */
class AppCli extends App
{
    /**
     * @var RouterCliService
     */
    public $router;

    protected function initBefore( array $props = [] )
    {
        $props = parent::initBefore( $props );

        // initiate app service
        $this->service = Service::getInstance( $props );

        // initiate app config & config service registration
        $config = new ConfigService( $props );
        $this->service->addService( $config );

        // initiate app router & router service registration
        $router = new RouterCliService();
        $this->service->addService( $router );

        $this->config = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->router = $this->service->getService( RouterCliService::INSTANCE_NAME );

        // initiate app database & database service registration
        $database = new DatabaseService();
        $database->setup();
        $this->service->addService( $database );

        $databaseSecondary = new DatabaseSecondaryService();
        $databaseSecondary->setup();
        $this->service->addService( $databaseSecondary );

        // initiate app cache (memcached) & service registration
        $memcached = new MemcachedService();
        $this->service->addService( $memcached );

        return $props;
    }
}