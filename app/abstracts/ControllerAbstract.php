<?php

namespace app\abstracts;

use app\components\ConfigComponent;
use app\components\RequestComponent;
use app\components\StrComponent;
use app\components\ViewComponent;
use app\services\Cache\MemcachedService;
use app\services\Config\ConfigService;
use app\services\Request\RequestService;
use app\services\View\ViewService;
use app\traits\ComponentTrait;
use app\services\Service;
use app\components\configs\Config;

/**
 * Abstract ControllerAbstract
 * @package app\abstracts
 */
abstract class ControllerAbstract
{
    use ComponentTrait;

    /**
     * @var string
     */
    public $template = '';

    /**
     * @var array
     */
    public $origin = [];

    /**
     * @var ConfigComponent
     */
    public $config;

    /**
     * @var Config
     */
    public $configs;

    /**
     * @var ViewComponent
     */
    public $view;

    /**
     * @var RequestComponent
     */
    public $request;

    /**
     * @var Service
     */
    public $service;

    /**
     * @var MemcachedService
     */
    public $cache;

    /**
     * @param array $props
     */
    public function __construct( array $props = [] )
    {
        $props = $this->initBefore( $props );
        $this->origin  = $props;
        $this->setProps( $props );

        // app service instance
        $this->service = Service::getInstance();

        // controller config
        $this->config  = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->configs = $this->config->getConfigs();

        // controller view
        $this->view    = $this->service->getService( ViewService::INSTANCE_NAME );

        // controller cache
        $this->cache   = $this->service->getService( MemcachedService::INSTANCE_NAME );

        // controller request
        $this->request = $this->service->getService( RequestService::INSTANCE_NAME );

        $this->setLayout( 'main' );

        $this->init();
        $this->initAfter();
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function renderAction( string $template = '', array $data = [] )
    {
        if ( !$template ) {
            $template = $this->template;
        }
        $this->view->addParams( $data );
        return $this->view->renderAction( $template );
    }

    protected function init()
    {

    }

    /**
     * @param array $props
     * @return array
     */
    protected function initBefore( array $props = [] )
    {
        return $props;
    }

    protected function initAfter()
    {

    }

    /**
     * @param string $layout
     */
    public function setLayout( string $layout )
    {
        $this->view->layout = $layout;
    }

    /**
     * @param \ReflectionClass $mirror
     * @param string $method
     */
    public function setTemplate( \ReflectionClass $mirror, string $method )
    {
        $excludes = [
            'app',
            'controllers',
            'Controller'
        ];

        $templateArr = [];
        $controllerName = $mirror->getName();
        $controllerNameArr = explode( '\\', $controllerName );
        foreach ( $controllerNameArr as $t ) {
            if ( !in_array( $t, $excludes ) ) {
                $t = str_replace( 'Controller', '', $t );
                $templateArr[] = StrComponent::kebab( $t );
            }
        }
        $templateArr[] = StrComponent::kebab( $method );
        $this->template = implode( '/', $templateArr );
    }

    /**
     * @param string $method
     * @param array $args
     * @throws \Exception
     */
    public function __call( string $method, array $args )
    {
        $actionMethod = 'action' . StrComponent::studly( $method );

        if ( !method_exists( $this, $actionMethod ) ) {
            throw new \Exception( 'Oops! The page you looking for is not exist!' );
        }

        $this->setTemplate( new \ReflectionClass( $this ), $method );

        $render = call_user_func_array( [ $this, $actionMethod ], array_merge( [ 'request' => $this->request ], $args ) );
        if ( $render ) {

            if ( is_array( $render ) ) {
                header( "Content-Type: application/json" );
                echo json_encode( $render );
            } else {
                echo $render;
            }
        } else {
            header( "Content-Type: application/json" );
            echo json_encode( $args );
        }
    }
}