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
    private $_populated = false;

    private $_data = array();

    public function __construct()
    {
        // Must exist.
        $this->_data['controller'] = null;
        $this->_data['action'] = null;
    }

    public function setParam($name, $value) {
        // params is a special case passed in via the _Router_
        if ($name == 'params') {
            if (is_array($value) && !$this->_isAssoc($value)) {
                $this->_data = array_merge($this->_data, $this->_parseParams($value));
            } else {
                throw new Exception(
                    "The 'params' parameter is a special case and *must* be a non-associative array"
                );
            }
        } else {
            $this->_data[$name] = $value;
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
        $tmp = array();
        for ($i = 0; $i <= count($params); $i = $i+2) {
            if (isset($params[$i+1])) {
                $tmp[$params[$i]] = $params[$i+1];
            } else {
                break;
            }
        }
        return $tmp;
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