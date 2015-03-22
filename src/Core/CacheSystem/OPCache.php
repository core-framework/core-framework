<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 09/02/15
 * Time: 2:09 AM
 */

namespace Core\CacheSystem;


class OPCache extends BaseCache
{

    public function cacheContent($key, $payload, $ttl)
    {
        return apc_store($key, $payload, $ttl);
    }

    public function getCache($key)
    {
        return apc_fetch($key);
    }

    public function cacheExists($key)
    {
        return apc_exists($key);
    }

    public function deleteCache($key)
    {
        return apc_delete($key);
    }

    public function clearCache()
    {
        return apc_clear_cache();
    }
}