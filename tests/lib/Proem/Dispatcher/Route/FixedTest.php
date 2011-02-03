<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Dispatcher/Command.php';
require_once 'lib/Proem/Dispatcher/Route/AbstractRoute.php';
require_once 'lib/Proem/Dispatcher/Route/Fixed.php';

class ProemControllerRouteFixedTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Dispatcher\Route\Fixed;
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
        $this->assertTrue($this->_route->getCommand()->isPopulated());
        $this->assertEquals('foo', $this->_route->getCommand()->getParam('controller'));
        $this->assertEquals('bar', $this->_route->getCommand()->getParam('action'));
    }
}