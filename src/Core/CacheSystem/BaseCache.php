<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 09/02/15
 * Time: 2:17 AM
 */

namespace Core\CacheSystem;


abstract class BaseCache
{

    abstract public function cacheContent($key, $payload, $ttl);

    abstract public function getCache($key);

    abstract public function cacheExists($key);

    abstract public function deleteCache($key);

    abstract public function clearCache();

    /**
     * Check if string is $key hash
     *
     * @param string $key
     * @return int
     */
    public function isValidMd5($key = '')
    {
        return preg_match('/^[a-f0-9_]{32}$/', $key);
    }
}