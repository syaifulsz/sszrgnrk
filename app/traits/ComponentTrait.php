<?php

namespace app\traits;

use app\components\StrComponent;
use Illuminate\Support\Collection;

/**
 * Trait ComponentTrait
 * @pockage app\traits
 */
trait ComponentTrait
{
    /**
     * @var array
     */
    public $props = [];

    /**
     * @return Collection
     */
    public function getProps()
    {
        return new Collection( $this->props );
    }

    /**
     * @param array $props
     */
    public function setProps( array $props = [] )
    {
        foreach ( $props as $prop => $value ) {
            if ( property_exists( $this, $prop ) ) {
                $this->{$prop} = $value;
            } else {
                $this->props[ $prop ] = $value;
            }
        }
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get( $name )
    {
        $method = 'get' . StrComponent::studly( $name ) . 'Prop';

        if ( method_exists( $this, $method ) ) {
            return $this->$method();
        }

        if ( isset( $this->props[ $name ] ) ) {
            return $this->props[ $name ];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set( $name, $value )
    {
        $this->props[ $name ] = $value;
        $method = 'set' . StrComponent::studly( $name ) . 'Prop';
        switch ( true ) {
            case method_exists( $this, $method ) :
                $this->$method( $value );
                break;
            default:
                $this->props[ $name ] = $value;
                break;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ( $this->props as $prop => $value ) {
            $array[ $prop ] = $this->{$prop};
        }

        foreach ( get_object_vars( $this ) as $prop => $value ) {
            $array[ $prop ] = $this->{$prop};
        }

        unset( $array[ 'origin' ] );
        unset( $array[ 'props' ] );

        return $array;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }
}