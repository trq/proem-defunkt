<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <trq@proemframework.org>

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
 * @package    Proem\Dispatcher\Route\AbstractRoute
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher\Route;

/**
 * An Abstract Route Interface.
 *
 * @category   Proem
 * @package    Proem\Dispatcher\Route\AbstractRoute
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
     * @var Proem\Dispatcher\Route\Command
     */
    protected $_command;

    /**
     * Setup the Command object.
     */
    public function __construct()
    {
        $this->_command = new \Proem\Dispatcher\Command;
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
     * @return Proem\Dispatcher\Route\AbstractRoute
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
     * The functionality contained within this function
     * is currently duplicated within \Proem\IO\Url
     * this needs to be fixed.
     */
    public function createAssocArray($params)
    {
        $tmp = array();
        if (!is_array($params)) {
            $params = explode('/', trim($params, '/'));
        }
        for ($i = 0; $i <= count($params); $i = $i+2) {
            if (isset($params[$i+1])) {
                $tmp[(string) $params[$i]] = (string) $params[$i+1];
            } else {
                break;
            }
        }
        return $tmp;
    }

    /**
     * Method to actually test for a match.
     *
     * If a match is found, $this->_matched should be set to true
     * and $this->_params needs to be set to contain the relevent
     * matched data.
     *
     * @param \Proem\IO\Url $url
     * @param array $options Options dependent on your implementation.
     */
    abstract public function process(\Proem\IO\Url $url, $options = array());
}
