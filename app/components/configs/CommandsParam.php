<?php

namespace app\components\configs;

/**
 * Class CommandsParam
 * @package app\components\configs
 */
class CommandsParam extends Param
{
    /**
     * @var array
     */
    public $commands;

    protected function init()
    {
        parent::init();
        foreach ( $this->origin as $commandName => $route ) {
            
            var_dump( $route );
            die();
            

            foreach ( $route[ 'commmands' ] as $command => $config ) {
                $this->commands[ $command ] = $config;
            }
        }
    }
}