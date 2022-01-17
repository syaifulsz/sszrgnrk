<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\components\configs\Config;
use app\services\Config\ConfigService;
use app\services\Service;

/**
 * Class ViewComponent
 * @package app\components
 */
class ViewComponent extends ComponentAbstract implements ViewInterface
{
    /**
     * @var Service
     */
    public $service;

    protected function init()
    {
        parent::init();
        $this->service = Service::getInstance();
        $this->configs = $this->service->getService( ConfigService::INSTANCE_NAME );
        $this->config = $this->configs->getConfigs();
        $this->request = RequestComponent::createFromGlobals();
    }

    /**
     * @var ConfigService
     */
    public $configs;

    /**
     * @var Config
     */
    public $config;

    /**
     * @var RequestComponent
     */
    public $request;

    /**
     * @var array
     */
    public $params = [];

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getParams( string $key, $default = null )
    {
        return data_get( $key, $this->params ) ?: $default;
    }

    /**
     * @param array $params
     */
    public function addParams( array $params = [] )
    {
        $this->params = array_replace_recursive( $this->params, $params );
    }

    /**
     * @param array $params
     */
    public function setParams( array $params = [] )
    {
        $this->params = $params;
    }

    /**
     * @var string
     */
    public $layout = '';
    public function setLayout( string $layout )
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return "layouts/{$this->layout}";
    }

    /**
     * @var array
     */
    public $templates = [];

    /**
     * @param string $templateName
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function render( string $templateName, array $params = [] )
    {
        if ( !isset( $this->templates[ $templateName ] ) ) {
            $template = "{$this->view_dir}/{$templateName}.php";
            $this->templates[ $templateName ] = $template;
        }

        if ( !file_exists( $template ) ) {
            throw new \Exception( "Template name {$templateName} is not exist!" );
        }

        extract( $params, EXTR_SKIP );
        ob_start();
        require( $template );
        $render = ob_get_contents();
        ob_end_clean();
        return $render;
    }

    /**
     * @return array
     * @TODO Render Layout Blocks
     */
    public function getLayoutParams()
    {
        return [];
    }

    /**
     * @var string
     */
    public $content = '';
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $templateName
     * @return string
     * @throws \Exception
     */
    public function renderAction( string $templateName )
    {
        $this->content = $this->render( $templateName );
        return $this->render( $this->getLayout() );
    }
}