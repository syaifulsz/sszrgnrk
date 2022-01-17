<?php

namespace app\traits;

/**
 * Trait SingletonTrait
 * @pockage app\traits
 */
trait SingletonTrait
{
    public static $instance;
    public static function getInstance( array $props = [] )
    {
        if ( !self::$instance ) {
            return self::$instance = new self( $props );
        }
        return self::$instance;
    }
}