<?php

use app\components\RouterHelper;

return [
    'myAppHome'  => RouterHelper::createRouteWithLocalization( '/', '\\app\\controllers\\App\\HomeController', 'index', 'my' ),
    'myAppAbout' => RouterHelper::createRouteWithLocalization( '/about', '\\app\\controllers\\App\\AboutController', 'index', 'my' ),
    'myAppApi'   => RouterHelper::createRouteWithLocalization( '/api', '\\app\\controllers\\App\\ApiController', 'index', 'my' ),
    'appHome'    => RouterHelper::createRoute( '/', '\\app\\controllers\\App\\HomeController' ),
    'appAbout'   => RouterHelper::createRoute( '/about', '\\app\\controllers\\App\\AboutController' ),
    'appApi'     => RouterHelper::createRoute( '/about', '\\app\\controllers\\App\\ApiController' ),
];