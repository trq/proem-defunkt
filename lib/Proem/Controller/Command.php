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
 * @package    Proem\Controller\Command
 */

/**
 * @namespace
 */
namespace Proem\Controller;

/**
 * Store the controller, action and params.
 *
 * @category   Proem
 * @package    Proem\Controller\Command
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
     * The array which setParams() accepts *MUST* be non-associative. If you want
     * keys to associate to values, place them next to each other within the array.
     *
     * @param array $params This array *MUST* be non-associative.
     */
    public function setParams(Array $params)
    {
        if (is_array($params) && !$this->_isAssoc($params)) {
            $tmp = array();
            for ($i = 0; $i <= count($params); $i = $i+2) {
                if (isset($params[$i+1])) {
                    $tmp[(string) $params[$i]] = (string) $params[$i+1];
                } else {
                    break;
                }
            }
            $this->_data = array_merge($this->_data, $tmp);
        } else {
            throw new Exception(
                "Associative array passed to setParams()."
            );
        }
    }

    public function getParam($name, $default = false)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return $default;
    }

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
    private function _isAssoc(Array $array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}