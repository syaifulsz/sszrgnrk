<?php

namespace app\components;

/**
 * Interface DatabaseInterface
 * @package app\components
 */
interface DatabaseInterface
{
    const MYSQL_CONNECTION_CONFIG_DEFAULT = [
        'driver'    => 'mysql',
        'strict'    => false,
        'host'      => '127.0.0.1',
        'port'      => 3306,
        'database'  => '',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ];
    const DATABASE_DEFAULT_NAME = 'default';

    public function setDatabaseConfig( array $config );
    public function getDatabaseConfig();
    public function setup();
}