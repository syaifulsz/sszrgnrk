<?php

namespace app\components;

/**
 * Interface RequestCliInterface
 * @package app\components
 */
interface RequestCliInterface
{
    public function __construct( array $argv = [] );
    public function setParams( array $params );
    public function addParam( string $key, $value );
    public function getParam( string $key, $default = null );
    public function getParams();
    public static function createFromGlobals();
}