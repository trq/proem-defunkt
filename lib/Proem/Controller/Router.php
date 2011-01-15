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
 * @package    Proem\Controller\Router
 */

/**
 * @namespace
 */
namespace Proem\Controller;

/**
 * @category   Proem
 * @package    Proem\Controller\Router
 */
class Router
{
    /**
     * Store the request uri
     *
     * @var string
     */
    private $_requestUri;

    /**
     * Store the base uri
     *
     * @var string
     */
    private $_baseUri = '';

    /**
     * Store our routes
     *
     * @var array
     */
    private $_routes;

    /**
     * Setup
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->_requestUri = substr($uri, strlen($this->getBaseUri()));
        $this->_routes = array();
    }

    /**
     * Set the base uri
     *
     * @param string $path
     */
    public function setBaseUri($path)
    {
        $this->_baseDir = $path;
        return $this;
    }

    /**
     * Retrieve the base uri
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->_baseUri;
    }

    /**
     * Store route objects.
     *
     * @param array $options
     * @return \Proem\Controller\Router
     */
    public function map($name, Route\AbstractRoute $route, $options = array())
    {
        $this->_routes[$name]['route'] = $route;
        $this->_routes[$name]['options'] = $options;
        return $this;
    }

    /**
     * Test routes for matching route & return a Command object
     *
     * @return \Proem\Controller\Command
     */
    public function route()
    {
        foreach ($this->_routes as $name => $data) {
            $route = $data['route'];
            $route->process($this->_requestUri, $data['options']);
            if ($route->getMatchFound() && $route->getCommand()->isPopulated()) {
                break;
            }
        }
        return $route->getCommand();
    }
}
