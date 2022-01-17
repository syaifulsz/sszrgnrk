<?php

namespace app\services;

use app\abstracts\ComponentAbstract;
use app\traits\SingletonTrait;

/**
 * Class Service
 * @package app\services

 * @method Service static getInstance()
 */
class Service extends ComponentAbstract
{
    use SingletonTrait;

    public $services = [];

    /**
     * @param $service
     * @param array $serviceArgs
     * @param string $id
     */
    public function addService( $service, array $serviceArgs = [], string $id = '' )
    {
        $id = $id ?: $service::INSTANCE_NAME;
        if ( is_object( $service ) ) {
            $this->services[ $id ] = $service;
        } else {
            $this->services[ $id ] = new $service( array_merge( $this->origin, $serviceArgs ) );
        }
    }

    public function getService( $id )
    {
        return $this->services[ $id ] ?? null;
    }
}