<?php

namespace app\components;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestComponent
 * @package app\components
 */
class RequestComponent extends Request
{
    /**
     * Combine $_GET and $_POST parameters
     * @return array
     */
    public function toArray()
    {
        return array_merge( $this->query->all(), $this->request->all() );
    }
}