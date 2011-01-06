<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/IO/Response/AbstractResponse.php';

class Proem_AbstractResponseTest extends PHPUnit_Framework_TestCase
{
    private $_response;

    public function setUp()
    {
	parent::setUp();

	$this->_response = $this->getMockForAbstractClass(
            'Proem\IO\Response\AbstractResponse'
        );
    }

    public function testCanSetAndGetBody()
    {
	$this->assertInstanceOf(
            'Proem\IO\Response\AbstractResponse',
            $this->_response->setBody('foo')
        );

	$this->assertEquals('foo', $this->_response->getBody());
    }

    public function testCanSend()
    {
        ob_start();
        $this->_response->send();
        $ob = ob_end_clean();

        $this->assertEquals('foo', $ob);
    }

    public function testEchoToString()
    {
        ob_start();
        echo $this->_response;
        $ob = ob_end_clean();

        $this->assertEquals('foo', $ob);
    }

}
