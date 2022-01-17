<?php

namespace app\services\View;

use app\components\ViewComponent;
use app\components\ViewInterface;

/**
 * Class ViewService
 * @package app\services\View
 */
class ViewService extends ViewComponent implements ViewInterface
{
    const INSTANCE_NAME = 'AppView';
}