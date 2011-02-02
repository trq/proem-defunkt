<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Controller/Command.php';

class ProemCommandTest extends PHPUnit_Framework_TestCase
{
    public function testParseParams()
    {
        $command = new Proem\Controller\Command;
        $command->setParams(array('foo', 'bar', 'a', 'b', 'c'));
        $command->isPopulated(true);

        $this->assertTrue($command->isPopulated());
        $this->assertEquals('bar', $command->getParam('foo'));
        $this->assertFalse($command->getParam('c'));
    }
}