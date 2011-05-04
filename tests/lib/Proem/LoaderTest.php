<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Loader.php';

class Proem_LoaderTest extends PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $loader = Proem\Loader::getInstance();
        $this->assertInstanceOf('Proem\Loader', $loader);
    }

    public function testAddExistingPath()
    {
        $loader = Proem\Loader::getInstance();

        $loader->addPath('.');
        $this->assertTrue(
            in_array('.', explode(PATH_SEPARATOR, get_include_path()))
        );
    }

    public function testAddNonExistingPath()
    {
        $loader = Proem\Loader::getInstance();

        $loader->addPath('/somepaththatshouldntexist');
        $this->assertFalse(
            in_array('/somepaththatshouldntexist', explode(PATH_SEPARATOR, get_include_path()))
        );
    }

    public function testCanLoad()
    {
        $loader = Proem\Loader::getInstance();
        $loader->addPath('lib'); //adds the Proem/lib directory.
        $loader->load('Proem\Proem');
        $this->assertEquals('0.0.2', Proem\Proem::VERSION);
    }
}
