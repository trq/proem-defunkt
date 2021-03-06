<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/IO/Response.php';

class Proem_ResponseTest extends PHPUnit_Framework_TestCase
{
    private $_response;

    public function setUp()
    {
	    parent::setUp();
        $this->_response = new Proem\IO\Response;
        $this->_response->setBody('foo');
    }

    public function testInstance()
    {
	    $this->assertInstanceOf(
            'Proem\IO\Response',
            $this->_response
        );

	    $this->assertEquals('foo', $this->_response->getBody());
    }

    public function testCanSend()
    {
        ob_start();
        $this->_response->send();
        $ob = ob_get_clean();

        $this->assertEquals('foo', $ob);
    }

    public function testEchoToString()
    {
        ob_start();
        echo $this->_response;
        $ob = ob_get_clean();

        $this->assertEquals('foo', $ob);
    }

}
