<?php

namespace app\components\configs;

/**
 * Class ConfigParam
 * @package app\components\configs
 */
class AppParam extends Param
{
    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $version = '0.0.0';
}