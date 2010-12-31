<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Chain.php';
require_once 'lib/Proem/Chain/ChainAbstract.php';
require_once 'lib/Proem/Chain/Event/EventAbstract.php';

class Proem_ChainTest extends PHPUnit_Framework_TestCase
{
    public function testCanRegisterSingleEvent() {
        $chain = new Proem\Chain;

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');

        $chain->registerEvent('request', new $request);

        $this->assertArrayHasKey('request', $chain->getEvents());
    }

    public function testCanRegisterMultipleEvents() {
        $chain = new Proem\Chain;

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');
        $response = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');
        $dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');

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
        $chain = new Proem\Chain;

        $request = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');
        $request->expects($this->once())->method('in','out');

        $response = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');
        $response->expects($this->once())->method('in','out');

        $dispatch = $this->getMockForAbstractClass('Proem\Chain\Event\EventAbstract');
        $dispatch->expects($this->once())->method('in','out');

        $events = array(
            'request' => $request,
            'response' => $response,
            'dispatch' => $dispatch
        );

        $chain->registerEvents($events);

        $chain->run();

    }
}