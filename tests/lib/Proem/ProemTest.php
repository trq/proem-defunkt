<?php

require_once 'PHPUnit/Framework.php';
require_once 'lib/Proem/Proem.php';

class Proem_ProemTest extends PHPUnit_Framework_TestCase
{
    public function testVersion()
    {
        $this->assertEquals('0.0.1', Proem_Proem::VERSION);
    }
}