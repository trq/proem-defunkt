<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Dispatcher/Command.php';
require_once 'lib/Proem/Dispatcher.php';

class Proem_DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        $dispatcher = new \Proem\Dispatcher(
            new Proem\Dispatcher\Command
        );
	$this->assertInstanceOf('Proem\Dispatcher', $dispatcher);
    }

    public function testCanReturnCommand()
    {
	$dispatcher = new \Proem\Dispatcher(
            new Proem\Dispatcher\Command
        );
        $this->assertInstanceOf(
             'Proem\Dispatcher\Command',
              $dispatcher->getCommand()
        );
    }

    public function testIsGoodRouteDispatchable()
    {
        $command = new \Proem\Dispatcher\Command;
        $command->setParam('controller', 'Proem\Dispatcher\Command');
	    $command->setParam('action', 'setParam');
        $command->setParam('foo', 'bar');
        $dispatcher = new \Proem\Dispatcher($command);
        $this->assertTrue($dispatcher->isReady());
    }

    public function testIsBadRouteFixable()
    {
        $command = new \Proem\Dispatcher\Command;
        $command->setParam('controller', 'controller');
	    $command->setParam('action', 'action');
        $dispatcher = new \Proem\Dispatcher($command);
        $this->assertFalse($dispatcher->isReady());
    }
}
