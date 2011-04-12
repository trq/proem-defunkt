<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <thorpe@thorpesystems.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

 */

/**
 * @category   Proem
 * @package    Proem\Dispatcher
 */

/**
 * @namespace
 */
namespace Proem;

/**
 * @category   Proem
 * @package    Proem\Dispatcher
 */
class Dispatcher
{
    private $_command;

    private $_isReady = false;

    public function __construct(\Proem\Dispatcher\Command $command)
    {
        $this->_command = $command;
        $this->_isExecutable();
    }

    public function isReady()
    {
        return $this->_isReady;
    }

    public function getCommand()
    {
        return $this->_command;
    }

    public function dispatch()
    {
        // actually execute the controller->action()
    }

    private function _isExecutable()
    {
        if ($this->_runTest()) {
            $this->_isReady = true;
        } else {
            $this->_injectDefaultController();
            if ($this->_runTest()) {
                $this->_isReady = true;
            }
        }
    }

    private function _runTest()
    {
        if (class_exists($this->_command->controller)) {
            if (method_exists($this->_command->controller, $this->_command->action)) {
                return true;
            }
	}
        return false;
    }

    private function _injectDefaultController()
    {
        $params = $this->_command->flatten();

        $params[0] = $params[2];
        unset($params[2]);

        $result = array('controller', 'index');
        foreach ($params as $param) {
            $result[] = $param;
        }

        $command = new \Proem\Dispatcher\Command;
        $command->setParams($result);

    }
}