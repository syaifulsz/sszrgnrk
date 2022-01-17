<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use Illuminate\Support\Collection;

/**
 * Class RouteItem
 * @package app\components
 */
class RouteItem extends ComponentAbstract
{
    public $name;
    public $command;
    public $controller;
    public $method;

    /**
     * @var array
     */
    public $params = [];

    /**
     * @param array $params
     */
    public function setParams( array $params )
    {
        $this->params = $params;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addParam( string $key, $value )
    {
        $this->params[ $key ] = $value;
    }

    /**
     * @param string $key
     * @param null $default
     * @return array|mixed|null
     */
    public function getParam( string $key, $default = null )
    {
        return data_get( $key, $this->params ) ?: $default;
    }

    /**
     * @return Collection
     */
    public function getParams()
    {
        return new Collection( $this->params );
    }

    /**
     * @return mixed
     */
    public function gotoRoute()
    {
        return call_user_func_array( [ new $this->controller, $this->method ], $this->getParams()->toArray() );
    }
}