<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\components\configs\Config;
use app\services\Config\ConfigService;
use app\services\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouterComponent
 * @package app\components
 */
class RouterComponent extends ComponentAbstract implements RouterInterface
{
    /**
     * @var Service
     */
    public $service;

    /**
     * @var RouteCollection
     */
    public $collection;

    /**
     * @var RequestContext
     */
    public $context;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Config
     */
    public $configs;

    protected function init()
    {
        parent::init();

        $this->service = Service::getInstance();

        $this->collection = new RouteCollection();
        $this->context = new RequestContext();
        $this->request = Request::createFromGlobals();
        $this->context->fromRequest( $this->request );
        $this->configs = $this->service->getService( ConfigService::INSTANCE_NAME )->getConfigs();
        $this->setup();
    }

    /**
     * @return array
     */
    public $routes = [];

    /**
     * @return array
     */
    public function getRoutes()
    {
        if ( !$this->routes ) {
            $routes = [];
            foreach ( $this->configs->route->toArray() as $name => $rule ) {
                if ( empty( $rule[ 1 ][ 1 ] ) ) {
                    throw new \Error( "{$name} are missing method name!" );
                }

                $rules = [];
                $defaultValues = [];
                if ( $option = ( $rule[ 2 ] ?? [] ) ) {
                    if ( !empty( $option[ 'paramRules' ] ) && is_array( $option[ 'paramRules' ] ) ) {
                        $rules = $option[ 'paramRules' ];
                    }
                    if ( !empty( $option[ 'defaultValues' ] ) && is_array( $option[ 'defaultValues' ] ) ) {
                        $defaultValues = $option[ 'defaultValues' ];
                    }
                }

                $routes[ $name ] = new Route(
                    $rule[ 0 ],
                    array_merge( [
                        'controller' => $rule[ 1 ][ 0 ],
                        'method' => $rule[ 1 ][ 1 ]
                    ], $defaultValues ),
                    $rules
                );
            }
            $this->routes = $routes;
        }
        return $this->routes;
    }

    public function setup()
    {
        foreach( $this->getRoutes() as $name => $route ) {
            $this->add( $name, $route );
        }
    }

    /**
     * @param string $name
     * @param Route $route
     */
    public function add( string $name, Route $route )
    {
        $this->collection->add( $name, $route );
    }

    public $errors = [];
    public function addError( $instance )
    {
        $this->errors[] = $instance;
    }

    public function start()
    {
        // Init UrlMatcher object
        $matcher = new UrlMatcher( $this->collection, $this->context );

        // Find the current route
        $parameters = $matcher->match( $this->context->getPathInfo() );

        // Pass an array for arguments
        return call_user_func_array( [ new $parameters[ 'controller' ], $parameters[ 'method' ] ], $parameters );
    }

    public function listen()
    {
        try {
            return $this->start();
        } catch ( ResourceNotFoundException $e ) {
            $this->addError( $e );
        }
    }
}
