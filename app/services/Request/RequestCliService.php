<?php

namespace app\services\Request;

use app\components\RequestCliComponent;
use app\components\RequestCliInterface;

/**
 * Class RequestCliService
 * @package app\services\Request
 */
class RequestCliService extends RequestCliComponent implements RequestCliInterface
{
    const INSTANCE_NAME = 'AppConsoleRequest';
}