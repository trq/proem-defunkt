<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Application.php';
require_once 'lib/Proem/Chain/Event/AbstractEvent.php';
require_once 'lib/Proem/Chain.php';

class Proem_ChainTest extends PHPUnit_Extensions_OutputTestCase
{
    public function testCanRegisterSingleEvent() {
        $chain = new Proem\Chain(new Proem\Application);

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');

        $chain->registerEvents(array('request' => $request));
        $this->assertArrayHasKey('request', $chain->getEvents());
    }

    public function testCanRegisterMultipleEvents() {
        $chain = new Proem\Chain(new Proem\Application);

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $response = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');

        $events = array(
            'request' => $request,
            'response' => $response,
            'dispatch' => $dispatch
        );

        $chain->registerEvents($events);

        $this->assertArrayHasKey('request', $chain->getEvents());
        $this->assertArrayHasKey('response', $chain->getEvents());
        $this->assertArrayHasKey('dispatch', $chain->getEvents());

    }

    public function testChainRun() {
        $chain = new Proem\Chain(new Proem\Application);

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $request->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "request in, ";}));
        $request->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "request out";}));

        $response = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $response->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "response in, ";}));
        $response->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "response out, ";}));

        $dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $dispatch->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "dispatch in, ";}));
        $dispatch->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "dispatch out, ";}));

        $events = array(
            'request' => $request,
            'response' => $response,
            'dispatch' => $dispatch
        );

        $chain->registerEvents($events);

        $this->expectOutputString('request in, response in, dispatch in, dispatch out, response out, request out');
        $chain->run();

    }

    public function testChainEventInjection() {
        $chain = new Proem\Chain(new Proem\Application);

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $request->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "request in, ";}));
        $request->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "request out";}));

        $response = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $response->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "response in, ";}));
        $response->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "response out, ";}));

        $dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $dispatch->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "dispatch in, ";}));
        $dispatch->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "dispatch out, ";}));

        $events = array(
            'request' => $request,
            'dispatch' => $dispatch
        );

        $chain->registerEvents($events);

        $chain->registerEvents(array('response' => $response), 'request');

        $this->expectOutputString('request in, response in, dispatch in, dispatch out, response out, request out');
        $chain->run();
    }
}
