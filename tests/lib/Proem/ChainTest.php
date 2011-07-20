<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Application.php';
require_once 'lib/Proem/Chain/Event/AbstractEvent.php';
require_once 'lib/Proem/Chain.php';

class Proem_ChainTest extends PHPUnit_Extensions_OutputTestCase
{
    private $_request;
    private $_response;
    private $_dispatch;

    public function setUp() {
        $this->_request = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $this->_response = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
        $this->_dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\AbstractEvent');
    }

    public function testCanRegisterSingleEvent() {
        $chain = new Proem\Chain(new Proem\Application);

        $chain->registerEvents(array('request' => $this->_request));
        $this->assertArrayHasKey('request', $chain->getEvents());
    }

    public function testCanRegisterMultipleEvents() {
        $chain = new Proem\Chain(new Proem\Application);

        $events = array(
            'request' => $this->_request,
            'response' => $this->_response,
            'dispatch' => $this->_dispatch
        );

        $chain->registerEvents($events);

        $this->assertArrayHasKey('request', $chain->getEvents());
        $this->assertArrayHasKey('response', $chain->getEvents());
        $this->assertArrayHasKey('dispatch', $chain->getEvents());

    }

    public function testChainRun() {
        $chain = new Proem\Chain(new Proem\Application);

        $this->_request->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "request in, ";}));
        $this->_request->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "request out";}));

        $this->_response->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "response in, ";}));
        $this->_response->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "response out, ";}));

        $this->_dispatch->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "dispatch in, ";}));
        $this->_dispatch->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "dispatch out, ";}));

        $events = array(
            'request' => $this->_request,
            'response' => $this->_response,
            'dispatch' => $this->_dispatch
        );

        $chain->registerEvents($events);

        $this->expectOutputString('request in, response in, dispatch in, dispatch out, response out, request out');
        $chain->run();

    }

    public function testChainEventInjection() {
        $chain = new Proem\Chain(new Proem\Application);

        $this->_request->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "request in, ";}));
        $this->_request->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "request out";}));

        $this->_response->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "response in, ";}));
        $this->_response->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "response out, ";}));

        $this->_dispatch->expects($this->once())->method('in')->will($this->returnCallback(function() {echo "dispatch in, ";}));
        $this->_dispatch->expects($this->once())->method('out')->will($this->returnCallback(function() {echo "dispatch out, ";}));

        $events = array(
            'request' => $this->_request,
            'dispatch' => $this->_dispatch
        );

        $chain->registerEvents($events);

        $chain->registerEvents(array('response' => $this->_response), 'request');

        $this->expectOutputString('request in, response in, dispatch in, dispatch out, response out, request out');
        $chain->run();
    }
}
