<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/10/15
 * Time: 10:58 AM
 */

namespace Core\CacheSystem;


interface CacheInterface
{

    /**
     * Cache File Contents
     *
     * @param $key
     * @param $payload
     * @param $ttl
     * @return mixed
     */
    public static function cacheContent($key, $payload, $ttl);

    /**
     * Get Cached File Contents
     *
     * @param $key
     * @return mixed
     */
    public static function getCache($key);

    /**
     * Check if given Cache exists
     *
     * @param $key
     * @return mixed
     */
    public static function cacheExists($key);

    /**
     * Delete given Cache file
     *
     * @param $key
     * @return mixed
     */
    public static function deleteCache($key);

    /**
     * Clear all cache (complete cache directory)
     *
     * @return mixed
     */
    public static function clearCache();

}