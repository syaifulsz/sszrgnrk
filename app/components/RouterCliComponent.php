<?php

namespace app\components;

use app\services\Config\ConfigService;
use app\services\Service;

/**
 * Class RouterCliComponent
 * @package app\components
 */
class RouterCliComponent extends RouterComponent
{
    /**
     * @var RequestCliComponent
     */
    public $request;

    protected function init()
    {
        $this->service = Service::getInstance();
        $this->request = RequestCliComponent::createFromGlobals();
        $this->configs = $this->service->getService( ConfigService::INSTANCE_NAME )->getConfigs();
        $this->setup();
    }

    public function getRoutes()
    {
        if ( !$this->routes ) {
            $routes = [];
            foreach ( $this->configs->routeCli->toArray() as $name => $rule ) {

                $command = $rule[ 0 ] ?? null;
                $controller = $rule[ 1 ][ 0 ] ?? null;
                $method = $rule[ 1 ][ 1 ] ?? null;

                if ( !$controller ) {
                    throw new \Error( "{$name} are missing controller!" );
                }

                if ( !$method ) {
                    throw new \Error( "{$name} are missing method!" );
                }

                $routes[ $command ] = new RouteItem( [
                    'name' => $name,
                    'command' => $command,
                    'controller' => $controller,
                    'method' => $method,
                ] );
            }
            $this->routes = $routes;
        }
        return $this->routes;
    }

    public function setup()
    {
    }

    public function start()
    {
        $routes = $this->getRoutes();
        if ( isset( $routes[ $this->request->command ] ) ) {

            /**
             * @var $route RouteItem
             */
            $route = $routes[ $this->request->command ];
            $route->setParams( $this->request->getParams()->toArray() );
            return $route->gotoRoute();
        }
    }

    public function listen()
    {
        try {
            return $this->start();
        } catch ( \Error $e ) {
            $this->addError( $e );
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
