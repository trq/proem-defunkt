<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Controller/Command/AbstractCommand.php';
require_once 'lib/Proem/Controller/Command.php';

class ProemCommandTest extends PHPUnit_Framework_TestCase
{
    public function testParseParams()
    {
        $command = new Proem\Controller\Command;
        $command->params = array('foo', 'bar', 'a', 'b', 'c');

        $params = $command->parseParams();

        $this->assertEquals('bar', $params['foo']);
        $this->assertFalse(isset($params['c']));
    }
}