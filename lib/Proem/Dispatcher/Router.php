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
 * @package    Proem\Dispatcher\Router
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher;

/**
 * @category   Proem
 * @package    Proem\Dispatcher\Router
 */
class Router
{
    /**
     * Store the request url
     *
     * @var string
     */
    private $_requestUrl;

    /**
     * Store the base url
     *
     * @var string
     */
    private $_baseUrl = '';

    /**
     * Store our routes
     *
     * @var array
     */
    private $_routes;

    /**
     * Setup
     *
     * @param string $url
     */
    public function __construct(\Proem\IO\Url $url)
    {
        $this->_requestUrl = $url;
        $this->_routes = array();
    }

    /**
     * Set the base url
     *
     * @param string $path
     */
    public function setBaseUrl($path)
    {
        $this->_baseUrl = $path;
        return $this;
    }

    /**
     * Retrieve the base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }

    /**
     * Store route objects.
     *
     * @param array $options
     * @return \Proem\Dispatcher\Router
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
     * @return \Proem\Dispatcher\Command
     */
    public function route()
    {
        foreach ($this->_routes as $name => $data) {
            $route = $data['route'];
            $route->process($this->_requestUrl, $data['options']);
            if ($route->getMatchFound() && $route->getCommand()->isPopulated()) {
                break;
            }
        }
        return $route->getCommand();
    }
}
