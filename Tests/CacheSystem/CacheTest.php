<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 17/12/14
 * Time: 12:31 AM
 */

namespace Core\Tests\CacheSystem;


use Core\CacheSystem\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->cache = new Cache();
    }

    public function testCreateCache()
    {
        $this->assertInstanceOf('\\Core\\CacheSystem\\Cache', $this->cache);
    }

}
