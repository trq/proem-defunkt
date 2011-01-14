<?php

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
     * If the name of the parameter is 'params' it is considered a special case
     * and its value (an array) will be processed seperately.
     *
     * @see _parseParams.
     *
     * @param string $name
     * @param string|array $value
     * @return Command
     */
    public function setParam($name, $value) {
        if ($name == 'params') {
            $this->_parseParams($value);
        } else {
            $this->_data[$name] = (string) $value;
        }
        return $this;
    }

    public function getParam($name, $default = false) {
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

    private function _parseParams($params)
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
                "The 'params' parameter is a special case and *must* be a non-associative array"
            );
        }
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