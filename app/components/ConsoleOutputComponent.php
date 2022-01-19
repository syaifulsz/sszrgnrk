<?php

namespace app\components;

use Symfony\Component\Console\Output\Output;

/**
 * Class ConsoleOutputComponent
 * @package app\components
 */
class ConsoleOutputComponent extends Output implements ConsoleOutputInterface
{
    public function ln( int $line = 1 )
    {
        for ( $i = 0; $i < $line; $i++ ) {
            $this->write( '', 1 );
        }
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