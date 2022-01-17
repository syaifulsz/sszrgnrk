<?php

namespace app;

use app\abstracts\ComponentAbstract;
use app\components\ConfigComponent;
use app\components\RequestComponent;
use app\components\RouterComponent;
use app\components\ViewComponent;
use app\services\Config\ConfigService;
use app\services\Database\DatabaseService;
use app\services\Database\DatabaseSecondaryService;
use app\services\Cache\MemcachedService;
use app\services\Router\RouterService;
use app\services\Service;
use app\services\View\ViewService;
use app\traits\SingletonTrait;

/**
 * Class App
 * @package app
 *
 * @method static App getInstance
 */
class App extends ComponentAbstract
{
    use SingletonTrait;

    const ENVIRONMENT_DEVELOPMENT = 'DEVELOPMENT';
    const ENVIRONMENT_STAGING     = 'STAGING';
    const ENVIRONMENT_PRODUCTION  = 'PRODUCTION';

    public $app_dir;
    public $public_dir;
    public $config_dir;
    public $view_dir;
    public $app_env = App::ENVIRONMENT_DEVELOPMENT;

    /**
     * @var ConfigComponent
     */
    public $config;

    /**
     * @var ViewComponent
     */
    public $view;

    /**
     * @var RouterComponent
     */
    public $router;

    /**
     * @var Service
     */
    public $service;

    protected function initBefore( array $props = [] )
    {
        $props = parent::initBefore( $props );

        // initiate app service
        $this->service = Service::getInstance( $props );

        // initiate app config & config service registration
        $config = new ConfigService( $props );
        $this->service->addService( $config );

        // initiate app view & view service registration
        $view = new ViewService( $props );
        $this->service->addService( $view );

        // initiate app router & router service registration
        $router = new RouterService();
        $this->service->addService( $router );

        $this->config = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->view   = $this->service->getService( ViewService::INSTANCE_NAME );
        $this->router = $this->service->getService( RouterService::INSTANCE_NAME );

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

    public function run()
    {
        $this->router->listen();
    }
}