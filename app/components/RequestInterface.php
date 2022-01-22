<?php

namespace app\components;

/**
 * Interface RequestInterface
 * @package app\components
 */
interface RequestInterface
{
    public function setRouterParameter( array $parameters = [] );
    public function getRouterParameter();
}