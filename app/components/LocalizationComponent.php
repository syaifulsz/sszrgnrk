<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\components\configs\Config;
use app\services\Config\ConfigService;
use app\services\Request\RequestService;
use app\services\Service;
use Illuminate\Support\Collection;

/**
 * Class LocalizationComponent
 * @package app\components
 */
class LocalizationComponent extends ComponentAbstract implements LocalizationInterface
{
    /**
     * @var Service
     */
    public $service;

    /**
     * @var RequestService
     */
    public $request;

    /**
     * @var ConfigInterface
     */
    public $config;

    /**
     * @var Config
     */
    public $configs;

    /**
     * @var string
     */
    public $default = '';

    /**
     * @param string $default
     */
    public function setDefault( string $default )
    {
        $this->default = $default;
    }

    protected function init()
    {
        parent::init();

        // setup service
        $this->service = Service::getInstance();

        // setup config
        $this->config  = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->configs = $this->config->getConfigs();

        // setup request
        $this->request = $this->service->getService( RequestService::INSTANCE_NAME );

        // setup language default
        // $localizationDefault = ( $this->request->get( self::ROUTE_PARAM_LOCALIZATION_DEFAULT ) ?: $this->configs->localization->default );
        $this->setDefault( $this->configs->localization->default );
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $local
     * @return Collection
     */
    public function getLocalization( string $local = '' )
    {
        $local = $local ?: $this->getDefault();
        return $this->configs->localization->getLocalization( $local );
    }

    /**
     * @var array
     */
    public $ts = [];

    /**
     * @param string $str
     * @param string $default
     * @param string $local
     * @return string
     */
    public function t( string $str, string $default = '', string $local = '' )
    {
        $key = "{$local}.{$str}";
        $default = $default ?: $str;

        if ( !isset( $this->ts[ $key ] ) ) {
            $localization = $this->getLocalization( $local );
            return $this->ts[ $key ] = ( $localization->get( $str ) ?: $default );
        }
        return $this->ts[ $key ];
    }
}