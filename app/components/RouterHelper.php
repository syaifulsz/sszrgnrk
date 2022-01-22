<?php

namespace app\components;

use app\components\LocalizationInterface;
use Illuminate\Support\Str;

/**
 * Class RouterHelper
 * @package app\components
 */
class RouterHelper
{
    /**
     * @param string $url
     * @param string $controller
     * @param string $method
     * @param array $defaultValues
     * @param array $paramRules
     * @return array
     */
    public static function createRoute(
        string $url,
        string $controller,
        string $method        = 'index',
        array  $defaultValues = [],
        array  $paramRules    = []
    )
    {
        $options = [
            'defaultValues' => $defaultValues,
            'paramRules'    => $paramRules,
        ];

        return [
            $url,
            [ $controller, $method ],
            $options
        ];
    }

    /**
     * @param string $url
     * @param string $controller
     * @param string $method
     * @param string $localization
     * @param array $defaultValues
     * @param array $paramRules
     * @return array
     */
    public static function createRouteWithLocalization(
        string $url,
        string $controller,
        string $method        = 'index',
        string $localization  = 'en',
        array  $defaultValues = [],
        array  $paramRules    = []
    )
    {
        $defaultValues = array_merge( [
            LocalizationInterface::ROUTE_PARAM_LOCALIZATION_DEFAULT => $localization
        ], $defaultValues );

        $url = "/{$localization}{$url}";
        if ( StrComponent::endsWith( $url, '/' ) ) {
            $url = StrComponent::replaceLast( '/', '', $url );
        }

        return self::createRoute( $url, $controller, $method, $defaultValues, $paramRules );
    }
}