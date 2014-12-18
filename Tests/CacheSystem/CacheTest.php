<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 17/12/14
 * Time: 12:31 AM
 */

namespace Core\Tests\CacheSystem;


use Core\CacheSystem\Cache;
use Core\Request\Request;

class CacheTest extends \PHPUnit_Framework_TestCase
{

    public function testIfCacheExists()
    {
        $cache = new Cache();
        $request = new Request();
        $cache->deleteCache('Request');
        $cache->cacheContent('Request', $request, 100000);
        $this->assertTrue($cache->cacheExists('Request'));

        return $cache;
    }

    /**
     * @depends testIfCacheExists
     */
    public function testIfCacheReturnObject(Cache $cache)
    {
        $request = $cache->getCache('Request');
        $this->assertInstanceOf('Core\\Request\\Request', $request);
    }

}
