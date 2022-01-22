<?php

namespace app\commands\App;

use app\abstracts\CommandAbstract;
use app\components\ConsoleOutputInterface;
use app\components\RequestCliComponent;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HelpCommand
 * @package app\commands\App
 */
class HelpCommand extends CommandAbstract
{
    /**
     * @param RequestCliComponent $request
     * @param OutputInterface $output
     * @return string
     */
    public function actionIndex( RequestCliComponent $request, ConsoleOutputInterface $output )
    {
        // $output->writeColor( '<info>Hello!</info>' );
        // $output->writeColor( '<danger>This is an ERROR!</danger>' );
        // $output->writeln( __METHOD__ );
        // $output->writeln( $request->toJson() );

        return self::STATUS_SUCCESS;
    }
}