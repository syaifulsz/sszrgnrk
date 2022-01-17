<?php

namespace app\services\Cache;

use app\components\CacheInterface;
use app\components\MemcachedComponent;

/**
 * Class MemcachedService
 */
class MemcachedService extends MemcachedComponent implements CacheInterface
{
    const INSTANCE_NAME = 'AppCacheMemcached';
    const MEMCACHED_NAMESPACE = self::INSTANCE_NAME;

    protected function init()
    {
        parent::init();
        $this->setNamespace( self::MEMCACHED_NAMESPACE );
        $this->setup();
    }
}