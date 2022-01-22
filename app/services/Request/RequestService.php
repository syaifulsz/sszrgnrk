<?php

namespace app\services\Request;

use app\components\RequestComponent;
use app\components\RequestInterface;

/**
 * Class RequestService
 * @package app\services\Request
 */
class RequestService extends RequestComponent implements RequestInterface
{
    const INSTANCE_NAME = 'AppRequest';
}