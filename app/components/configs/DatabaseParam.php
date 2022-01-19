<?php

namespace app\components\configs;

use app\components\configs\database\MysqlParam;
use Illuminate\Support\Collection;

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

    /**
     * @return Collection
     */
    public function getDatabases()
    {
        return new Collection( $this->databases );
    }

    /**
     * @param string $key
     * @return array|null
     */
    public function getDatabase( string $key )
    {
        return $this->getDatabases()->get( $key );
    }
}