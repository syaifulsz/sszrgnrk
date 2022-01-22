<?php

namespace app\components;

/**
 * Interface LocalizationInterface
 * @package app\components
 */
interface LocalizationInterface
{
    const ROUTE_PARAM_LOCALIZATION_DEFAULT = 'localizationDefault';

    public function setDefault( string $default );
    public function getDefault();
    public function getLocalization( string $local = '' );
    public function t( string $str, string $default = '', string $local = '' );
}