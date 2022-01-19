<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\App;
use app\components\configs\Config;
use app\components\StrComponent;

/**
 * Class ConfigComponent
 * @package app\components
 *
 * @property string config_dir
 * @property string app_env
 */
class ConfigComponent extends ComponentAbstract implements ConfigInterface
{
    /**
     * @var Config
     */
    public $configs;
    public function buildConfigs()
    {
        $env = strtolower( $this->app_env );
        $cachedConfigFile = "{$this->config_dir}/cached/{$env}.json";

        if ( !file_exists( $cachedConfigFile ) ) {
            $excludes = [ App::ENVIRONMENT_DEVELOPMENT, App::ENVIRONMENT_STAGING, App::ENVIRONMENT_PRODUCTION ];
            $configs = [];
            $configFiles = glob(  "{$this->config_dir}/*.php" );
            foreach ( $configFiles as $configFile ) {
                $info = pathinfo( $configFile );
                $fileName = $info[ 'filename' ];
                if ( !in_array( strtoupper( $fileName ), $excludes ) ) {
                    $configs[ $fileName ] = require $configFile;
                }
            }

            $envConfigFile = "{$this->config_dir}/{$env}.php";
            if ( file_exists( $envConfigFile ) ) {
                $envConfigs = require $envConfigFile;
                foreach ( $envConfigs as $fileName => $config ) {
                    $configs[ $fileName ] = array_replace_recursive( $configs[ $fileName ], $config );
                }
            }
            file_put_contents( $cachedConfigFile, json_encode( $configs ) );
        } else {
            $configs = json_decode( file_get_contents( $cachedConfigFile ), true );
        }

        $initConfigs = [];
        foreach ( $configs as $fileName => $config ) {
            $className = StrComponent::studly( $fileName );
            $class = "\\app\\components\\configs\\{$className}Param";
            $initConfigs[ $fileName ] = new $class( $config );
        }

        $this->configs = new Config( $initConfigs );
    }

    /**
     * @return Config
     */
    public function getConfigs()
    {
        if ( !$this->configs ) {
            $this->buildConfigs();
        }
        return $this->configs;
    }
}