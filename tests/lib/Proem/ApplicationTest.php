<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Application.php';
require_once 'lib/Proem/Chain/AbstractChain.php';
require_once 'lib/Proem/Chain/Event/AbstractEvent.php';
require_once 'lib/Proem/Chain.php';

class Proem_ApplicationTest extends PHPUnit_Framework_TestCase
{
    private $_application;

    public function setUp()
    {
        parent::setUp();

        $this->_application = new Proem\Application;
    }

    public function testChainIsAvailable()
    {
        $this->assertInstanceOf(
            'Proem\Chain\AbstractChain',
            $this->_application->getChain()
        );
    }

    public function testSetGetResource()
    {
        $this->_application->setResource('foo', 'foo');
        $this->assertEquals('foo', $this->_application->getResource('foo'));
    }
}
