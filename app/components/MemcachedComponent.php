<?php

namespace app\components;

use app\abstracts\ComponentAbstract;
use app\components\configs\Config;
use app\services\Config\ConfigService;
use app\services\Service;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class MemcachedComponent
 * @package app\components
 */
class MemcachedComponent extends ComponentAbstract implements CacheInterface
{
    /**
     * @var Service
     */
    public $service;

    /**
     * @var Config
     */
    public $configs;

    /**
     * @var TagAwareAdapter
     */
    public $cache;

    /**
     * @var \Memcached
     */
    public $client;

    /**
     * @var string
     */
    public $namespace;
    public function setNamespace( string $namespace )
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    protected function init()
    {
        parent::init();
        $this->service = Service::getInstance();
        $this->configs = $this->service->getService( ConfigService::INSTANCE_NAME )->getConfigs();
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function setup()
    {
        $this->client = MemcachedAdapter::createConnection( $this->configs->memcached->getServers()->toArray() );
        $cache = new MemcachedAdapter( $this->client, $this->namespace );
        $this->cache = new TagAwareAdapter( $cache );
    }

    /**
     * @param string $key
     * @param $value
     * @param int $duration
     * @param array $tags
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function set( string $key, $value, int $duration = 0, array $tags = [] )
    {
        return $this->cache->get( $key, function ( ItemInterface $item ) use ( $value, $duration, $tags ) {

            $item->expiresAfter( $duration );

            if ( $tags ) {
                $item->tag( $tags );
            }

            if ( is_callable( $value ) ) {
                return $value();
            }

            return $value;
        } );
    }

    /**
     * @param string $key
     * @param null $default
     * @param bool $asItem
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function get( string $key, $default = null, bool $asItem = false )
    {
        if ( $asItem ) {
            return $this->cache->getItem( $key );
        }

        return $this->cache->get( $key, function ( ItemInterface $item ) use ( $default ) {
            return ( is_null( $item ) ? $default : $item );
        } );
    }

    /**
     * @param string $key
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function delete( string $key )
    {
        $this->cache->delete( $key );
    }

    /**
     * @param string|array $tags
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function invalidateTags( $tags )
    {
        $this->cache->invalidateTags( $tags );
    }

    public function reset()
    {
        $this->cache->reset();
    }
}