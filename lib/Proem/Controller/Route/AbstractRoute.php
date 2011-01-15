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
 * @package    Proem\Controller\Route\AbstractRoute
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * An Abstract Route Interface.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\AbstractRoute
 */
abstract class AbstractRoute
{
    /**
     * Store a flag indicating a route match
     *
     * @var bool
     */
    protected $_matched = false;

    /**
     * Store matched parameters within a Command object.
     *
     * @var Proem\Controller\Route\Command
     */
    protected $_command;

    /**
     * Setup the Command object.
     */
    public function __construct()
    {
        $this->_command = new \Proem\Controller\Command;
    }

    /**
     * Was a match found?
     *
     * @return bool
     */
    public function getMatchFound()
    {
        return $this->_matched;
    }

    /**
     * Set _matched flag.
     *
     * @return Proem\Controller\Route\AbstractRoute
     */
    public function setMatchFound($bool = true)
    {
        $this->_matched = $bool;
        return $this;
    }

    /**
     * Retrieve the Command object.
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Method to actually test for a match.
     *
     * If a match is found, $this->_matched should be set to true
     * and $this->_params needs to be set to contain the relevent
     * matched data.
     *
     * @param string $uri
     * @param array $options Options dependent on your implementation.
     */
    abstract public function process($uri, $options = array());
}
