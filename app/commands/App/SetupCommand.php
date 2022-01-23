<?php

namespace app\commands\App;

use app\abstracts\CommandAbstract;
use app\components\configs\database\MysqlParam;
use app\components\ConsoleColorInterface;
use app\components\ConsoleOutputInterface;
use app\components\RequestCliComponent;

/**
 * Class SetupCommand
 * @package app\commands\App
 */
class SetupCommand extends CommandAbstract
{
    /**
     * @param RequestCliComponent $request
     * @param ConsoleOutputInterface $output
     * @return string
     */
    public function actionIndex( RequestCliComponent $request, ConsoleOutputInterface $output )
    {
        $output->writeColor( "<warning>Database Configuration</warning>" );
        $output->ln();

        /**
         * @var $mysqlDb MysqlParam
         */
        foreach ( $this->configs->database->getDatabases() as $keyDb => $mysqlDb ) {
            $output->writeColor( "   {$keyDb}", ConsoleColorInterface::COLOR_GREEN  );
            $output->writeln( "   -------" );
            $output->writeln( "   Host                : " . $mysqlDb->host );
            $output->writeln( "   DB Name             : " . $mysqlDb->database );
            $output->writeln( "   Username            : " . $mysqlDb->username );
            $output->writeln( "   Password            : " . $mysqlDb->password );
            $output->writeln( "   Port                : " . $mysqlDb->port );
            $output->ln();
        }

        return self::STATUS_SUCCESS;
    }
}