<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Application.php';
require_once 'lib/Proem/Chain.php';

class Proem_ApplicationTest extends PHPUnit_Framework_TestCase
{
    private $_application;

    public function setUp()
    {
        parent::setUp();

        $this->_application = Proem\Application::getInstance();
    }

    public function testChainIsAvailable()
    {
        $this->assertInstanceOf(
            'Proem\Chain\ChainAbstract',
            $this->_application->getChain()
        );
    }

    public function testSetGetResource()
    {
        $this->_application->setResource('foo', 'foo');
        $this->assertEquals('foo', $this->_application->getResource('foo'));
    }
}