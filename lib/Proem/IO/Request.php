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
