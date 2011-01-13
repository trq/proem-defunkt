<?php

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