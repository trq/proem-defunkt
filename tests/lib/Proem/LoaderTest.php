<?php

require_once 'PHPUnit/Framework.php';
require_once 'lib/Proem/Loader.php';

class Proem_LoaderTest extends PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $loader = Proem\Loader::getInstance();
        $this->assertType('Proem\Loader', $loader);
    }

    public function testAddExistingPath()
    {
        $loader = Proem\Loader::getInstance();

        $loader->addPath('/home');
        $this->assertTrue(
            in_array('/home', explode(PATH_SEPARATOR, get_include_path()))
        );
    }

    public function testAddNonExistingPath()
    {
        $loader = Proem\Loader::getInstance();

        $loader->addPath('/foo');
        $this->assertFalse(
            in_array('/foo', explode(PATH_SEPARATOR, get_include_path()))
        );
    }

    public function testCanLoad()
    {
        $loader = Proem\Loader::getInstance();
        $loader->addPath('lib'); //adds the Proem/lib directory.
        $loader->load('Proem\Proem');
    }
}