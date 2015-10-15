<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 18/12/14
 * Time: 12:09 AM
 */

namespace Core\Tests\Config;


use Core\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConfig()
    {
        $config = new Config();
        $this->assertInstanceOf('Core\\Config\\Config', $config);
    }

}
