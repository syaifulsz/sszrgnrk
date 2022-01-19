<?php

namespace app\abstracts;

ignore_user_abort( 1 );

use app\components\ConfigComponent;
use app\components\ConsoleOutputComponent;
use app\components\ConsoleOutputInterface;
use app\components\RequestCliComponent;
use app\components\StrComponent;
use app\services\Cache\MemcachedService;
use app\services\Config\ConfigService;
use app\traits\ComponentTrait;
use app\services\Service;
use Carbon\Carbon;
use Symfony\Component\Console\Input\InputInterface;
use app\components\ConsoleColorInterface;

/**
 * Abstract CommandAbstract
 * @package app\abstracts
 */
abstract class CommandAbstract
{
    const STATUS_SUCCESS = 'STATUS_SUCCESS';
    const STATUS_UNKNOWN = 'STATUS_UNKNOWN';
    const STATUS_ERROR   = 'STATUS_ERROR';
    const STATUS_SUCCESS_NAME = 'Success';
    const STATUS_UNKNOWN_NAME = 'Unknown';
    const STATUS_ERROR_NAME   = 'Error';

    use ComponentTrait;

    public static $logo = <<<LOGO
 SSZ                  _    
  _ __ __ _ _ __  _ __| | __
 | '__/ _` | '_ \| '__| |/ /
 | | | (_| | | | | |  |   < 
 |_|  \__, |_| |_|_|  |_|\_\
      |___/ v
LOGO;

    /**
     * @return string
     */
    public function getLogo()
    {
        return self::$logo . $this->configs->app->version;
    }

    /**
     * @var array
     */
    public $origin = [];

    /**
     * @var ConfigComponent
     */
    public $config;

    /**
     * @var \app\components\configs\Config|array
     */
    public $configs;

    /**
     * @var RequestCliComponent
     */
    public $request;

    /**
     * @var InputInterface
     */
    public $input;

    /**
     * @var ConsoleOutputInterface
     */
    public $output;

    /**
     * @var Service
     */
    public $service;

    /**
     * @var MemcachedService
     */
    public $cache;

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @param \Exception $error
     */
    public function addError( \Exception $error )
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        $messages = [];

        /**
         * @var $error \Exception
         */
        foreach ( $this->errors as $error ) {
            $messages[] = '[' . $error->getCode() . ' ' . $error->getFile() . ':' . $error->getLine() . '] ' . $error->getMessage();
        }

        return $messages;
    }


    /**
     * @param array $props
     */
    public function __construct( array $props = [] )
    {
        $props = $this->initBefore( $props );
        $this->origin  = $props;
        $this->setProps( $props );

        // app service instance
        $this->service = Service::getInstance();

        // command config
        $this->config  = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->configs = $this->config->getConfigs();

        // command cache
        $this->cache   = $this->service->getService( MemcachedService::INSTANCE_NAME );

        // command request
        $this->request = RequestCliComponent::createFromGlobals();

        // command output
        $this->output = new ConsoleOutputComponent();

        $this->init();
        $this->initAfter();
    }

    protected function init()
    {

    }

    /**
     * @param array $props
     * @return array
     */
    protected function initBefore( array $props = [] )
    {
        return $props;
    }

    protected function initAfter()
    {

    }

    /**
     * @param string $method
     * @param array $args
     * @return false|mixed
     * @throws \Exception
     */
    public function __call( string $method, array $args )
    {
        $beginAtTime = Carbon::now()->format( 'Y-m-d g:i A' );
        $command = $this->request->command;

        $refClass = new \ReflectionClass( $this );
        $controller = $refClass->getName();

        $actionMethod = 'action' . StrComponent::studly( $method );

        if ( !method_exists( $this, $actionMethod ) ) {
            throw new \Exception( "Oops! The method {$method} you looking for is not exist!" );
        }

        $this->output->ln();
        $this->output->writeln( $this->getLogo() );
        $this->output->ln( 2 );

        $beginAt = microtime( true );

        $status = self::STATUS_ERROR;

        try {
            $status = call_user_func_array( [ $this, $actionMethod ], array_merge( [ 'request' => $this->request, 'output' => $this->output ], $args ) );
        } catch ( \Error $e ) {
            $this->output->writeColor( "<danger>[RGNRK] ERROR: Message " . $e->getMessage() . '</danger>' );
            $this->output->writeColor( "<danger>[RGNRK] ERROR: Line    " . $e->getLine() . '</danger>' );
            $this->output->writeColor( "<danger>[RGNRK] ERROR: File    " . $e->getFile() . '</danger>' );
            $this->output->writeColor( "<danger>[RGNRK] ERROR: Code    " . $e->getCode() . '</danger>' );
            $this->output->ln();
        }

        $endAtTime = Carbon::now()->format( 'Y-m-d g:i A' );
        $endAt = microtime( true );
        $execTime = round( (float)( $endAt - $beginAt ) / 60, 1 );

        $this->output->writeln( "[RGNRK] Command:      {$command}" );
        $this->output->writeln( "[RGNRK] Controller:   {$controller}" );
        $this->output->writeln( "[RGNRK] Method:       {$actionMethod}" );
        $this->output->writeln( "[RGNRK] Params:       {$this->request->getParams()->toJson()}" );
        $this->output->writeln( "[RGNRK] Begin at:     {$beginAtTime}" );
        $this->output->writeln( "[RGNRK] End at:       {$endAtTime}" );
        $this->output->writeln( "[RGNRK] Time elapsed: {$execTime} min" );

        if ( is_null( $status ) ) {
            $this->output->writeln( "<warning>[RGNRK] WARNING:      Command need to return STATUS_SUCCESS or STATUS_ERROR!</warning>" );
            $status = self::STATUS_UNKNOWN;
        }

        if ( !$status && ( $errors = $this->getErrorMessages() ) ) {
            foreach ( $errors as $error ) {
                $this->output->writeColor( "<danger>[RGNRK] ERROR:       {$error}</danger>" );
            }
        }

        switch ( $status ) {
            case self::STATUS_SUCCESS :
                $statusColor = 'success';
                break;
            case self::STATUS_ERROR :
                $statusColor = 'danger';
                break;
            default :
                $statusColor = 'warning';
        }

        $statusName = $this->getStatusName( $status );
        $this->output->writeColor( "<{$statusColor}>[RGNRK] Status:       {$statusName}</{$statusColor}>" );
        $this->output->ln();

        return $status;
    }

    /**
     * @param string $status
     * @return string
     */
    public function getStatusName( string $status )
    {
        return constant( "self::{$status}_NAME" );
    }
}