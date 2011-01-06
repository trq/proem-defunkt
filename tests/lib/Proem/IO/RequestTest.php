<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/IO/Request.php';

class Proem_RequestTest extends PHPUnit_Framework_TestCase
{
    private $_request;

    public function setUp()
    {
	parent::setUp();

	$this->_request = new Proem\IO\Request;
    }

    public function testCanSetAndGetController()
    {
	$this->assertInstanceOf(
            'Proem\IO\Request',
            $this->_request->setController('foo')
        );
        
	$this->assertEquals('foo', $this->_request->getController());
    }

    public function testCanSetAndGetAction()
    {
	$this->assertInstanceOf(
            'Proem\IO\Request',
            $this->_request->setAction('foo')
        );

	$this->assertEquals('foo', $this->_request->getAction());
    }

    public function testCanGetAndSetSingleParam()
    {
        $this->assertInstanceOf(
            'Proem\IO\Request',
            $this->_request->setParam('foo', 'bar')
        );

        $this->assertEquals('bar', $this->_request->getParam('foo'));
    }

    public function testCanGetDefaultParam()
    {
        $this->assertEquals('what', $this->_request->getParam('the', 'what'));
    }

    public function testCanResetRequest()
    {
        $this->_request->reset();
        $this->assertEmpty($this->_request->getParams());
    }

    public function testCanGetAndSetMultipleParams()
    {
        $this->assertInstanceOf(
            'Proem\IO\Request',
            $this->_request->setParams(
                array(
                    'foo' => 'bar',
                    'boo' => 'bob'
                )
            )
        );

        $this->assertContains('bar', $this->_request->getParams());
        $this->assertContains('bob', $this->_request->getParams());
    }

}
