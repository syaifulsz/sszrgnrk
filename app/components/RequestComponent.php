<?php

namespace app\components;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestComponent
 * @package app\components
 */
class RequestComponent extends Request implements RequestInterface
{
    /**
     * @var array
     */
    public $routerParameters = [];

    /**
     * @param array $parameters
     */
    public function setRouterParameter( array $parameters = [] )
    {
        $this->routerParameters = $parameters;
    }

    /**
     * @return Collection
     */
    public function getRouterParameter()
    {
        return new Collection( $this->routerParameters );
    }

    /**
     * Combine $_GET and $_POST parameters
     * @return array
     */
    public function toArray()
    {
        return array_merge( $this->query->all(), $this->request->all(), $this->getRouterParameter()->toArray() );
    }
}