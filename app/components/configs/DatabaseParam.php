<?php

namespace app\components\configs;

use app\components\configs\database\MysqlParam;

/**
 * Class DatabaseParam
 * @package app\components\configs
 */
class DatabaseParam extends Param
{
    /**
     * @var array
     */
    public $databases = [];

    protected function init()
    {
        parent::init();
        foreach ( $this->origin as $dbConnectionName => $dbConfig ) {
            $this->databases[ $dbConnectionName ] = new MysqlParam( $dbConfig );
        }
    }
}