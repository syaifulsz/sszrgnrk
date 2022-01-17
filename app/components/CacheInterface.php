<?php

namespace app\components;

/**
 * Interface CacheInterface
 * @package app\components
 */
interface CacheInterface
{
    const MINUTE_IN_SECONDS = 60;
    const HOUR_IN_SECONDS   = 3600;
    const DAY_IN_SECONDS    = 86400;
    const WEEK_IN_SECONDS   = 604800;
    const MONTH_IN_SECONDS  = 2592000;
    const YEAR_IN_SECONDS   = 31536000;

    public function setNamespace( string $namespace );
    public function getNamespace();
    public function getCache();
    public function setup();
    public function set( string $key, $value, int $duration = 0, array $tags = [] );
    public function get( string $key, $default = null, bool $asItem = false );
    public function delete( string $key );
    public function invalidateTags( $tags );
    public function reset();
}