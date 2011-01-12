<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Controller/Command/AbstractCommand.php';
require_once 'lib/Proem/Controller/Command.php';
require_once 'lib/Proem/Controller/Route/AbstractRoute.php';
require_once 'lib/Proem/Controller/Route/Fixed.php';

class ProemControllerRouteThroughTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Controller\Route\Fixed;
        $this->_route->process(
            '/some/uri/our/action/will/end/up/handling',
            array(
                'controller'    => 'foo',
                'action'        => 'bar'
            )
        );
    }

    public function testParamsExist()
    {
        $this->assertEquals('foo', $this->_route->getCommand()->controller);
        $this->assertEquals('bar', $this->_route->getCommand()->action);
        $this->assertEquals(
            '/some/uri/our/action/will/end/up/handling',
            $this->_route->getCommand()->params
        );
    }
}