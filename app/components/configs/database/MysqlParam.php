<?php

namespace app\components\configs\database;

use app\components\configs\Param;

/**
 * Class MysqlParam
 * @package app\components\configs\database
 */
class MysqlParam extends Param
{
    public $driver;
    public $strict;
    public $host;
    public $port;
    public $database;
    public $username;
    public $password;
    public $charset;
    public $collation;
    public $prefix;
}