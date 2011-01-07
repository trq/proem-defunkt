<?php

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
     * Store matched parameters
     *
     * @var array
     */
    protected $_params = array();

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
     * Retrieve a parameter.
     *
     * @param string $key
     * @param mixed Default return value if $key not found.
     * @return string
     */
    public function getParam($key, $default = null)
    {
        return isset($this->_params[$key]) ? $this->_params[$key] : $default;
    }

    /**
     * Retrieve all parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Set a parameter.
     *
     * @param string $key
     * @param mixed $value
     * @return Proem\Controller\Route\AbstractRoute
     */
    public function setParam($key, $value)
    {
        $this->_params[$key] = $value;
        return $this;
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