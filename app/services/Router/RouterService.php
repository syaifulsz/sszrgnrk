<?php

namespace app\services\Router;

use app\components\RouterComponent;
use app\components\RouterInterface;

/**
 * Class RouterService
 * @package app\services\Router
 */
class RouterService extends RouterComponent implements RouterInterface
{
    const INSTANCE_NAME = 'AppRouter';
}