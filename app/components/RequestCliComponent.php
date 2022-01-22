<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use Illuminate\Support\Collection;

/**
 * Class RequestCliComponent
 * @package app\components
 */
class RequestCliComponent extends ComponentAbstract implements RequestCliInterface
{
    /**
     * @var string
     */
    public $command;

    /**
     * @param array $argv
     */
    public function __construct( array $argv = [] )
    {
        $command = $argv[ 1 ] ?? null;

        unset( $argv[ 0 ] );
        unset( $argv[ 1 ] );
        foreach ( $argv as $str ) {
            if ( StrComponent::startsWith( $str, '--' ) ) {
                $str = str_replace( '--', '', $str );
                $keyValue = explode( '=', $str );
                $this->addParam( $keyValue[ 0 ], $keyValue[ 1 ] );
            }
        }

        $this->setProps( [
            'command' => $command
        ] );
    }

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
     * @return RequestCliComponent
     */
    public static function createFromGlobals()
    {
        return new self( $_SERVER[ 'argv' ] ?? [] );
    }
}