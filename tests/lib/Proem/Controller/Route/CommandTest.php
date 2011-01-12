<?php

require_once 'PHPUnit/Autoload.php';
require_once 'lib/Proem/Controller/Route/Command.php';

class ProemCommandTest extends PHPUnit_Framework_TestCase
{
    public function testParseParams()
    {
        $command = new Proem\Controller\Route\Command;
        $command->params = array('foo', 'bar', 'a', 'b', 'c');

        $params = $command->parseParams();

        $this->assertEquals('bar', $params['foo']);
        $this->assertFalse(isset($params['c']));
    }
}