<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Exception.php';
require_once 'lib/Proem/Controller/Route/Command.php';
require_once 'lib/Proem/Controller/Route/AbstractRoute.php';
require_once 'lib/Proem/Controller/Route/Standard.php';

class ProemControllerRouteStandardTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Controller\Route\Standard;
        $this->_route->process('/foo/bar/a/b');
    }

    public function testParamKeysExist()
    {
        $this->assertEquals('foo', $this->_route->getCommand()->controller);
        $this->assertEquals('bar', $this->_route->getCommand()->action);
        $this->assertEquals('a/b', $this->_route->getCommand()->params);
    }
}