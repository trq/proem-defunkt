<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Exception.php';
require_once 'lib/Proem/Controller/Command/AbstractCommand.php';
require_once 'lib/Proem/Controller/Command.php';
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
        $this->assertEquals('foo', $this->_route->getCommand()->getParam('controller'));
        $this->assertEquals('bar', $this->_route->getCommand()->getParam('action'));
        $this->assertEquals('b', $this->_route->getCommand()->getParam('a'));
    }
}