<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Exception.php';
require_once 'lib/Proem/Controller/Route/AbstractRoute.php';
require_once 'lib/Proem/Controller/Route/Standard.php';

class ProemControllerRouteStandardTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Controller\Route\Standard;
        $this->_route->process('/foo/bar/a/b');
        print_r($this->_route->getParams());
    }

    public function testParamKeysExist()
    {
        /*
        $this->assertArrayHasKey(
            'controller', $this->_route->getParams()
        );

        $this->assertArrayHasKey(
            'action', $this->_route->getParams()
        );

        $this->assertArrayHasKey(
            'params', $this->_route->getParams()
        );*/

        //print_r($this->_route->getParams());

    }
}