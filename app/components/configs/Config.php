<?php

namespace app\components\configs;

use app\abstracts\ComponentAbstract;

/**
 * Class ConfigParam
 * @package app\components\configs
 */
class Config extends ComponentAbstract
{
    /**
     * @var AppParam
     */
    public $app;

    /**
     * @var RouteParam
     */
    public $route;

    /**
     * @var RouteCliParam
     */
    public $routeCli;

    /**
     * @var DatabaseParam
     */
    public $database;

    /**
     * @var MemcachedParam
     */
    public $memcached;

    /**
     * @var LocalizationParam
     */
    public $localization;
}