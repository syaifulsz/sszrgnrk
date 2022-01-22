<?php

namespace app\components;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\Output;

/**
 * Class ConsoleOutputComponent
 * @package app\components
 */
class ConsoleOutputComponent extends Output implements ConsoleOutputInterface
{
    /**
     * @var ConsoleColor
     */
    public $color;

    /**
     * @return ConsoleColor
     */
    public function getConsoleColor()
    {
        if ( !$this->color ) {
            return $this->color = new ConsoleColor();
        }
        return $this->color;
    }

    public function ln( int $line = 1 )
    {
        for ( $i = 0; $i < $line; $i++ ) {
            $this->write( '', 1 );
        }
    }

    /**
     * @param $messages
     * @param string $color
     * @param string $bgColor
     * @return string
     */
    public function writeColor( $messages, string $color = '', string $bgColor = '' )
    {
        $consoleColor = $this->getConsoleColor();
        $this->writeln( $consoleColor->color( $messages, $color, $bgColor ) );
    }

    /**
     * @param string $message
     * @param bool $newline
     */
    protected function doWrite( string $message, bool $newline )
    {
        echo $message;
        if ( $newline ) {
            echo PHP_EOL;
        }
    }
}