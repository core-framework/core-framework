<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 22/11/14
 * Time: 8:47 AM
 */

namespace Core\Tests\DI;

use Core\DI\DI;

class DITest extends \PHPUnit_Framework_TestCase {


    public function testReferenceMatch()
    {
        $di = new DI();
        $di->register('_di', $di);
        $di->register('Smarty', '\\Smarty');
        $di->register('View', '\\Core\\Views\\View')
            ->setArguments(array('Smarty'));

        $a = $di->get('View');
        $a->set('showHeader', false);
        $b = $di->get('View');
        $b->set('showFooter', false);
        $c = $di->get('View');

        $this->assertEquals($a, $c);
        $this->assertEquals($b, $c);
    }

} 
