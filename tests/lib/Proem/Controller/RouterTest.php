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

    public function testSeriesOfMappedRoutes()
    {
        $urls = array('/', '/login', '/logout', '/profile/view/thorpe', '/users/view/12');

        for ($i = 0; $i <= 4; $i++) {
            $router = new \Proem\Controller\Router($urls[$i]);
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
            )->map(
                'profile',
                new \Proem\Controller\Route\Map,
                array(
                    'rule' => '/profile/:action/:username',
                    'target' => array('controller' => 'profile')
                )
            )->map(
                'profile-by-id',
                new \Proem\Controller\Route\Map,
                array(
                    'rule' => '/users/:action/:id',
                    'target' => array('controller' => 'profile')
                )
            )->route();

            if ($command) {
                switch($i) {
                    case 0:
                        $this->assertEquals('home', $command->controller);
                        $this->assertEmpty($command->action);
                        $this->assertEmpty($command->params);
                        break;
                    case 1:
                        $this->assertEquals('auth', $command->controller);
                        $this->assertEquals('login', $command->action);
                        $this->assertEmpty($command->params);
                        break;
                    case 2:
                        $this->assertEquals('auth', $command->controller);
                        $this->assertEquals('logout', $command->action);
                        $this->assertEmpty($command->params);
                        break;
                    case 3:
                        $this->assertEquals('profile', $command->controller);
                        $this->assertEquals('view', $command->action);
                        $this->assertEquals('thorpe', $command->username);
                        break;
                    case 4:
                        $this->assertEquals('profile', $command->controller);
                        $this->assertEquals('view', $command->action);
                        $this->assertEquals(12, $command->id);
                        break;
                }
            } else {
                $this->fail("pattern that should have matched uri failed!");
            }
        }
    }
}
