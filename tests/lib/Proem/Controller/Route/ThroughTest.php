<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Controller/Route/AbstractRoute.php';
require_once 'lib/Proem/Controller/Route/Through.php';

class ProemControllerRouteThroughTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Controller\Route\Through;
        $this->_route->process(
            '/some/uri/our/action/will/end/up/handling',
            array(
                'controller'    => 'foo',
                'action'        => 'bar'
            )
        );
    }

    public function testParamKeysExist()
    {
        $this->assertArrayHasKey(
            'controller', $this->_route->getParams()
        );

        $this->assertArrayHasKey(
            'action', $this->_route->getParams()
        );

        $this->assertArrayHasKey(
            'params', $this->_route->getParams()
        );
    }

    public function testParamValuesExistAndCanBeAccessed()
    {
        $this->assertEquals('foo', $this->_route->getParam('controller'));
        $this->assertEquals(
            '/some/uri/our/action/will/end/up/handling',
            $this->_route->getParam('params')
        );
    }
}