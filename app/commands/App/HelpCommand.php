<?php

namespace app\commands\App;

use app\abstracts\CommandAbstract;
use app\components\configs\database\MysqlParam;
use app\components\ConsoleOutputInterface;
use app\components\RequestCliComponent;
use app\components\RouteItem;
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
        $output->writeColor( '<info>Help</info>' );
        $output->writeln( 'TODO: Need to list Route CLI' );

        return self::STATUS_SUCCESS;
    }
}