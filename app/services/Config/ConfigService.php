<?php

namespace app\services\Config;

use app\components\ConfigComponent;
use app\components\ConfigInterface;

/**
 * Class ConfigService
 * @package app\services\Config
 */
class ConfigService extends ConfigComponent implements ConfigInterface
{
    const INSTANCE_NAME = 'AppConfig';
}