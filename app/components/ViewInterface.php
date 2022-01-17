<?php

namespace app\components;

/**
 * Interface ViewInterface
 * @package app\components
 */
interface ViewInterface
{
    const LAYOUT_BLOCK_HEAD       = 'LAYOUT_BLOCK_HEAD';
    const LAYOUT_BLOCK_HEAD_1     = 'LAYOUT_BLOCK_HEAD_1';
    const LAYOUT_BLOCK_BODY_START = 'LAYOUT_BLOCK_BODY_START';
    const LAYOUT_BLOCK_BODY_END   = 'LAYOUT_BLOCK_BODY_END';
    const LAYOUT_BLOCK_BODY_END_1 = 'LAYOUT_BLOCK_BODY_END_1';
    const LAYOUT_BLOCK_CONTENT    = 'LAYOUT_BLOCK_CONTENT';

    public function getParams( string $key, $default = null );
    public function addParams( array $params = [] );
    public function setParams( array $params = [] );
    public function setLayout( string $layout );
    public function getLayout();
    public function render( string $templateName, array $params = [] );
    public function getLayoutParams();
    public function getContent();
    public function renderAction( string $templateName );
}