<?php

use app\services\Database\DatabaseService;
use app\services\Database\DatabaseSecondaryService;

return [

    DatabaseService::CONNECTION_NAME => [
        'driver'    => 'mysql',
        'strict'    => false,
        'host'      => 'sszdevbox_db',
        'port'      => 3306,
        'database'  => 'sszrgnrk',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ],

    DatabaseSecondaryService::CONNECTION_NAME => [
        'driver'    => 'mysql',
        'strict'    => false,
        'host'      => 'sszdevbox_db',
        'port'      => 3306,
        'database'  => 'sszrgnrk_secondary',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ]
];
