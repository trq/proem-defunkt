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

        $this->assertEquals('foo', $command->controller);
        $this->assertEquals('bar', $command->action);
        $this->assertEquals('a/b', $command->params);
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

        if ($command) {
            $this->assertEquals('foo', $command->controller);
            $this->assertEquals('bar', $command->action);
            $this->assertEquals('a/b', $command->params);
        } else {
            $this->fail("pattern that should have matched uri failed!");
        }
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

        if ($command) {
            $this->assertEquals('auth', $command->controller);
            $this->assertEquals('login', $command->action);
            $this->assertEmpty($command->params);
        } else {
            $this->fail("pattern that should have matched uri failed!");
        }
    }

    public function dataProvider()
    {
        return array(
            array('/', 'home', null, array()),
            array('/login', 'auth', 'login', array()),
            array('/logout', 'auth', 'logout', array())
         );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSeriesOfMappedRoutes($uri, $controller, $action, $params)
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

        $this->assertEquals($controller, $command->controller);
        $this->assertEquals($action, $command->action);
        $this->assertEquals($params, $command->params);

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

        $this->assertEquals('profile', $command->controller);
        $this->assertEquals('view', $command->action);
        $this->assertEquals(12, $command->id);
    }
}
