<?php

namespace app\abstracts;

use app\App;
use app\traits\ComponentTrait;

/**
 * Abstract Component
 * @package app\abstracts
 */
abstract class ComponentAbstract
{
    use ComponentTrait;

    public $origin = [];

    public function __construct( array $props = [] )
    {
        $props = $this->initBefore( $props );
        $this->origin = $props;
        $this->setProps( $props );

        $this->init();
        $this->initAfter();
    }

    protected function init()
    {

    }

    /**
     * @param array $props
     * @return array
     */
    protected function initBefore( array $props = [] )
    {
        return $props;
    }

    protected function initAfter()
    {

    }
}