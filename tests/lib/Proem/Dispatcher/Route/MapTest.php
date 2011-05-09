<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/IO/Url.php';
require_once 'lib/Proem/Exception.php';
require_once 'lib/Proem/Dispatcher/Command.php';
require_once 'lib/Proem/Dispatcher/Route/AbstractRoute.php';
require_once 'lib/Proem/Dispatcher/Route/Map.php';

class ProemControllerRouteMapTest extends PHPUnit_Framework_TestCase
{
    private $_route;

    public function setUp()
    {
        $this->_route = new Proem\Dispatcher\Route\Map;
        $url = new \Proem\IO\Url('http://domain.com/foo/bar/a/b');
        print_r($url);
        $this->_route->process($url,
            array(
                'rule'     => '/:controller/:action/:params',
                'target'    => array(),
                'filter'    => array('params' => '(.*)')
            )
        );
    }

    public function testParamKeysExist()
    {
        $this->assertTrue($this->_route->getCommand()->isPopulated());
        $this->assertEquals('foo', $this->_route->getCommand()->getParam('controller'));
        $this->assertEquals('bar', $this->_route->getCommand()->getParam('action'));
        $this->assertEquals('b', $this->_route->getCommand()->getParam('a'));
    }
}
