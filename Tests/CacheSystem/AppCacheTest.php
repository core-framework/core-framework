<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 17/12/14
 * Time: 12:31 AM
 */

namespace Core\Tests\CacheSystem;


use Core\CacheSystem\AppCache;

class AppCacheTest extends \PHPUnit_Framework_TestCase
{
    public $cache;

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Cache Directory not defined!
     */
    public function testThrowsExceptionOnCacheExistsIfDirNotProvided()
    {
        AppCache::cacheExists('someKey');
    }

    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Cache Directory not defined!
     */
    public function testThrowsExceptionOnCacheContentIfDirNotProvided()
    {
        AppCache::cacheContent('SomeKey', 'SomeValue', 100);
    }

    /**
     * @expectedException \ErrorException
     * @expectedExceptionMessage Cache Directory not defined!
     */
    public function testThrowsExceptionOnGetCacheIfDirNotProvided()
    {
        AppCache::getCache('SomeKey');
    }

    public function testDirIsGivenIsFalseWhenDirNotProvided()
    {
        $this->assertNotTrue(AppCache::$dirIsGiven);
    }

    public function testCacheConstruct()
    {
        $this->assertInstanceOf('\\Core\\CacheSystem\\AppCache', new AppCache());
    }

    public function testIfDefaultDirIsSet()
    {
        AppCache::setCacheDir(_ROOT . '/storage/framework/cache/');
        $this->assertTrue(AppCache::$dirIsGiven);
    }

    public function testIfFalseIfNoCacheExists()
    {
        $this->assertNotTrue(AppCache::getCache('nonExistingCacheKey'));
    }

    public function testIfStringContentIsCached()
    {
        AppCache::cacheContent('SomeCacheKey', 'Some long a** text', 200);

        $str = AppCache::getCache('SomeCacheKey');
        $this->assertEquals('Some long a** text', $str);
    }

    public function testIfArrayContentIsCached()
    {
        $testArr = ['SomeArrKey' => 'SomeArrValue'];
        AppCache::cacheContent('SomeArrCacheKey', $testArr, 200);

        $arr = AppCache::getCache('SomeArrCacheKey');
        $this->assertEquals(json_encode($testArr), json_encode($arr));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object must implement Cacheable interface
     */
    public function testIfThrowsExceptionWhenNonCacheableObjectIsCached()
    {
        $object = (object) array('property1' => 1, 'property2' => 'b');
        AppCache::cacheContent('SomeObjCacheKey', $object, 200);
    }

    public function testIfCacheIsDeleted()
    {
        $this->assertTrue(AppCache::deleteCache('SomeArrCacheKey'));
        $this->assertTrue(AppCache::deleteCache('SomeCacheKey'));
    }
}
