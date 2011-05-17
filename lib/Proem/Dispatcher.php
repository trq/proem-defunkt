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
    /**
     * Store a count of _dispatch_ attempts.
     *
     * @var int
     */
    private $_attempts = 0;

    /**
     * For each attempt, store a command object.
     *
     * @var array
     */
    private $_commands = array();

    /**
     * The url object.
     *
     * @var \Proem\IO\Url
     */
    private $_url;

    /**
     * Store a flag indicating wether or not the current
     * command is read for dispatching.
     *
     * @var bool
     */
    private $_isReady = false;

    /**
     * Instantiate the Dispatcher
     *
     * @param \Proem\IO\Url $url
     * @param \Proem\Dispatcher\Command $command
     */
    public function __construct(\Proem\IO\Url $url, \Proem\Dispatcher\Command $command)
    {
        $this->_url = $url;
        $this->_commands[] = $command;
        $this->_isExecutable();
    }

    /**
     * Check if the current command is ready for dispatching.
     *
     * @return bool
     */
    public function isReady()
    {
        return $this->_isReady;
    }

    /**
     * Retrieve the current _Command_ object.
     *
     * @return \Proem\Dispatcher\Command
     */
    public function getCommand()
    {
        return array_pop($this->_commands);
    }

    /**
     * Get an array of all _Command_ objects that might have
     * been created during the _dispatch_ process.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->_commands;
    }

    /**
     * Hand control over to the controller object.
     */
    public function dispatch()
    {
        // actually execute the controller->action()
    }

    /**
     * Test to see if the current _Command_ is dispatchable, if not
     * attempt to inject some defaults and try again.
     *
     * @return bool
     */
    private function _isExecutable()
    {
        if ($this->_runTest()) {
            $this->_isReady = true;
        } else {
            // $this->_isExecutable();
            $this->_injectDefaultController();
            if ($this->_runTest()) {
                $this->_isReady = true;
            }
        }
    }

    /**
     * Test to see if the current _Command_ is dispatchable.
     *
     * @return bool
     */
    private function _runTest()
    {
        $this->_attempts++;
        if (class_exists($this->_commands[$this->_attempts-1]->controller)) {
            if (method_exists($this->_commands[$this->_attempts-1]->controller, $this->_commands[$this->_attempts-1]->action)) {
                return true;
            }
	    }
        return false;
    }

    /**
     * Inject the default controller & action into a newly created
     * _Command_ object.
     *
     * @return void
     */
    private function _injectDefaultController()
    {
        $params = $this->_url->getPathAsAssoc();
        $params = array_merge(array('controller' => 'index'), $params);

        $this->_commands[$this->_attempts] = new \Proem\Dispatcher\Command;
        $this->_commands[$this->_attempts]->setParams($params);

    }
}
