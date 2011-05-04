<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Proem.php';

class Proem_ProemTest extends PHPUnit_Framework_TestCase
{
    public function testVersion()
    {
        $this->assertEquals('0.0.2', Proem\Proem::VERSION);
    }
}
