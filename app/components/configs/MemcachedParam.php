<?php

namespace app\components\configs;

use app\components\configs\database\MysqlParam;
use Illuminate\Support\Collection;

/**
 * Class MemcachedParam
 * @package app\components\configs
 */
class MemcachedParam extends Param
{
    public function getServers()
    {
        return new Collection( $this->props[ 'servers' ] );
    }
}