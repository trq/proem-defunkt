<?php

/**
 * @category   Proem
 * @package    Proem\IO\Request
 */

/**
 * @namespace
 */
namespace Proem\IO;

/**
 * @category   Proem
 * @package    Proem\IO\Request
 */
class Request
{
    /**
     * Controller
     *
     * @var string
     */
    protected $_controller;

    /**
     * Action
     *
     * @var string
     */
    protected $_action;

    /**
     * Request parameters
     *
     * @var array
     */
    protected $_params = array();

    /**
     * Retrieve the controller name
     *
     * @return string
     */
    public function getController()
    {
        if (null === $this->_controller) {
            $this->_controller = $this->getParam('controller');
        }

        return $this->_controller;
    }

    /**
     * Set the controller
     *
     * @param string $value
     * @return Proem\IO\Request\AbstractRequest
     */
    public function setController($value)
    {
        $this->_controller = $value;
        return $this;
    }

    /**
     * Retrieve the action
     *
     * @return string
     */
    public function getAction()
    {
        if (null === $this->_action) {
            $this->_action = $this->getParam('action');
        }

        return $this->_action;
    }

    /**
     * Set the action
     *
     * @param string $value
     * @return Proem\IO\Request\AbstractRequest
     */
    public function setAction($value)
    {
        $this->_action = $value;
        return $this;
    }

    /**
     * Get an action parameter
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        $key = (string) $key;
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }

        return $default;
    }

    /**
     * Set an action parameter
     *
     * A $value of null will unset the $key if it exists
     *
     * @param string $key
     * @param mixed $value
     * @return Proem\IO\Request\AbstractRquest
     */
    public function setParam($key, $value)
    {
        $key = (string) $key;
        if ((null === $value) && isset($this->_params[$key])) {
            unset($this->_params[$key]);
        } elseif (null !== $value) {
            $this->_params[$key] = $value;
        }

        return $this;
    }

    /**
     * Get all action parameters
     *
     * @return array
     */
     public function getParams()
     {
         return $this->_params;
     }

    /**
     * Set action parameters en masse; does not overwrite
     *
     * Null values will unset the associated key.
     *
     * @param array $array
     * @return Proem\IO\Request\AbstractRequest
     */
    public function setParams(Array $array)
    {
        $this->_params = $this->_params + (array) $array;

        foreach ($this->_params as $key => $value) {
            if (null === $value) {
                unset($this->_params[$key]);
            }
        }

        return $this;
    }

    /**
     * Clear (reset) the Request object.
     *
     * @return Proem\IO\Request\AbstractRequest
     */
    public function reset()
    {
	$this->_controller = null;
	$this->_actions = null;
	$this->_params = null;
        return $this;
    }
}
