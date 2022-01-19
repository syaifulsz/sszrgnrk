<?php

namespace app\commands\App;

use app\abstracts\CommandAbstract;
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
    public function actionIndex( RequestCliComponent $request, OutputInterface $output )
    {
        $output->writeln( __METHOD__ );
        $output->writeln( $request->toJson() );

        return self::STATUS_SUCCESS;
    }
}