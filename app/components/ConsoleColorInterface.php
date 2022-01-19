<?php

namespace app\components;

/**
 * Interface ConsoleColor
 * @package app\components
 */
interface ConsoleColorInterface
{
    /**
     * Bash Colors
     * @see https://gist.github.com/JBlond/2fea43a3049b38287e5e9cefc87b2124
     */
    const COLOR_BLACK         = '0;30';
    const COLOR_DARK_GRAY     = '1;30';
    const COLOR_BLUE          = '0;34';
    const COLOR_LIGHT_BLUE    = '1;34';
    const COLOR_GREEN         = '0;32';
    const COLOR_LIGHT_GREEN   = '1;32';
    const COLOR_CYAN          = '0;36';
    const COLOR_LIGHT_CYAN    = '1;36';
    const COLOR_RED           = '0;31';
    const COLOR_LIGHT_RED     = '1;31';
    const COLOR_PURPLE        = '0;35';
    const COLOR_LIGHT_PURPLE  = '1;35';
    const COLOR_YELLOW        = '0;33';
    const COLOR_LIGHT_GRAY    = '0;37';
    const COLOR_WHITE         = '1;37';

    const BG_COLOR_BLACK      = '40';
    const BG_COLOR_RED        = '41';
    const BG_COLOR_GREEN      = '42';
    const BG_COLOR_YELLOW     = '43';
    const BG_COLOR_BLUE       = '44';
    const BG_COLOR_MAGENTA    = '45';
    const BG_COLOR_CYAN       = '46';
    const BG_COLOR_LIGHT_GRAY = '47';

    public function addTag( string $tag, string $color );
    public function color( string $str, string $color = '', string $bgColor = '' );
}