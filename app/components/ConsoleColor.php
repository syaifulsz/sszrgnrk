<?php

namespace app\components;

use app\components\RegexComponent;
use Illuminate\Support\Collection;

/**
 * Class ConsoleColor
 * @package app\components
 */
class ConsoleColor implements ConsoleColorInterface
{
    /**
     * @var array
     */
    public $tags = [
        'info'    => self::COLOR_BLUE,
        'success' => self::COLOR_GREEN,
        'danger'  => self::COLOR_RED,
        'warning' => self::COLOR_YELLOW,
        'muted'   => self::COLOR_LIGHT_GRAY,
    ];

    /**
     * @param string $tag
     * @param string $color
     */
    public function addTag( string $tag, string $color )
    {
        $this->tags[ $tag ] = $color;
    }

    /**
     * @return Collection
     */
    public function getTags()
    {
        return new Collection( $this->tags );
    }

    /**
     * @param string $str
     * @param string $color
     * @param string $bgColor
     * @return string
     */
    public function color( string $str, string $color = '', string $bgColor = '' )
    {
        if ( !$color ) {
            foreach ( $this->getTags() as $tag => $tagColor ) {
                if (
                    StrComponent::startsWith( $str, "<{$tag}>" ) &&
                    StrComponent::endsWith( $str, "</{$tag}>" )
                ) {
                    $color = $tagColor;
                    $str = StrComponent::replace( "<{$tag}>", '', $str );
                    $str = StrComponent::replace( "</{$tag}>", '', $str );
                    break;
                }
            }
        }

        $colorStr = [];

        if ( $color ) {
            $colorStr[] = "\033[{$color}m";
        }

        if ( $bgColor ) {
            $colorStr[] = "\033[{$bgColor}m";
        }

        $colorStr[] = $str;

        if ( $color || $bgColor ) {
            $colorStr[] = "\033[0m";
        }

        return implode( '', $colorStr );
    }
}