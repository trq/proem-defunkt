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
 * @package    Proem\Dispatcher\Command
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher;

/**
 * Store the controller, action and params.
 *
 * @category   Proem
 * @package    Proem\Dispatcher\Command
 */
class Command
{
    /**
     * A flag to keep note as to wether or not this _Command_ is populated
     * with data.
     *
     * @var bool
     */
    private $_populated = false;

    /**
     * Store the actual data.
     *
     * @var array
     */
    private $_data = array();

    /**
     * A simple proxie to getParam()
     *
     * @param string $name
     */
    public function __get($name)
    {
        return $this->getParam($name);
    }

    /**
     * A simple proxie to setParam()
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        return $this->setParam($name, $value);
    }

    /**
     * Initialize the _data array.
     */
    public function __construct()
    {
        $this->_data['controller'] = null;
        $this->_data['action'] = null;
    }

    /**
     * Store a parameter.
     *
     * @param string $name
     * @param string|array $value
     * @return Command
     */
    public function setParam($name, $value)
    {
        $this->_data[$name] = (string) $value;
        return $this;
    }

    /**
     * Store multiple params.
     *
     * @param array $params
     */
    public function setParams(Array $params)
    {
        if ($this->_isAssoc($params)) {
            $params = $this->_flatten($params);
        }
        $tmp = array();
        for ($i = 0; $i <= count($params); $i = $i+2) {
            if (isset($params[$i+1])) {
                $tmp[(string) $params[$i]] = (string) $params[$i+1];
            } else {
                break;
            }
        }
        $this->_data = array_merge($this->_data, $tmp);
    }

    /**
     * Retrieve a parameter or an optional default.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getParam($name, $default = false)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return $default;
    }

    /**
     * Retrieve all parameters as an associative array.
     *
     * @return array
     */
    public function geParams()
    {
        return $this->_data;
    }

    /**
     * Stores a simple flag.
     *
     * This should be set to true once you have set
     * all parameters on the _Command_ object.
     * @param <type> $flag
     * @return Command
     */
    public function isPopulated($flag = null)
    {
        if (is_null($flag)) {
            return $this->_populated;
        } else {
            $this->_populated = $flag;
        }
        return $this;
    }

    /**
     * http://stackoverflow.com/questions/173400/php-arrays-a-good-way-to-check-if-an-array-is-associative-or-sequential
     *
     * @param array $array
     * @return bool
     */
    private function _isAssoc(Array $array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Flatten an associative array into a numerically indexed array.
     *
     * @param array $a
     * @return array
     */
    private function _flatten(Array $a)
    {
        $tmp = array();
        foreach ($a as $k => $v) {
            $tmp[] = $k;
            $tmp[] = $v;
        }
        return $tmp;
    }
}