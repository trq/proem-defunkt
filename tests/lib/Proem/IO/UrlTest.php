<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/IO/Url.php';

class Proem_UrlTest extends PHPUnit_Framework_TestCase
{
    private $_url;

    public function setUp()
    {
        $this->_url = new \Proem\IO\Url('http://domain.com/foo/is/bar/bar/is/good/extra');
    }

    public function testGetter()
    {
        $this->assertEquals($this->_url->getScheme(), 'http');
        $this->assertEquals($this->_url->getHost(), 'domain.com');
        $this->assertEquals($this->_url->getPath(), '/foo/is/bar/bar/is/good/extra');
    }

    public function testStash()
    {
        $this->assertEquals('extra', $this->_url->getStash());
    }

    public function testAsString()
    {
        $this->assertEquals($this->_url->getAsString(), 'http://domain.com/foo/is/bar/bar/is/good/extra');
    }

    public function testPathAsArray()
    {
        $this->assertTrue(is_array($this->_url->getPathAsArray()));
        $this->assertContains('foo', $this->_url->getPathAsArray());
        $this->assertContains('good', $this->_url->getPathAsArray());
    }

    public function testCanCreateAssoc()
    {
        $this->assertTrue(is_array($this->_url->getPathAsAssoc()));
        $this->assertArrayHasKey('foo', $this->_url->getPathAsAssoc());
        $this->assertArrayHasKey('bar', $this->_url->getPathAsAssoc());
        $this->assertArrayHasKey('is', $this->_url->getPathAsAssoc());
    }

    public function testStripsBaseUrl()
    {
        $this->_url->setBaseUrl('/foo');
        $this->assertArrayHasKey('is', $this->_url->getPathAsAssoc());
        $parts = $this->_url->getPathAsArray();
        $this->assertEquals($parts[0], 'is');
    }

}
