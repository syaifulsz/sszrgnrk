<?php

namespace app\components;

use Symfony\Component\Routing\Route;

/**
 * Interface RouterInterface
 * @package app\components
 */
interface RouterInterface
{
    public function getRoutes();
    public function setup();
    public function add( string $name, Route $route );
    public function addError( $instance );
    public function start();
    public function listen();
}