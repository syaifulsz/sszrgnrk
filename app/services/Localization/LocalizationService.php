<?php

namespace app\services\Localization;

use app\components\LocalizationComponent;
use app\components\LocalizationInterface;

/**
 * Class LocalizationService
 * @package app\services\Localization
 */
class LocalizationService extends LocalizationComponent implements LocalizationInterface
{
    const INSTANCE_NAME = 'AppLocalization';
}