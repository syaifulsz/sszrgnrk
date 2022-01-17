<?php

namespace app\components\configs;

use app\traits\SingletonTrait;

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
}