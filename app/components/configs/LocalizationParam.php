<?php

namespace app\components\configs;

use app\components\configs\database\MysqlParam;
use Illuminate\Support\Collection;

/**
 * Class LocalizationParam
 * @package app\components\configs
 */
class LocalizationParam extends Param
{
    /**
     * @var string
     */
    public $default = 'en';

    /**
     * @var array
     */
    public $my = [];

    /**
     * @var array
     */
    public $en = [];

    /**
     * @var array
     */
    public $localization = [];

    /**
     * @param string $local
     * @return Collection
     */
    public function getLocalization( string $local = '' )
    {
        $local = $local ?: $this->default;
        if ( !isset( $this->localization[ $local ] ) ) {
            return $this->localization[ $local ] = new Collection( $this->{$local} );
        }
        return $this->localization[ $local ];
    }
}