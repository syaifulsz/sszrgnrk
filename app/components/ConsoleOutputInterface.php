<?php

namespace app\components;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface ConsoleOutputInterface
 * @package app\components
 */
interface ConsoleOutputInterface extends OutputInterface
{
    public function ln();
    public function writeColor( $messages, string $color = '', string $bgColor = '' );
}