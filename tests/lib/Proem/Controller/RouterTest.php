<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Exception.php';
require_once 'lib/Proem/Controller/Command/AbstractCommand.php';
require_once 'lib/Proem/Controller/Command.php';
require_once 'lib/Proem/Controller/Route/AbstractRoute.php';
require_once 'lib/Proem/Controller/Route/Map.php';
require_once 'lib/Proem/Controller/Router.php';

class ProemControllerRouterTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultMapedRoute()
    {
        $router = new \Proem\Controller\Router('/foo/bar/a/b');
        $command = $router->map(
            'default',
            new \Proem\Controller\Route\Map
        )->route();

        $this->assertEquals('foo', $command->getParam('controller'));
        $this->assertEquals('bar', $command->getParam('action'));
        $this->assertEquals('b', $command->getParam('a'));
    }

    public function testVerboseDefaultMapedRoute()
    {
        $router = new \Proem\Controller\Router('/foo/bar/a/b');
        $command = $router->map(
            'simple',
            new \Proem\Controller\Route\Map,
            array(
                'rule'     => '/:controller/:action/:params',
                'target'    => array(),
                'filter'    => array('params' => '([a-zA-Z0-9_\+\-%\/]+)')
            )
        )->route();

        $this->assertInstanceOf('\Proem\Controller\Command', $command);
        $this->assertEquals('foo', $command->getParam('controller'));
        $this->assertEquals('bar', $command->getParam('action'));
        $this->assertEquals('b', $command->getParam('a'));

    }

    public function testTargetedMapedRoute()
    {
        $router = new \Proem\Controller\Router('/login');
        $command = $router->map(
             'simple',
             new \Proem\Controller\Route\Map,
             array(
                'rule'     => '/login',
                'target'    => array('controller' => 'auth', 'action' => 'login')
            )
        )->route();

        $this->assertInstanceOf('\Proem\Controller\Command', $command);
        $this->assertEquals('auth', $command->getParam('controller'));
        $this->assertEquals('login', $command->getParam('action'));
        $this->assertFalse($command->getParam('doesntexist'));
    }

    public function dataProvider()
    {
        return array(
            array('/', 'home', null),
            array('/login', 'auth', 'login'),
            array('/logout', 'auth', 'logout')
         );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSeriesOfMappedRoutes($uri, $controller, $action)
    {
        $router = new \Proem\Controller\Router($uri);
        $command = $router
        ->map(
            'home-page',
            new \Proem\Controller\Route\Map,
            array(
                'rule' => '/',
                'target' => array('controller' => 'home')
            )
        )->map(
            'login',
            new \Proem\Controller\Route\Map,
            array(
                'rule' => '/login',
                'target' => array('controller' => 'auth', 'action' => 'login')
            )
        )->map(
            'logout',
            new \Proem\Controller\Route\Map,
            array(
                'rule' => '/logout',
                'target' => array('controller' => 'auth', 'action' => 'logout')
            )
        )->route();

        $this->assertInstanceOf('\Proem\Controller\Command', $command);

        $this->assertEquals($controller, $command->getParam('controller'));
        $this->assertEquals($action, $command->getParam('action'));


    }

    public function testAnotherMappedRoute()
    {
        $router = new \Proem\Controller\Router('/user/view/12');
        $command = $router
        ->map(
            'profile',
            new \Proem\Controller\Route\Map,
            array(
                'rule' => '/user/:action/:id',
                'target' => array('controller' => 'profile'),
                'filter' => array('id' => '[\d]{1,8}')
            )
        )->route();

        $this->assertInstanceOf('\Proem\Controller\Command', $command);

        $this->assertEquals('profile', $command->getParam('controller'));
        $this->assertEquals('view', $command->getParam('action'));
        $this->assertEquals(12, $command->getParam('id'));
    }
}
