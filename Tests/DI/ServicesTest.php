<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 20/11/14
 * Time: 3:20 PM
 */

namespace Core\Tests\DI;

use Core\DI\Service;

class ServicesTest extends \PHPUnit_Framework_TestCase {


    /**
     * @param $name string
     * @param $definition mixed
     * @param $shared bool
     *
     * @dataProvider providerTestConstructReturnSupplied
     */
    public function testConstructReturnSupplied($name, $definition, $shared)
    {
        $service = new Service($name, $definition, $shared);

        $resultDef = $service->getDefinition();
        $this->assertEquals($definition, $resultDef);

        $resultShared = $service->getShared();
        $this->assertEquals($shared, $resultShared);

    }


    public function providerTestConstructReturnSupplied()
    {
        $request = $this->getMockBuilder('Core\\Request\\Request');
        $core = $this->getMockBuilder('Core\\Core');
        return [
            ['Request', $request, true],
            ['Core', $core, true]
        ];
    }

} 
